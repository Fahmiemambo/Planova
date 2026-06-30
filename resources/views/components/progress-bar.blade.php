@props([
    'value'    => 0,
    'max'      => 100,
    'label'    => '',
    'showText' => true,
    'height'   => 'h-1.5',
])

@php
    $pct = $max > 0 ? min(100, round(($value / $max) * 100)) : 0;
    
    // Determine bar color based on percentage
    $barColorClass = 'bg-primary';
    $textColorClass = 'text-text-main dark:text-text-darkMain';
    
    if ($pct >= 100) {
        $barColorClass = 'bg-red-500';
        $textColorClass = 'text-red-500';
    } elseif ($pct >= 80) {
        $barColorClass = 'bg-amber-500';
        $textColorClass = 'text-amber-500';
    }
@endphp

<div>
    @if($label || $showText)
    <div class="flex justify-between items-center mb-1">
        <span class="text-xs text-text-secondary dark:text-text-darkSecondary">{{ $label }}</span>
        @if($showText)
            <span class="text-xs font-semibold {{ $textColorClass }}">
                {{ $pct }}%
            </span>
        @endif
    </div>
    @endif
    
    {{-- Background track --}}
    <div class="w-full bg-surface-300 dark:bg-dark-surface3 rounded-full overflow-hidden {{ $height }}">
        {{-- Animated progress bar --}}
        <div class="h-full rounded-full transition-all duration-1000 ease-out {{ $barColorClass }}"
             style="width: 0%;"
             data-target-width="{{ $pct }}%"
             role="progressbar"
             aria-valuenow="{{ $pct }}"
             aria-valuemin="0"
             aria-valuemax="100">
        </div>
    </div>
</div>

{{-- Note: the width animation will be handled by anime.js on mount, or we can just use CSS transition --}}
<script>
    // Simple inline script to animate width on load using CSS transitions
    setTimeout(() => {
        document.querySelectorAll('[data-target-width]').forEach(el => {
            el.style.width = el.getAttribute('data-target-width');
        });
    }, 100);
</script>
