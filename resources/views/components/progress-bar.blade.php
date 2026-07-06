@props([
    'value'    => 0,
    'max'      => 100,
    'label'    => '',
    'showText' => true,
])

@php
    $pct = $max > 0 ? min(100, round(($value / $max) * 100)) : 0;
    
    // Determine bar color based on percentage
    $barColorClass = 'clay-progress-fill';
    $textColorClass = 'text-primary-dark';
    
    if ($pct >= 100) {
        $barColorClass = 'bg-red-500 shadow-[0_2px_4px_rgba(239,68,68,0.3)]';
        $textColorClass = 'text-red-500';
    } elseif ($pct >= 80) {
        $barColorClass = 'bg-amber-400 shadow-[0_2px_4px_rgba(251,191,36,0.3)]';
        $textColorClass = 'text-amber-500';
    }
@endphp

<div>
    @if($label || $showText)
    <div class="flex justify-between items-center mb-2">
        <span class="text-xs font-bold text-primary/60 uppercase tracking-wider">{{ $label }}</span>
        @if($showText)
            <span class="text-sm font-bold {{ $textColorClass }}">
                {{ $pct }}%
            </span>
        @endif
    </div>
    @endif
    
    {{-- Background track --}}
    <div class="clay-progress-track">
        {{-- Animated progress bar --}}
        <div class="{{ $barColorClass }} rounded-full transition-all duration-1000 ease-out h-full"
             style="width: 0%;"
             data-target-width="{{ $pct }}%"
             role="progressbar"
             aria-valuenow="{{ $pct }}"
             aria-valuemin="0"
             aria-valuemax="100">
        </div>
    </div>
</div>

<script>
    setTimeout(() => {
        document.querySelectorAll('[data-target-width]').forEach(el => {
            el.style.width = el.getAttribute('data-target-width');
        });
    }, 100);
</script>
