/**
 * block-editor.js — Quill editor with fully custom toolbar
 */
document.addEventListener('DOMContentLoaded', () => {

    const routes     = window.PLANOVA?.blockRoutes;
    const blockable  = window.PLANOVA?.blockable;
    const initBlocks = window.PLANOVA?.initialBlocks ?? [];
    const savingEl   = document.getElementById('block-saving');

    if (!routes || !blockable || !window.Quill) return;

    // ── Register custom font / size attributors ────────────────

    const FontAttributor = Quill.import('attributors/class/font');
    FontAttributor.whitelist = [
        'times-new-roman','arial','helvetica','georgia',
        'courier-new','verdana','trebuchet-ms','palatino',
        'garamond','comic-sans','impact','tahoma',
    ];
    Quill.register(FontAttributor, true);

    const SizeStyle = Quill.import('attributors/style/size');
    SizeStyle.whitelist = [
        '8px','9px','10px','11px','12px','14px','16px',
        '18px','20px','24px','28px','32px','36px','48px','72px',
    ];
    Quill.register(SizeStyle, true);

    // ── Init Quill (no toolbar module — we drive it manually) ──

    const quill = new Quill('#quill-editor', {
        theme:   'snow',
        modules: {
            toolbar: false,   // disable built-in toolbar
            history: { delay: 500, maxStack: 200 },
        },
        placeholder: 'Mulai menulis…',
    });

    // Set default font on editor container
    quill.root.style.fontFamily = "'Times New Roman', serif";
    quill.root.style.fontSize   = '12pt';

    // ── Load existing content ─────────────────────────────────

    function blocksToHtml(blocks) {
        return blocks.map(b => {
            const c = b.content ?? {};
            // If block was saved as Quill HTML, return directly
            if (c.html) return c.text ?? '';
            switch (b.type) {
                case 'heading': {
                    const lvl = c.level ?? 2;
                    return `<h${lvl}>${c.text ?? ''}</h${lvl}>`;
                }
                case 'todo':
                    return `<p>${c.checked ? '☑' : '☐'} ${c.text ?? ''}</p>`;
                case 'bullet_list':
                    return `<ul><li>${c.text ?? ''}</li></ul>`;
                case 'divider':
                    return `<hr>`;
                case 'table': {
                    const ths = (c.headers ?? []).map(h => `<th>${h}</th>`).join('');
                    const rows = (c.rows ?? []).map(r =>
                        `<tr>${r.map(cell => `<td>${cell}</td>`).join('')}</tr>`
                    ).join('');
                    return `<table><thead><tr>${ths}</tr></thead><tbody>${rows}</tbody></table>`;
                }
                default:
                    return `<p>${c.text ?? ''}</p>`;
            }
        }).join('') || '';
    }

    const initialHtml = blocksToHtml(initBlocks);
    if (initialHtml) {
        quill.clipboard.dangerouslyPasteHTML(initialHtml);
    }

    let savedBlockId = initBlocks[0]?.id ?? null;

    // ── Auto-save ─────────────────────────────────────────────

    let saveTimer = null;

    function showSaving() {
        if (!savingEl) return;
        savingEl.innerHTML = '<i class="bi bi-arrow-repeat mr-1 animate-spin"></i>Menyimpan…';
        savingEl.style.opacity = '1';
    }
    function hideSaving() {
        if (!savingEl) return;
        savingEl.innerHTML = '<i class="bi bi-cloud-check mr-1"></i>Tersimpan';
        setTimeout(() => { savingEl.style.opacity = '0'; }, 2500);
    }

    async function persistContent() {
        const html = quill.root.innerHTML;
        const csrf = document.querySelector('meta[name="csrf-token"]').content;
        const body = JSON.stringify({ content: { text: html, html: true } });
        const headers = {
            'Content-Type': 'application/json',
            'Accept': 'application/json',
            'X-CSRF-TOKEN': csrf,
        };

        try {
            if (savedBlockId) {
                await fetch(`${routes.update}/${savedBlockId}`, { method:'PUT', headers, body });
            } else {
                const res = await fetch(routes.store, {
                    method: 'POST', headers,
                    body: JSON.stringify({
                        blockable_type: blockable.type,
                        blockable_id:   blockable.id,
                        type: 'text',
                        content: { text: html, html: true },
                    }),
                });
                const data = await res.json();
                savedBlockId = data.block?.id ?? data.id ?? null;
            }
            hideSaving();
        } catch(err) {
            console.error('Save failed:', err);
            hideSaving();
        }
    }

    quill.on('text-change', () => {
        showSaving();
        clearTimeout(saveTimer);
        saveTimer = setTimeout(persistContent, 1200);
    });

    // ── Custom toolbar wiring ──────────────────────────────────

    // Track last known selection — restored before every format command
    // so toolbar clicks (which blur the editor) still apply correctly.
    let lastRange = null;

    quill.on('selection-change', (range) => {
        if (range) {
            lastRange = range;
            syncActiveStates();
        }
    });

    /** Restore focus + selection, then run a callback that calls quill.format() */
    function withSelection(fn) {
        // Re-focus editor
        quill.focus();
        // Restore saved range if editor lost focus (getSelection() returns null after blur)
        const current = quill.getSelection();
        if (!current && lastRange) {
            quill.setSelection(lastRange.index, lastRange.length, 'silent');
        }
        fn();
    }

    // Font family select
    const fontSel = document.getElementById('rte-font');
    const fontMap = {
        'times-new-roman': "'Times New Roman', serif",
        'arial':           'Arial, sans-serif',
        'helvetica':       'Helvetica, Arial, sans-serif',
        'georgia':         'Georgia, serif',
        'courier-new':     "'Courier New', monospace",
        'verdana':         'Verdana, Geneva, sans-serif',
        'trebuchet-ms':    "'Trebuchet MS', sans-serif",
        'palatino':        "'Palatino Linotype', Palatino, serif",
        'garamond':        "Garamond, serif",
        'comic-sans':      "'Comic Sans MS', cursive",
        'impact':          'Impact, Charcoal, sans-serif',
        'tahoma':          'Tahoma, Geneva, sans-serif',
    };
    // mousedown instead of change — fires before blur
    fontSel?.addEventListener('mousedown', () => { lastRange = quill.getSelection() ?? lastRange; });
    fontSel?.addEventListener('change', () => {
        withSelection(() => quill.format('font', fontSel.value || false));
    });

    // Font size select
    const sizeSel = document.getElementById('rte-size');
    sizeSel?.addEventListener('mousedown', () => { lastRange = quill.getSelection() ?? lastRange; });
    sizeSel?.addEventListener('change', () => {
        withSelection(() => quill.format('size', sizeSel.value ? `${sizeSel.value}px` : false));
    });

    // Toggle format buttons (bold, italic, underline, strike, list, align, indent, blockquote, code-block)
    document.querySelectorAll('#rte-toolbar .rte-fmt-btn').forEach(btn => {
        btn.addEventListener('mousedown', e => {
            e.preventDefault(); // critical: prevents editor blur on mousedown
            lastRange = quill.getSelection() ?? lastRange; // capture before any focus change

            const fmt = btn.dataset.fmt;
            const val = btn.dataset.val;
            if (!fmt) return;

            withSelection(() => {
                if (fmt === 'link') {
                    const url = prompt('URL link:', 'https://');
                    if (url) quill.format('link', url);
                    return;
                }

                if (['bold','italic','underline','strike','blockquote','code-block'].includes(fmt)) {
                    const current = quill.getFormat()[fmt];
                    quill.format(fmt, !current);
                    btn.classList.toggle('is-active', !current);
                    return;
                }

                if (fmt === 'script') {
                    const current = quill.getFormat()['script'];
                    quill.format('script', current === val ? false : val);
                    return;
                }

                if (fmt === 'align') {
                    quill.format('align', val || false);
                    syncActiveStates();
                    return;
                }

                if (fmt === 'list') {
                    const current = quill.getFormat()['list'];
                    quill.format('list', current === val ? false : val);
                    syncActiveStates();
                    return;
                }

                if (fmt === 'indent') {
                    quill.format('indent', val);
                    return;
                }
            });
        });
    });

    // Text color
    const colorBtn   = document.getElementById('rte-color-btn');
    const colorInput = document.getElementById('rte-color-input');
    const colorBar   = document.getElementById('rte-color-bar');
    colorBtn?.addEventListener('mousedown', e => {
        e.preventDefault();
        lastRange = quill.getSelection() ?? lastRange;
        colorInput.click();
    });
    colorInput?.addEventListener('input', () => {
        colorBar.style.background = colorInput.value;
        withSelection(() => quill.format('color', colorInput.value));
    });

    // Highlight / background color
    const bgBtn   = document.getElementById('rte-bg-btn');
    const bgInput = document.getElementById('rte-bg-input');
    const bgBar   = document.getElementById('rte-bg-bar');
    bgBtn?.addEventListener('mousedown', e => {
        e.preventDefault();
        lastRange = quill.getSelection() ?? lastRange;
        bgInput.click();
    });
    bgInput?.addEventListener('input', () => {
        bgBar.style.background = bgInput.value;
        withSelection(() => quill.format('background', bgInput.value));
    });

    // Clear formatting
    document.getElementById('rte-clear')?.addEventListener('mousedown', e => {
        e.preventDefault();
        lastRange = quill.getSelection() ?? lastRange;
        withSelection(() => {
            const range = quill.getSelection();
            if (range) quill.removeFormat(range.index, range.length);
        });
    });

    // ── Sync active states when cursor moves ──────────────────

    function syncActiveStates() {
        const fmt = quill.getFormat();

        document.querySelectorAll('#rte-toolbar .rte-fmt-btn[data-fmt]').forEach(btn => {
            const f = btn.dataset.fmt;
            const v = btn.dataset.val;
            let active = false;

            if (['bold','italic','underline','strike','blockquote','code-block'].includes(f)) {
                active = !!fmt[f];
            } else if (f === 'align') {
                active = (fmt.align ?? '') === (v ?? '');
            } else if (f === 'list') {
                active = fmt.list === v;
            } else if (f === 'script') {
                active = fmt.script === v;
            }
            btn.classList.toggle('is-active', active);
        });

        if (fontSel && fmt.font)  fontSel.value = fmt.font;
        if (sizeSel && fmt.size)  sizeSel.value = fmt.size.replace('px','');
        if (colorBar && fmt.color)       colorBar.style.background = fmt.color;
        if (bgBar    && fmt.background)  bgBar.style.background    = fmt.background;
    }

}); // end DOMContentLoaded
