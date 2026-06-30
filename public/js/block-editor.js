document.addEventListener('DOMContentLoaded', () => {
    const listEl = document.getElementById('block-list');
    const addBtn = document.getElementById('block-add-btn');
    const typeMenu = document.getElementById('block-type-menu');
    const savingIndicator = document.getElementById('block-saving');
    
    if (!listEl || !window.PLANOVA?.blockRoutes) return;

    let saveTimeout;
    const blockableType = window.PLANOVA.blockable.type;
    const blockableId = window.PLANOVA.blockable.id;

    // 1. Sortable Initialization
    new Sortable(listEl, {
        handle: '.block-drag-handle',
        animation: 150,
        ghostClass: 'bg-surface-300',
        onEnd: function () {
            const blockIds = Array.from(listEl.children)
                .map(el => el.dataset.blockId)
                .filter(id => id); // filter out placeholders if any
            
            if (blockIds.length === 0) return;

            showSaving();
            fetch(window.PLANOVA.blockRoutes.reorder, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                },
                body: JSON.stringify({ block_ids: blockIds })
            }).then(() => hideSaving());
        }
    });

    // 2. Add Block Menu Toggle
    if (addBtn && typeMenu) {
        addBtn.addEventListener('click', (e) => {
            e.stopPropagation();
            typeMenu.classList.toggle('hidden');
        });
        document.addEventListener('click', (e) => {
            if (!typeMenu.contains(e.target) && !addBtn.contains(e.target)) {
                typeMenu.classList.add('hidden');
            }
        });
    }

    // 3. Create Block
    document.querySelectorAll('.block-type-option').forEach(btn => {
        btn.addEventListener('click', async () => {
            const type = btn.dataset.type;
            typeMenu.classList.add('hidden');
            
            showSaving();
            
            try {
                const res = await fetch(window.PLANOVA.blockRoutes.store, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify({
                        blockable_type: blockableType,
                        blockable_id: blockableId,
                        type: type
                    })
                });
                
                const data = await res.json();
                if (data.html) {
                    const placeholder = document.getElementById('block-placeholder');
                    if (placeholder) placeholder.remove();

                    // Append HTML and animate using Anime.js if available
                    listEl.insertAdjacentHTML('beforeend', data.html);
                    const newBlock = listEl.lastElementChild;
                    
                    if (window.anime) {
                        window.anime({
                            targets: newBlock,
                            opacity: [0, 1],
                            translateY: [10, 0],
                            duration: 400,
                            easing: 'easeOutQuad'
                        });
                    }
                    
                    // Focus the new block
                    const editable = newBlock.querySelector('[contenteditable="true"]');
                    if (editable) editable.focus();
                }
            } catch (err) {
                console.error("Error creating block:", err);
            } finally {
                hideSaving();
            }
        });
    });

    // 4. Update Block (Debounced ContentEditable)
    listEl.addEventListener('input', (e) => {
        if (e.target.hasAttribute('contenteditable')) {
            const blockId = e.target.closest('.block-item').dataset.blockId;
            debounceSave(blockId);
        }
    });

    listEl.addEventListener('change', (e) => {
        if (e.target.classList.contains('block-todo-checkbox') || e.target.classList.contains('block-heading-level-select')) {
            const blockId = e.target.closest('.block-item').dataset.blockId;
            saveBlockContent(blockId);
        }
    });

    // Handle adding rows/cols to tables
    listEl.addEventListener('click', (e) => {
        if (e.target.closest('.table-add-row')) {
            const blockId = e.target.closest('.table-add-row').dataset.blockId;
            const tbody = document.querySelector(`.block-table-editor[data-block-id="${blockId}"] tbody`);
            const colCount = tbody.closest('table').querySelector('thead tr').children.length;
            const tr = document.createElement('tr');
            for(let i=0; i<colCount; i++) {
                tr.innerHTML += `<td contenteditable="true" data-block-id="${blockId}" data-is-table="1" class="border border-surface-500 dark:border-dark-border px-3 py-2 text-sm text-text-main dark:text-text-darkMain outline-none focus:bg-surface-100 dark:focus:bg-dark-bg"></td>`;
            }
            tbody.appendChild(tr);
            saveBlockContent(blockId);
        }
        if (e.target.closest('.table-add-col')) {
            const blockId = e.target.closest('.table-add-col').dataset.blockId;
            const table = document.querySelector(`.block-table-editor[data-block-id="${blockId}"]`);
            table.querySelector('thead tr').innerHTML += `<th contenteditable="true" data-block-id="${blockId}" data-is-table="1" class="border border-surface-500 dark:border-dark-border bg-surface-100 dark:bg-dark-surface2 px-3 py-2 text-sm font-semibold text-text-main dark:text-text-darkMain text-left outline-none focus:bg-surface-200 dark:focus:bg-dark-surface min-w-[100px]">New Col</th>`;
            table.querySelectorAll('tbody tr').forEach(tr => {
                tr.innerHTML += `<td contenteditable="true" data-block-id="${blockId}" data-is-table="1" class="border border-surface-500 dark:border-dark-border px-3 py-2 text-sm text-text-main dark:text-text-darkMain outline-none focus:bg-surface-100 dark:focus:bg-dark-bg"></td>`;
            });
            saveBlockContent(blockId);
        }
    });

    // 5. Delete Block
    listEl.addEventListener('click', async (e) => {
        const deleteBtn = e.target.closest('.block-delete-btn');
        if (deleteBtn) {
            const blockId = deleteBtn.dataset.blockId;
            const blockEl = document.getElementById(`block-${blockId}`);
            if (!blockEl) return;

            if (confirm('Hapus block ini?')) {
                // Animate out
                if (window.anime) {
                    window.anime({
                        targets: blockEl,
                        opacity: 0,
                        height: 0,
                        margin: 0,
                        padding: 0,
                        duration: 300,
                        easing: 'easeOutQuad',
                        complete: () => blockEl.remove()
                    });
                } else {
                    blockEl.remove();
                }

                try {
                    await fetch(`${window.PLANOVA.blockRoutes.destroy}/${blockId}`, {
                        method: 'DELETE',
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                            'Accept': 'application/json'
                        }
                    });
                } catch(err) {
                    console.error("Error deleting block", err);
                }
            }
        }
    });

    // Helper functions
    function debounceSave(blockId) {
        clearTimeout(saveTimeout);
        showSaving(true); // show but keep pulsing or something? We just show "saving..."
        saveTimeout = setTimeout(() => {
            saveBlockContent(blockId);
        }, 1000);
    }

    async function saveBlockContent(blockId) {
        const blockEl = document.getElementById(`block-${blockId}`);
        if (!blockEl) return;

        const type = blockEl.dataset.blockType;
        let content = {};

        if (type === 'todo') {
            content.checked = blockEl.querySelector('.block-todo-checkbox').checked;
            content.text = blockEl.querySelector('.block-content').innerText;
            if (content.checked) {
                blockEl.querySelector('.block-content').classList.add('line-through', 'text-text-muted', 'dark:text-text-darkMuted');
            } else {
                blockEl.querySelector('.block-content').classList.remove('line-through', 'text-text-muted', 'dark:text-text-darkMuted');
            }
        } else if (type === 'heading') {
            content.level = blockEl.querySelector('.block-heading-level-select').value;
            content.text = blockEl.querySelector('.block-content').innerText;
            // update classes dynamically for visual feedback before reload
            const ct = blockEl.querySelector('.block-content');
            ct.className = `block-content text-text-main dark:text-text-darkMain outline-none font-bold ${content.level == 1 ? 'text-3xl mt-6' : (content.level == 2 ? 'text-2xl mt-4' : 'text-xl mt-2')}`;
        } else if (type === 'table') {
            const thead = Array.from(blockEl.querySelectorAll('thead th')).map(th => th.innerText);
            const rows = Array.from(blockEl.querySelectorAll('tbody tr')).map(tr => {
                return Array.from(tr.querySelectorAll('td')).map(td => td.innerText);
            });
            content = { headers: thead, rows: rows };
        } else if (type !== 'divider') {
            content.text = blockEl.querySelector('.block-content').innerText;
        }

        try {
            await fetch(`${window.PLANOVA.blockRoutes.update}/${blockId}`, {
                method: 'PUT',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    'Accept': 'application/json'
                },
                body: JSON.stringify({ content: content })
            });
        } catch(err) {
            console.error("Save failed", err);
        } finally {
            hideSaving();
        }
    }

    function showSaving(isDebouncing = false) {
        savingIndicator.innerHTML = isDebouncing 
            ? '<i class="bi bi-arrow-repeat animate-spin mr-1"></i>Menyimpan…' 
            : '<i class="bi bi-cloud-arrow-up mr-1"></i>Menyimpan…';
        savingIndicator.style.opacity = '1';
    }

    function hideSaving() {
        savingIndicator.innerHTML = '<i class="bi bi-cloud-check mr-1"></i>Tersimpan';
        setTimeout(() => {
            savingIndicator.style.opacity = '0';
        }, 2000);
    }
});
