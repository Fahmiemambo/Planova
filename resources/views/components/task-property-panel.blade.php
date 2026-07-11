{{-- Edit Property Panel — dark slide-in from right --}}

{{-- Backdrop --}}
<div id="prop-panel-backdrop" class="fixed inset-0 bg-black/40 z-40 hidden" aria-hidden="true"></div>

{{-- Panel --}}
<aside id="prop-panel"
       role="dialog" aria-modal="true" aria-label="Edit property"
       class="fixed top-0 right-0 h-full w-72 z-50 flex flex-col translate-x-full transition-transform duration-300 ease-out"
       style="background:#1e293b;border-left:1px solid rgba(255,255,255,0.1);box-shadow:-12px 0 48px rgba(0,0,0,0.5);">

    {{-- Header --}}
    <div class="flex items-center justify-between px-4 pt-4 pb-3 shrink-0" style="border-bottom:1px solid rgba(255,255,255,0.1);">
        <div class="flex items-center gap-2">
            <button id="prop-panel-back" type="button" title="Back"
                    class="w-7 h-7 flex items-center justify-center rounded-lg text-slate-400 hover:text-white hover:bg-white/10 transition-colors cursor-pointer">
                <svg class="w-4 h-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M19 12H5M12 5l-7 7 7 7"/></svg>
            </button>
            <span class="text-xs font-bold text-slate-400 uppercase tracking-widest">Edit property</span>
        </div>
        <button id="prop-panel-close" type="button" aria-label="Close"
                class="w-7 h-7 flex items-center justify-center rounded-lg text-slate-400 hover:text-white hover:bg-white/10 transition-colors cursor-pointer">
            <svg class="w-4 h-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
        </button>
    </div>

    {{-- Scrollable body --}}
    <div class="flex-1 overflow-y-auto px-4 py-4 space-y-4">

        {{-- Property name --}}
        <div class="flex items-center gap-2">
            <input id="prop-panel-name" type="text" maxlength="100" autocomplete="off"
                   placeholder="Property name"
                   class="flex-1 bg-white/10 rounded-lg px-3 py-2 text-sm font-semibold text-white placeholder-slate-500 outline-none border border-white/10 focus:border-white/30 transition-colors">
            <button type="button" title="Info" class="w-7 h-7 flex items-center justify-center rounded-lg text-slate-500 hover:text-slate-300 transition-colors">
                <svg class="w-4 h-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><line x1="12" y1="16" x2="12" y2="12"/><line x1="12" y1="8" x2="12.01" y2="8"/></svg>
            </button>
        </div>

        {{-- Type row --}}
        <div class="flex items-center justify-between py-2" style="border-bottom:1px solid rgba(255,255,255,0.08);">
            <span class="text-sm font-semibold text-slate-400 flex items-center gap-2">
                <svg class="w-4 h-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="17 1 21 5 17 9"/><path d="M3 11V9a4 4 0 0 1 4-4h14"/><polyline points="7 23 3 19 7 15"/><path d="M21 13v2a4 4 0 0 1-4 4H3"/></svg>
                Type
            </span>
            <button type="button" id="prop-panel-type-btn"
                    class="flex items-center gap-1.5 text-sm font-semibold text-slate-300 hover:text-white transition-colors cursor-pointer">
                <span id="prop-panel-type-label">Select</span>
                <svg class="w-3.5 h-3.5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="9 18 15 12 9 6"/></svg>
            </button>
        </div>

        {{-- Options section (select / status only) --}}
        <div id="prop-panel-options-section">
            {{-- To-do group --}}
            <div class="prop-group mb-3">
                <div class="flex items-center justify-between mb-1.5">
                    <span class="text-[10px] font-bold text-slate-500 uppercase tracking-wider">To-do</span>
                    <button type="button" class="prop-add-option-btn w-5 h-5 flex items-center justify-center rounded text-slate-500 hover:text-white hover:bg-white/10 transition-colors cursor-pointer" data-group="To-do">
                        <svg class="w-3.5 h-3.5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
                    </button>
                </div>
                <div class="prop-option-list space-y-0.5" data-group="To-do"></div>
            </div>
            {{-- In progress group --}}
            <div class="prop-group mb-3">
                <div class="flex items-center justify-between mb-1.5">
                    <span class="text-[10px] font-bold text-slate-500 uppercase tracking-wider">In progress</span>
                    <button type="button" class="prop-add-option-btn w-5 h-5 flex items-center justify-center rounded text-slate-500 hover:text-white hover:bg-white/10 transition-colors cursor-pointer" data-group="In progress">
                        <svg class="w-3.5 h-3.5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
                    </button>
                </div>
                <div class="prop-option-list space-y-0.5" data-group="In progress"></div>
            </div>
            {{-- Complete group --}}
            <div class="prop-group mb-3">
                <div class="flex items-center justify-between mb-1.5">
                    <span class="text-[10px] font-bold text-slate-500 uppercase tracking-wider">Complete</span>
                    <button type="button" class="prop-add-option-btn w-5 h-5 flex items-center justify-center rounded text-slate-500 hover:text-white hover:bg-white/10 transition-colors cursor-pointer" data-group="Complete">
                        <svg class="w-3.5 h-3.5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
                    </button>
                </div>
                <div class="prop-option-list space-y-0.5" data-group="Complete"></div>
            </div>
            {{-- Other / ungrouped --}}
            <div class="prop-group mb-1">
                <div class="flex items-center justify-between mb-1.5">
                    <span class="text-[10px] font-bold text-slate-500 uppercase tracking-wider">Other</span>
                    <button type="button" class="prop-add-option-btn w-5 h-5 flex items-center justify-center rounded text-slate-500 hover:text-white hover:bg-white/10 transition-colors cursor-pointer" data-group="">
                        <svg class="w-3.5 h-3.5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
                    </button>
                </div>
                <div class="prop-option-list space-y-0.5" data-group=""></div>
            </div>
        </div>

        {{-- No-options message --}}
        <div id="prop-panel-no-options" class="hidden text-xs text-slate-500 italic py-2">
            This property type has no configurable options.
        </div>

    </div>

    {{-- Footer --}}
    <div class="shrink-0 px-4 py-3 space-y-0.5" style="border-top:1px solid rgba(255,255,255,0.08);">
        {{-- Wrap content --}}
        <div class="flex items-center justify-between px-2 py-2.5">
            <span class="text-sm font-semibold text-slate-300 flex items-center gap-2">
                <svg class="w-4 h-4 text-slate-500" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="17 1 21 5 17 9"/><path d="M3 11V9a4 4 0 0 1 4-4h14"/><polyline points="7 23 3 19 7 15"/><path d="M21 13v2a4 4 0 0 1-4 4H3"/></svg>
                Wrap content
            </span>
            <button type="button" id="prop-wrap-toggle"
                    class="relative inline-flex h-5 w-9 items-center rounded-full transition-colors cursor-pointer bg-slate-600"
                    role="switch" aria-checked="false">
                <span class="inline-block h-3.5 w-3.5 rounded-full bg-white shadow translate-x-0.5 transition-transform"></span>
            </button>
        </div>
        {{-- Display as --}}
        <div class="flex items-center justify-between px-2 py-2.5">
            <span class="text-sm font-semibold text-slate-300 flex items-center gap-2">
                <svg class="w-4 h-4 text-slate-500" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>
                Display as
            </span>
            <span class="text-xs text-slate-400 font-medium">Select</span>
        </div>
        {{-- Duplicate --}}
        <button id="prop-panel-duplicate" type="button"
                class="w-full flex items-center gap-3 px-2 py-2.5 rounded-lg text-sm font-semibold text-slate-400 hover:text-white hover:bg-white/10 transition-colors cursor-pointer">
            <svg class="w-4 h-4 shrink-0" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="9" y="9" width="13" height="13" rx="2"/><path d="M5 15H4a2 2 0 0 1-2-2V4a2 2 0 0 1 2-2h9a2 2 0 0 1 2 2v1"/></svg>
            Duplicate property
        </button>
        {{-- Delete --}}
        <button id="prop-panel-delete" type="button"
                class="w-full flex items-center gap-3 px-2 py-2.5 rounded-lg text-sm font-semibold text-red-400 hover:text-red-300 hover:bg-white/10 transition-colors cursor-pointer">
            <svg class="w-4 h-4 shrink-0" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="3 6 5 6 21 6"/><path d="M19 6l-1 14a2 2 0 0 1-2 2H8a2 2 0 0 1-2-2L5 6"/><path d="M10 11v6M14 11v6"/></svg>
            Delete property
        </button>
    </div>
