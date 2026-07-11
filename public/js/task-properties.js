/**
 * task-properties.js
 * Full spec implementation:
 *  - Status grouped dropdown (dark, 3 fixed groups, custom options)
 *  - Select dropdown (search, create-on-fly, drag-reorder, edit-option sub-popup)
 *  - Add Property dark popup (name input, AI hint, type grid)
 *  - Edit Property panel (dark slide-in, grouped options, DEFAULT badge, wrap toggle)
 *  - Color picker (dark, swatch palette)
 */

document.addEventListener('DOMContentLoaded', () => {

    /* ── Shared state & helpers ──────────────────────────────── */

    const CSRF   = () => document.querySelector('meta[name="csrf-token"]').content;
    const routes = window.PLANOVA?.propRoutes;
    const taskId = window.PLANOVA?.taskId;
    if (!routes || !taskId) return;

    async function api(url, method = 'GET', body = null) {
        const r = await fetch(url, {
            method,
            headers: { 'Content-Type':'application/json','Accept':'application/json','X-CSRF-TOKEN':CSRF() },
            body: body ? JSON.stringify(body) : null,
        });
        if (!r.ok) throw new Error(`HTTP ${r.status}`);
        return r.json();
    }

    const uid = () => crypto.randomUUID ? crypto.randomUUID()
        : 'xxxxxxxx-xxxx-4xxx-yxxx-xxxxxxxxxxxx'.replace(/[xy]/g, c => {
            const r = Math.random() * 16 | 0;
            return (c==='x' ? r : (r&0x3|0x8)).toString(16);
        });

    const esc = s => String(s).replace(/&/g,'&amp;').replace(/</g,'&lt;').replace(/>/g,'&gt;').replace(/"/g,'&quot;');

    async function saveValue(propId, value) {
        try { return await api(`${routes.values}/${propId}/values`, 'POST', { task_id:taskId, value: value??null }); }
        catch(e) { console.error('saveValue:', e); }
    }
    async function clearValue(propId) {
        try { await api(`${routes.values}/${propId}/values/${taskId}`, 'DELETE'); }
        catch(e) { console.error('clearValue:', e); }
    }

    /* close all dark popups except one */
    const allPopups = ['status-dropdown','select-dropdown','add-prop-popup','edit-option-popup','prop-color-picker'];
    function closeAll(except = null) {
        allPopups.forEach(id => {
            if (id !== except) document.getElementById(id)?.classList.add('hidden');
        });
    }

    function positionBelow(popup, anchor) {
        const rect = anchor.getBoundingClientRect();
        const pw   = popup.offsetWidth || 260;
        let   left = rect.left + window.scrollX;
        if (left + pw > window.innerWidth - 8) left = window.innerWidth - pw - 8;
        popup.style.top  = `${rect.bottom + window.scrollY + 6}px`;
        popup.style.left = `${Math.max(8, left)}px`;
    }

    document.addEventListener('click', e => {
        // close all dark popups on outside click
        const inside = allPopups.some(id => document.getElementById(id)?.contains(e.target));
        const isPropPanel = document.getElementById('prop-panel')?.contains(e.target);
        if (!inside && !isPropPanel) closeAll();
    });

    document.addEventListener('keydown', e => {
        if (e.key === 'Escape') { closeAll(); closePanel(); }
    });


    /* ══════════════════════════════════════════════════════════
       STATUS DROPDOWN
       ══════════════════════════════════════════════════════════ */

    const statusDropdown   = document.getElementById('status-dropdown');
    const statusGroups     = document.getElementById('status-groups');
    const statusActiveBadge = document.getElementById('status-active-badge');
    const statusEditBtn    = document.getElementById('status-edit-prop-btn');

    // The "Status" property is the first property of type 'status' or the built-in task status column.
    // For the built-in status cell (not a custom property), we show hardcoded groups.
    // For a custom property of type 'status', we use its config.

    let activeStatusPropId  = null; // null = built-in task status
    let activeStatusTrigger = null;
    let activeStatusConfig  = null;

    const BUILT_IN_STATUS_OPTIONS = {
        'todo':        { label:'Belum Dimulai', color:'#ef4444', group:'To-do' },
        'in_progress': { label:'Dalam Proses',  color:'#eab308', group:'In progress' },
        'done':        { label:'Selesai',        color:'#22c55e', group:'Complete' },
    };

    // Wire the built-in status cell
    document.querySelector('.status-cell-trigger')?.addEventListener('click', function(e) {
        e.stopPropagation();
        activeStatusPropId  = null;
        activeStatusTrigger = this;
        activeStatusConfig  = null;
        renderStatusDropdown(this.dataset.taskStatus, null);
        positionBelow(statusDropdown, this);
        closeAll('status-dropdown');
        statusDropdown.classList.remove('hidden');
    });

    // Wire custom 'status' type property cells (delegated)
    document.addEventListener('click', e => {
        const btn = e.target.closest('.prop-select-trigger[data-property-type="status"]');
        if (!btn) return;
        e.stopPropagation();
        const propId  = btn.dataset.propertyId;
        const th      = document.querySelector(`.prop-col-header[data-property-id="${propId}"]`);
        let   config  = {};
        try { config = JSON.parse(th?.dataset.propertyConfig || '{}'); } catch(_) {}
        activeStatusPropId  = propId;
        activeStatusTrigger = btn;
        activeStatusConfig  = config;
        renderStatusDropdown(btn.dataset.currentValue, config);
        positionBelow(statusDropdown, btn);
        closeAll('status-dropdown');
        statusDropdown.classList.remove('hidden');
    });

    function renderStatusDropdown(currentValue, config) {
        statusGroups.innerHTML = '';
        const GROUPS = ['To-do', 'In progress', 'Complete'];

        // Determine options source
        const getOptions = () => {
            if (config?.options?.length) return config.options;
            // Built-in fallback
            return Object.entries(BUILT_IN_STATUS_OPTIONS).map(([k, v]) => ({
                id: k, label: v.label, color: v.color, group: v.group,
            }));
        };
        const options = getOptions();

        // Update active badge
        const activeOpt = options.find(o => o.id === currentValue);
        if (activeOpt) {
            statusActiveBadge.style.backgroundColor = activeOpt.color;
            statusActiveBadge.innerHTML = `<span class="w-1.5 h-1.5 rounded-full bg-white/40 shrink-0"></span>${esc(activeOpt.label)}`;
        } else {
            statusActiveBadge.style.backgroundColor = '#475569';
            statusActiveBadge.innerHTML = '— pilih';
        }

        GROUPS.forEach(group => {
            const groupOpts = options.filter(o => (o.group ?? '') === group);

            const section = document.createElement('div');
            section.className = 'mb-1';
            section.innerHTML = `<div class="px-3 pt-2 pb-1 text-[10px] font-bold uppercase tracking-wider text-slate-500">${esc(group)}</div>`;

            groupOpts.forEach(opt => {
                const btn = document.createElement('button');
                btn.type = 'button';
                btn.className = 'w-full flex items-center gap-2 px-3 py-1.5 hover:bg-white/10 transition-colors cursor-pointer rounded-lg mx-1 text-left';
                btn.style.width = 'calc(100% - 8px)';
                const isActive = opt.id === currentValue;
                btn.innerHTML = `
                    <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-bold text-white flex-1"
                          style="background-color:${esc(opt.color ?? '#6b7280')};">
                        <span class="w-1.5 h-1.5 rounded-full bg-white/40 shrink-0"></span>
                        ${esc(opt.label)}
                    </span>
                    ${isActive ? '<svg class="w-3.5 h-3.5 text-white shrink-0" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3"><polyline points="20 6 9 17 4 12"/></svg>' : ''}`;

                btn.addEventListener('click', async () => {
                    statusDropdown.classList.add('hidden');
                    applyStatusValue(opt);
                });
                section.appendChild(btn);
            });

            statusGroups.appendChild(section);
        });
    }

    async function applyStatusValue(opt) {
        if (!activeStatusTrigger) return;

        const badgeHtml = `<span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-bold text-white" style="background-color:${esc(opt.color??'#6b7280')}"><span class="w-1.5 h-1.5 rounded-full bg-white/40 shrink-0"></span>${esc(opt.label)}</span>`;

        if (activeStatusPropId === null) {
            // Built-in task status — update via task update route
            activeStatusTrigger.innerHTML = badgeHtml;
            activeStatusTrigger.dataset.taskStatus = opt.id;
            try {
                await api(`/tasks/${taskId}/status`, 'PATCH', { status: opt.id });
            } catch(_) {}
        } else {
            // Custom status property
            activeStatusTrigger.dataset.currentValue = opt.id;
            activeStatusTrigger.innerHTML = badgeHtml;
            await saveValue(activeStatusPropId, opt.id);
        }
    }

    statusEditBtn?.addEventListener('click', () => {
        statusDropdown.classList.add('hidden');
        // Open Edit Property Panel for the status property
        if (activeStatusPropId) {
            const th = document.querySelector(`.prop-col-header[data-property-id="${activeStatusPropId}"]`);
            if (th) openPanel(th);
        }
    });


    /* ══════════════════════════════════════════════════════════
       SELECT DROPDOWN (search, create, drag, edit-option popup)
       ══════════════════════════════════════════════════════════ */

    const selectDropdown    = document.getElementById('select-dropdown');
    const selectActiveHdr   = document.getElementById('select-active-header');
    const selectSearchInput = document.getElementById('select-search-input');
    const selectOptionsList = document.getElementById('select-options-list');
    const selectCreateHint  = document.getElementById('select-create-hint');
    const selectCreateBtn   = document.getElementById('select-create-btn');
    const selectCreateLabel = document.getElementById('select-create-label');

    let activeSelectTrigger = null;
    let activeSelectPropId  = null;
    let activeSelectConfig  = {};

    // Wire existing select triggers (plain 'select' type, not 'status')
    function wireSelectTriggers() {
        document.querySelectorAll('.prop-select-trigger[data-property-type="select"], .prop-select-trigger:not([data-property-type])').forEach(btn => {
            if (btn.dataset.wired) return;
            btn.dataset.wired = '1';
            btn.addEventListener('click', e => {
                e.stopPropagation();
                if (btn.dataset.propertyType === 'status') return; // handled above
                openSelectDropdown(btn);
            });
        });
    }
    wireSelectTriggers();

    function openSelectDropdown(trigger) {
        const propId = trigger.dataset.propertyId;
        const th     = document.querySelector(`.prop-col-header[data-property-id="${propId}"]`);
        let   config = {};
        try { config = JSON.parse(th?.dataset.propertyConfig || '{}'); } catch(_) {}

        activeSelectTrigger = trigger;
        activeSelectPropId  = propId;
        activeSelectConfig  = config;

        renderSelectDropdown(trigger.dataset.currentValue ?? '');
        positionBelow(selectDropdown, trigger);
        closeAll('select-dropdown');
        selectDropdown.classList.remove('hidden');
        selectSearchInput.value = '';
        selectSearchInput.focus();
    }

    function renderSelectDropdown(currentValue, filter = '') {
        selectActiveHdr.innerHTML   = '';
        selectOptionsList.innerHTML = '';

        // Active tag
        const opts    = activeSelectConfig?.options ?? [];
        const activeOpt = opts.find(o => o.id === currentValue);
        if (activeOpt) {
            const tag = document.createElement('div');
            tag.className = 'inline-flex items-center gap-1 px-2 py-0.5 rounded-full text-xs font-bold text-white';
            tag.style.backgroundColor = activeOpt.color ?? '#6b7280';
            tag.innerHTML = `${esc(activeOpt.label)}<button type="button" class="ml-1 opacity-70 hover:opacity-100 text-white cursor-pointer leading-none" data-clear-select>×</button>`;
            tag.querySelector('[data-clear-select]').addEventListener('click', async e => {
                e.stopPropagation();
                activeSelectTrigger.dataset.currentValue = '';
                activeSelectTrigger.innerHTML = '<span class="text-xs text-text-muted italic">— pilih</span>';
                selectDropdown.classList.add('hidden');
                await clearValue(activeSelectPropId);
            });
            selectActiveHdr.appendChild(tag);
        }

        // Filter options
        const filtered = filter
            ? opts.filter(o => o.label.toLowerCase().includes(filter.toLowerCase()))
            : opts;

        // Show create hint
        const exactMatch = opts.some(o => o.label.toLowerCase() === filter.toLowerCase());
        if (filter && !exactMatch) {
            selectCreateLabel.textContent = `"${filter}"`;
            selectCreateHint.classList.remove('hidden');
        } else {
            selectCreateHint.classList.add('hidden');
        }

        filtered.forEach(opt => {
            const row = document.createElement('div');
            row.className = 'flex items-center gap-2 px-2 py-1 rounded-lg hover:bg-white/10 transition-colors group/opt cursor-pointer';
            row.innerHTML = `
                <span class="drag-handle text-slate-600 cursor-grab opacity-0 group-hover/opt:opacity-100 transition-opacity select-none text-xs">⠿⠿</span>
                <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-bold text-white flex-1" style="background-color:${esc(opt.color??'#6b7280')}">
                    <span class="w-1.5 h-1.5 rounded-full bg-white/40 shrink-0"></span>${esc(opt.label)}
                </span>
                ${opt.id === currentValue ? '<svg class="w-3 h-3 text-white shrink-0" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3"><polyline points="20 6 9 17 4 12"/></svg>' : ''}
                <button type="button" class="opt-edit-dot opacity-0 group-hover/opt:opacity-100 transition-opacity w-5 h-5 flex items-center justify-center rounded text-slate-400 hover:text-white hover:bg-white/20 cursor-pointer shrink-0" data-option-id="${esc(opt.id)}" title="Edit option">
                    <svg class="w-3.5 h-3.5 pointer-events-none" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="1"/><circle cx="19" cy="12" r="1"/><circle cx="5" cy="12" r="1"/></svg>
                </button>`;

            // Click row = select value
            row.addEventListener('click', async e => {
                if (e.target.closest('.opt-edit-dot')) return;
                selectDropdown.classList.add('hidden');
                activeSelectTrigger.dataset.currentValue = opt.id;
                activeSelectTrigger.innerHTML = `<span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-bold text-white" style="background-color:${esc(opt.color??'#6b7280')}"><span class="w-1.5 h-1.5 rounded-full bg-white/40 shrink-0"></span>${esc(opt.label)}</span>`;
                await saveValue(activeSelectPropId, opt.id);
            });

            // Edit dot → edit-option popup
            row.querySelector('.opt-edit-dot').addEventListener('click', async e => {
                e.stopPropagation();
                openEditOptionPopup(opt, e.currentTarget);
            });

            selectOptionsList.appendChild(row);
        });

        // Drag-to-reorder options list
        if (window.Sortable && selectOptionsList.children.length > 1) {
            Sortable.create(selectOptionsList, {
                handle: '.drag-handle',
                animation: 150,
                onEnd: () => {
                    const newOrder = Array.from(selectOptionsList.children).map((el, i) => {
                        const id = el.querySelector('[data-option-id]')?.dataset.optionId;
                        return id;
                    }).filter(Boolean);
                    reorderOptions(newOrder);
                },
            });
        }
    }

    selectSearchInput?.addEventListener('input', () => {
        renderSelectDropdown(activeSelectTrigger?.dataset.currentValue ?? '', selectSearchInput.value);
    });

    selectCreateBtn?.addEventListener('click', async () => {
        const label = selectSearchInput.value.trim();
        if (!label) return;
        const newOpt = { id: uid(), label, color: '#6b7280', group: '' };
        activeSelectConfig.options = [...(activeSelectConfig?.options ?? []), newOpt];

        // Persist config
        const th = document.querySelector(`.prop-col-header[data-property-id="${activeSelectPropId}"]`);
        if (th) {
            th.dataset.propertyConfig = JSON.stringify(activeSelectConfig);
            await api(`${routes.update}/${activeSelectPropId}`, 'PUT', { config: activeSelectConfig });
        }
        // Auto-select the new option
        selectDropdown.classList.add('hidden');
        activeSelectTrigger.dataset.currentValue = newOpt.id;
        activeSelectTrigger.innerHTML = `<span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-bold text-white" style="background-color:${esc(newOpt.color)}"><span class="w-1.5 h-1.5 rounded-full bg-white/40 shrink-0"></span>${esc(newOpt.label)}</span>`;
        await saveValue(activeSelectPropId, newOpt.id);
    });

    function reorderOptions(newOrderIds) {
        if (!activeSelectConfig?.options) return;
        const map = Object.fromEntries(activeSelectConfig.options.map(o => [o.id, o]));
        activeSelectConfig.options = newOrderIds.map(id => map[id]).filter(Boolean);
        const th = document.querySelector(`.prop-col-header[data-property-id="${activeSelectPropId}"]`);
        if (th) th.dataset.propertyConfig = JSON.stringify(activeSelectConfig);
        api(`${routes.update}/${activeSelectPropId}`, 'PUT', { config: activeSelectConfig });
    }


    /* ══════════════════════════════════════════════════════════
       EDIT OPTION SUB-POPUP
       ══════════════════════════════════════════════════════════ */

    const editOptPopup  = document.getElementById('edit-option-popup');
    const editOptName   = document.getElementById('edit-option-name');
    const editOptDelete = document.getElementById('edit-option-delete');

    let editingOptId     = null;
    let editingOptConfig = null; // reference to activeSelectConfig or activePanelConfig
    let editingPropId    = null;

    function openEditOptionPopup(opt, anchor) {
        editingOptId     = opt.id;
        editingOptConfig = activeSelectConfig;
        editingPropId    = activeSelectPropId;

        editOptName.value = opt.label;

        // Mark active color
        document.querySelectorAll('.edit-opt-color-swatch').forEach(sw => {
            const isActive = sw.dataset.color.toLowerCase() === (opt.color ?? '').toLowerCase();
            sw.querySelector('.check-icon')?.classList.toggle('hidden', !isActive);
            sw.style.outline = isActive ? '2px solid white' : 'none';
            sw.style.outlineOffset = '1px';
        });

        positionBelow(editOptPopup, anchor);
        closeAll('edit-option-popup');
        editOptPopup.classList.remove('hidden');
        editOptName.focus();
    }

    let optNameTimer;
    editOptName?.addEventListener('input', () => {
        clearTimeout(optNameTimer);
        optNameTimer = setTimeout(() => {
            patchOption(editingOptId, { label: editOptName.value });
        }, 500);
    });

    document.querySelectorAll('.edit-opt-color-swatch').forEach(sw => {
        sw.addEventListener('click', () => {
            const color = sw.dataset.color;
            patchOption(editingOptId, { color });
            // Update check marks
            document.querySelectorAll('.edit-opt-color-swatch').forEach(s => {
                const active = s.dataset.color === color;
                s.querySelector('.check-icon')?.classList.toggle('hidden', !active);
                s.style.outline = active ? '2px solid white' : 'none';
                s.style.outlineOffset = '1px';
            });
            // Update badge in dropdown list
            renderSelectDropdown(activeSelectTrigger?.dataset.currentValue ?? '', selectSearchInput?.value ?? '');
        });
    });

    editOptDelete?.addEventListener('click', async () => {
        if (!editingOptId || !editingOptConfig) return;
        editingOptConfig.options = editingOptConfig.options.filter(o => o.id !== editingOptId);
        const th = document.querySelector(`.prop-col-header[data-property-id="${editingPropId}"]`);
        if (th) th.dataset.propertyConfig = JSON.stringify(editingOptConfig);
        await api(`${routes.update}/${editingPropId}`, 'PUT', { config: editingOptConfig });
        editOptPopup.classList.add('hidden');
        renderSelectDropdown(activeSelectTrigger?.dataset.currentValue ?? '');
    });

    function patchOption(optId, patch) {
        if (!editingOptConfig?.options) return;
        editingOptConfig.options = editingOptConfig.options.map(o =>
            o.id === optId ? { ...o, ...patch } : o
        );
        const th = document.querySelector(`.prop-col-header[data-property-id="${editingPropId}"]`);
        if (th) th.dataset.propertyConfig = JSON.stringify(editingOptConfig);
        api(`${routes.update}/${editingPropId}`, 'PUT', { config: editingOptConfig });

        // If changed option is current value, update the trigger badge
        if (activeSelectTrigger && activeSelectTrigger.dataset.currentValue === optId) {
            const opt = editingOptConfig.options.find(o => o.id === optId);
            if (opt) {
                activeSelectTrigger.innerHTML = `<span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-bold text-white" style="background-color:${esc(opt.color??'#6b7280')}"><span class="w-1.5 h-1.5 rounded-full bg-white/40 shrink-0"></span>${esc(opt.label)}</span>`;
            }
        }
    }


    /* ══════════════════════════════════════════════════════════
       ADD PROPERTY POPUP
       ══════════════════════════════════════════════════════════ */

    const addPropPopup    = document.getElementById('add-prop-popup');
    const newPropNameInput = document.getElementById('new-prop-name-input');
    const propTypeSearch  = document.getElementById('prop-type-search');
    const propTypeGrid    = document.getElementById('prop-type-grid');
    const addNewBtn       = document.getElementById('prop-add-new-btn');

    addNewBtn?.addEventListener('click', e => {
        e.stopPropagation();
        positionBelow(addPropPopup, addNewBtn);
        closeAll('add-prop-popup');
        addPropPopup.classList.remove('hidden');
        newPropNameInput.value = '';
        propTypeSearch.value = '';
        filterTypeGrid('');
        newPropNameInput.focus();
    });

    propTypeSearch?.addEventListener('input', () => filterTypeGrid(propTypeSearch.value));

    function filterTypeGrid(q) {
        propTypeGrid.querySelectorAll('.prop-type-pick').forEach(btn => {
            const label = btn.querySelector('span')?.textContent?.toLowerCase() ?? '';
            btn.style.display = q && !label.includes(q.toLowerCase()) ? 'none' : '';
        });
    }

    const typeDefaultNames = {
        select:'Kategori', status:'Status', text:'Notes', number:'Number',
        date:'Date', checkbox:'Done', url:'Link', email:'Email', phone:'Phone',
        person:'Person', formula:'Formula', multi_select:'Tags',
    };

    document.querySelectorAll('.prop-type-pick').forEach(btn => {
        btn.addEventListener('click', async () => {
            addPropPopup.classList.add('hidden');
            const type  = btn.dataset.type;
            const name  = newPropNameInput.value.trim() || typeDefaultNames[type] || 'Property';

            // Default config for select/status
            let config = null;
            if (type === 'select') {
                config = { options: [{ id: uid(), label: 'Option 1', color: '#6b7280', group: '' }] };
            } else if (type === 'status') {
                config = { options: [
                    { id: uid(), label: 'Belum Dimulai', color: '#ef4444', group: 'To-do' },
                    { id: uid(), label: 'Dalam Proses',  color: '#eab308', group: 'In progress' },
                    { id: uid(), label: 'Selesai',       color: '#22c55e', group: 'Complete' },
                ]};
            }

            try {
                const prop = await api(routes.store, 'POST', { name, type });
                if (config) {
                    await api(`${routes.update}/${prop.id}`, 'PUT', { config });
                    prop.config = config;
                }
                insertTableColumn(prop);
            } catch(err) { console.error('add prop:', err); }
        });
    });

    /* ── Insert column into table ────────────────────────────── */

    const typeIcons = {
        select:'bi-list-check', status:'bi-circle-half', text:'bi-fonts',
        date:'bi-calendar3', checkbox:'bi-check2-square', number:'bi-hash',
        url:'bi-link-45deg', email:'bi-envelope', phone:'bi-telephone', person:'bi-person',
    };

    function insertTableColumn(prop, rawValue = null) {
        const table    = document.getElementById('prop-table');
        if (!table) return;
        const headerRow = table.querySelector('thead tr');
        const dataRow   = document.getElementById('prop-data-row');
        // Insert before last 2 cols (+ and ...)
        const thList    = headerRow.querySelectorAll('th');
        const lastTh    = thList[thList.length - 2]; // before ...
        const tdList    = dataRow?.querySelectorAll('td');
        const lastTd    = tdList ? tdList[tdList.length - 2] : null;

        const th = document.createElement('th');
        th.className = 'prop-col-header px-4 py-3 text-left w-36 group cursor-pointer select-none';
        th.dataset.propertyId     = prop.id;
        th.dataset.propertyName   = prop.name;
        th.dataset.propertyType   = prop.type;
        th.dataset.propertyConfig = JSON.stringify(prop.config ?? null);
        th.innerHTML = `<span class="text-xs font-bold text-text-muted uppercase tracking-wider flex items-center gap-1.5 hover:text-primary transition-colors">
            <i class="bi ${typeIcons[prop.type]??'bi-tag'} text-xs shrink-0"></i>
            <span class="prop-col-name truncate">${esc(prop.name)}</span>
            <svg class="w-3 h-3 shrink-0 opacity-0 group-hover:opacity-100 transition-opacity" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><circle cx="12" cy="12" r="3"/><path d="M19.4 15a1.65 1.65 0 0 0 .33 1.82l.06.06a2 2 0 0 1-2.83 2.83l-.06-.06a1.65 1.65 0 0 0-1.82-.33 1.65 1.65 0 0 0-1 1.51V21a2 2 0 0 1-4 0v-.09A1.65 1.65 0 0 0 9 19.4a1.65 1.65 0 0 0-1.82.33l-.06.06a2 2 0 0 1-2.83-2.83l.06-.06A1.65 1.65 0 0 0 4.68 15a1.65 1.65 0 0 0-1.51-1H3a2 2 0 0 1 0-4h.09A1.65 1.65 0 0 0 4.6 9a1.65 1.65 0 0 0-.33-1.82l-.06-.06a2 2 0 0 1 2.83-2.83l.06.06A1.65 1.65 0 0 0 9 4.68a1.65 1.65 0 0 0 1-1.51V3a2 2 0 0 1 4 0v.09a1.65 1.65 0 0 0 1 1.51 1.65 1.65 0 0 0 1.82-.33l.06-.06a2 2 0 0 1 2.83 2.83l-.06.06A1.65 1.65 0 0 0 19.4 9a1.65 1.65 0 0 0 1.51 1H21a2 2 0 0 1 0 4h-.09a1.65 1.65 0 0 0-1.51 1z"/></svg>
        </span>`;
        th.addEventListener('click', () => openPanel(th));
        headerRow.insertBefore(th, lastTh);

        if (dataRow && lastTd) {
            const td = document.createElement('td');
            td.className = 'prop-value-cell px-4 py-3';
            td.dataset.propertyId   = prop.id;
            td.dataset.propertyType = prop.type;
            td.appendChild(buildValueCell(prop, rawValue));
            dataRow.insertBefore(td, lastTd);
        }
    }

    function buildValueCell(prop, rawValue) {
        const wrap = document.createElement('div');
        if (prop.type === 'select' || prop.type === 'status') {
            const btn = document.createElement('button');
            btn.type = 'button';
            btn.className = 'prop-select-trigger cursor-pointer';
            btn.dataset.propertyId   = prop.id;
            btn.dataset.propertyType = prop.type;
            btn.dataset.currentValue = rawValue ?? '';
            btn.dataset.wired        = '1';
            const opt = rawValue ? (prop.config?.options??[]).find(o=>o.id===rawValue) : null;
            btn.innerHTML = opt
                ? `<span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-bold text-white" style="background-color:${esc(opt.color??'#6b7280')}"><span class="w-1.5 h-1.5 rounded-full bg-white/40 shrink-0"></span>${esc(opt.label)}</span>`
                : '<span class="text-xs text-text-muted italic">— pilih</span>';
            if (prop.type === 'status') {
                // will be handled by status delegated listener above
            } else {
                btn.addEventListener('click', e => { e.stopPropagation(); openSelectDropdown(btn); });
            }
            wrap.appendChild(btn);
        } else if (prop.type === 'checkbox') {
            const btn = document.createElement('button');
            btn.type = 'button';
            btn.className = 'prop-checkbox-trigger cursor-pointer flex items-center';
            btn.dataset.propertyId   = prop.id;
            btn.dataset.currentValue = rawValue ?? '0';
            btn.dataset.wired        = '1';
            btn.innerHTML = rawValue==='1' ? checkSvg() : uncheckSvg();
            btn.addEventListener('click', async () => {
                const next = btn.dataset.currentValue==='1'?'0':'1';
                btn.dataset.currentValue = next;
                btn.innerHTML = next==='1'?checkSvg():uncheckSvg();
                await saveValue(prop.id, next);
            });
            wrap.appendChild(btn);
        } else {
            const input = document.createElement('input');
            input.type  = prop.type==='url'?'url':(prop.type==='number'?'number':'text');
            input.className = 'prop-text-input text-xs font-medium text-text-main bg-transparent border-none outline-none w-full focus:outline-none';
            input.dataset.propertyId = prop.id;
            input.dataset.wired      = '1';
            input.value       = rawValue ?? '';
            input.placeholder = '—';
            let t;
            input.addEventListener('input', () => { clearTimeout(t); t=setTimeout(()=>saveValue(prop.id,input.value||null),700); });
            wrap.appendChild(input);
        }
        return wrap;
    }

    function checkSvg() { return '<svg class="w-5 h-5 text-primary" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="9 11 12 14 22 4"/><path d="M21 12v7a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11"/></svg>'; }
    function uncheckSvg() { return '<svg class="w-5 h-5 text-text-muted" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="3" width="18" height="18" rx="2"/></svg>'; }

    /* ── Wire existing column headers ──────────────────────── */
    document.querySelectorAll('.prop-col-header').forEach(th => th.addEventListener('click', () => openPanel(th)));

    /* ── Wire existing value cells ─────────────────────────── */
    document.querySelectorAll('.prop-text-input, .prop-date-input').forEach(input => {
        if (input.dataset.wired) return;
        input.dataset.wired = '1';
        let t;
        input.addEventListener('input', () => { clearTimeout(t); t=setTimeout(()=>saveValue(input.dataset.propertyId,input.value||null),700); });
    });
    document.querySelectorAll('.prop-checkbox-trigger').forEach(btn => {
        if (btn.dataset.wired) return;
        btn.dataset.wired = '1';
        btn.addEventListener('click', async () => {
            const next = btn.dataset.currentValue==='1'?'0':'1';
            btn.dataset.currentValue = next;
            btn.innerHTML = next==='1'?checkSvg():uncheckSvg();
            await saveValue(btn.dataset.propertyId, next);
        });
    });
    document.querySelectorAll('.prop-select-trigger:not([data-property-type="status"])').forEach(btn => {
        if (btn.dataset.wired) return;
        btn.dataset.wired = '1';
        btn.addEventListener('click', e => { e.stopPropagation(); openSelectDropdown(btn); });
    });


    /* ══════════════════════════════════════════════════════════
       EDIT PROPERTY PANEL (dark slide-in)
       ══════════════════════════════════════════════════════════ */

    const panel      = document.getElementById('prop-panel');
    const backdrop   = document.getElementById('prop-panel-backdrop');
    const closeBtn   = document.getElementById('prop-panel-close');
    const backBtn    = document.getElementById('prop-panel-back');
    const panelName  = document.getElementById('prop-panel-name');
    const typeLabel  = document.getElementById('prop-panel-type-label');
    const optSection = document.getElementById('prop-panel-options-section');
    const noOptMsg   = document.getElementById('prop-panel-no-options');
    const dupBtn     = document.getElementById('prop-panel-duplicate');
    const delBtn     = document.getElementById('prop-panel-delete');
    const wrapToggle = document.getElementById('prop-wrap-toggle');

    let activePropId     = null;
    let activePanelConfig = {};
    let nameSaveTimer    = null;

    function openPanel(th) {
        activePropId      = th.dataset.propertyId;
        try { activePanelConfig = JSON.parse(th.dataset.propertyConfig || 'null') ?? {}; }
        catch(_) { activePanelConfig = {}; }

        panelName.value       = th.dataset.propertyName ?? '';
        typeLabel.textContent = th.dataset.propertyType ?? 'select';

        const hasOpts = ['select','status'].includes(th.dataset.propertyType);
        optSection.classList.toggle('hidden', !hasOpts);
        noOptMsg.classList.toggle('hidden',    hasOpts);

        if (hasOpts) renderPanelOptions(activePanelConfig.options ?? []);

        backdrop.classList.remove('hidden');
        panel.classList.remove('translate-x-full');
        panelName.focus();
    }

    function closePanel() {
        panel.classList.add('translate-x-full');
        backdrop.classList.add('hidden');
        activePropId = null;
    }

    closeBtn?.addEventListener('click', closePanel);
    backBtn?.addEventListener('click', closePanel);
    backdrop?.addEventListener('click', closePanel);

    panelName?.addEventListener('input', () => {
        clearTimeout(nameSaveTimer);
        nameSaveTimer = setTimeout(() => persistProp({ name: panelName.value }), 600);
    });

    wrapToggle?.addEventListener('click', () => {
        const checked = wrapToggle.getAttribute('aria-checked') === 'true';
        wrapToggle.setAttribute('aria-checked', String(!checked));
        const knob = wrapToggle.querySelector('span');
        knob.style.transform = !checked ? 'translateX(16px)' : 'translateX(2px)';
        wrapToggle.style.background = !checked ? '#0d9488' : '#475569';
    });

    async function persistProp(data) {
        if (!activePropId) return;
        try {
            const updated = await api(`${routes.update}/${activePropId}`, 'PUT', data);
            const th = document.querySelector(`.prop-col-header[data-property-id="${activePropId}"]`);
            if (th) {
                if (data.name) {
                    th.dataset.propertyName = updated.name;
                    const span = th.querySelector('.prop-col-name');
                    if (span) span.textContent = updated.name;
                }
                if (data.config) th.dataset.propertyConfig = JSON.stringify(updated.config);
            }
        } catch(err) { console.error('persistProp:', err); }
    }

    /* ── Panel option list rendering ─────────────────────── */

    function renderPanelOptions(options) {
        document.querySelectorAll('.prop-option-list').forEach(el => el.innerHTML = '');
        options.forEach(opt => renderPanelOption(opt));
    }

    function renderPanelOption(opt) {
        const group  = opt.group ?? '';
        const listEl = document.querySelector(`.prop-option-list[data-group="${CSS.escape(group)}"]`)
                    ?? document.querySelector('.prop-option-list[data-group=""]');
        if (!listEl) return;

        const isDefault = activePanelConfig?.defaultOptionId === opt.id;

        const item = document.createElement('div');
        item.className = 'prop-option-item flex items-center gap-2 group/opt rounded-lg px-2 py-1.5 hover:bg-white/10 transition-colors';
        item.dataset.optionId = opt.id;
        item.innerHTML = `
            <span class="drag-handle text-slate-600 cursor-grab opacity-0 group-hover/opt:opacity-100 transition-opacity select-none text-xs">⠿</span>
            <button type="button" class="opt-color-btn w-5 h-5 rounded-full shrink-0 cursor-pointer border-2 border-white/20 hover:scale-110 transition-transform"
                    style="background-color:${esc(opt.color??'#6b7280')};" data-option-id="${esc(opt.id)}" title="Change color"></button>
            <input type="text" value="${esc(opt.label)}"
                   class="opt-label-input flex-1 text-sm font-semibold text-white bg-transparent border-none outline-none placeholder-slate-500"
                   data-option-id="${esc(opt.id)}" placeholder="Option name" maxlength="80">
            ${isDefault ? '<span class="text-[10px] font-bold text-slate-400 uppercase tracking-wider shrink-0">DEFAULT</span>' : ''}
            <button type="button" class="opt-delete-btn shrink-0 w-5 h-5 flex items-center justify-center rounded text-slate-600 opacity-0 group-hover/opt:opacity-100 hover:text-red-400 transition-all cursor-pointer"
                    data-option-id="${esc(opt.id)}" title="Remove">
                <svg class="w-3.5 h-3.5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
            </button>`;

        let labelTimer;
        item.querySelector('.opt-label-input').addEventListener('input', e => {
            clearTimeout(labelTimer);
            labelTimer = setTimeout(() => updatePanelOption(opt.id, { label: e.target.value }), 500);
        });
        item.querySelector('.opt-delete-btn').addEventListener('click', () => removePanelOption(opt.id, item));
        item.querySelector('.opt-color-btn').addEventListener('click', e => {
            e.stopPropagation();
            openColorPicker(e.currentTarget, opt.id, 'panel');
        });
        listEl.appendChild(item);
    }

    document.querySelectorAll('.prop-add-option-btn').forEach(btn => {
        btn.addEventListener('click', () => {
            const group = btn.dataset.group ?? '';
            const newOpt = { id: uid(), label: 'New Option', color: '#6b7280', group };
            activePanelConfig.options = [...(activePanelConfig.options ?? []), newOpt];
            renderPanelOption(newOpt);
            persistProp({ config: activePanelConfig });
        });
    });

    function updatePanelOption(optId, patch) {
        activePanelConfig.options = (activePanelConfig.options ?? []).map(o =>
            o.id === optId ? { ...o, ...patch } : o
        );
        persistProp({ config: activePanelConfig });
    }

    function removePanelOption(optId, itemEl) {
        activePanelConfig.options = (activePanelConfig.options ?? []).filter(o => o.id !== optId);
        itemEl.remove();
        persistProp({ config: activePanelConfig });
    }

    /* ── Duplicate & Delete property ────────────────────── */

    dupBtn?.addEventListener('click', async () => {
        if (!activePropId) return;
        const th = document.querySelector(`.prop-col-header[data-property-id="${activePropId}"]`);
        if (!th) return;
        try {
            const newProp = await api(routes.store, 'POST', {
                name: (panelName.value || 'Property') + ' (copy)',
                type: th.dataset.propertyType,
            });
            if (activePanelConfig?.options) {
                const cloned = { options: activePanelConfig.options.map(o => ({ ...o, id: uid() })) };
                await api(`${routes.update}/${newProp.id}`, 'PUT', { config: cloned });
                newProp.config = cloned;
            }
            insertTableColumn(newProp);
            closePanel();
        } catch(err) { console.error('duplicate:', err); }
    });

    delBtn?.addEventListener('click', async () => {
        if (!activePropId) return;
        if (!confirm('Hapus properti ini? Semua nilai pada task akan ikut terhapus.')) return;
        try {
            await api(`${routes.destroy}/${activePropId}`, 'DELETE');
            document.querySelector(`.prop-col-header[data-property-id="${activePropId}"]`)?.remove();
            document.querySelector(`.prop-value-cell[data-property-id="${activePropId}"]`)?.remove();
            closePanel();
        } catch(err) { console.error('delete:', err); }
    });


    /* ══════════════════════════════════════════════════════════
       COLOR PICKER (dark)
       ══════════════════════════════════════════════════════════ */

    const colorPicker   = document.getElementById('prop-color-picker');
    const colorInput    = document.getElementById('prop-color-input');
    const colorPreview  = document.getElementById('prop-color-preview');
    const colorConfirm  = document.getElementById('prop-color-confirm');

    let colorOptId     = null;
    let colorAnchorBtn = null;
    let colorContext   = null; // 'panel' or 'select'
    let pendingColor   = '#6b7280';

    function openColorPicker(btn, optId, context) {
        colorOptId     = optId;
        colorAnchorBtn = btn;
        colorContext   = context;
        pendingColor   = btn.style.backgroundColor ? rgbToHex(btn.style.backgroundColor) : '#6b7280';
        colorInput.value = pendingColor;
        colorPreview.style.backgroundColor = pendingColor;
        positionBelow(colorPicker, btn);
        closeAll('prop-color-picker');
        colorPicker.classList.remove('hidden');
    }

    colorInput?.addEventListener('input', () => {
        if (/^#[0-9a-fA-F]{6}$/.test(colorInput.value)) {
            pendingColor = colorInput.value;
            colorPreview.style.backgroundColor = pendingColor;
        }
    });

    document.querySelectorAll('.prop-color-swatch').forEach(sw => {
        sw.addEventListener('click', () => {
            pendingColor = sw.dataset.color;
            colorInput.value = pendingColor;
            colorPreview.style.backgroundColor = pendingColor;
        });
    });

    colorConfirm?.addEventListener('click', () => {
        if (!colorOptId) return;
        colorAnchorBtn.style.backgroundColor = pendingColor;
        if (colorContext === 'panel') {
            updatePanelOption(colorOptId, { color: pendingColor });
        } else {
            patchOption(colorOptId, { color: pendingColor });
        }
        colorPicker.classList.add('hidden');
    });

    function rgbToHex(rgb) {
        const m = rgb.match(/^rgb\((\d+),\s*(\d+),\s*(\d+)\)$/);
        if (!m) return rgb;
        return '#' + [m[1],m[2],m[3]].map(n=>parseInt(n).toString(16).padStart(2,'0')).join('');
    }

    /* ── Stop popup click-through for color picker ────────── */
    colorPicker?.addEventListener('click', e => e.stopPropagation());

}); // end DOMContentLoaded