</aside>

{{-- Color picker (reused from prop-color-picker id) --}}
<div id="prop-color-picker"
     class="fixed z-[70] hidden w-56 rounded-xl p-3"
     style="background:#1e293b;border:1px solid rgba(255,255,255,0.1);box-shadow:0 16px 48px rgba(0,0,0,0.5);">
    <div class="flex items-center gap-2 mb-3">
        <input id="prop-color-input" type="text" maxlength="7" placeholder="#6b7280"
               class="flex-1 bg-white/10 rounded-lg px-2 py-1.5 text-xs font-mono text-white outline-none border border-white/10 focus:border-white/30">
        <div id="prop-color-preview" class="w-8 h-8 rounded-lg border border-white/20 shrink-0"></div>
    </div>
    <div id="prop-color-swatches" class="grid grid-cols-5 gap-1.5 mb-3">
        @foreach(['#94a3b8','#6b7280','#92400e','#f97316','#eab308','#22c55e','#3b82f6','#8b5cf6','#ec4899','#ef4444','#dc2626','#ca8a04','#16a34a','#2563eb','#7c3aed','#0d9488','#0891b2','#d97706','#1e293b','#ffffff'] as $sw)
        <button type="button" class="prop-color-swatch w-7 h-7 rounded-lg cursor-pointer border-2 border-transparent hover:border-white/50 hover:scale-110 transition-all"
                data-color="{{ $sw }}" style="background-color:{{ $sw }};"></button>
        @endforeach
    </div>
    <div class="flex justify-end">
        <button id="prop-color-confirm" type="button"
                class="px-4 py-1.5 rounded-lg text-xs font-bold text-white cursor-pointer transition-colors"
                style="background:#0d9488;">Apply</button>
    </div>
</div>
