@props([
    'title' => '',
    'icon'  => '',
    'iconClass' => 'pcard-icon-primary',
    'class' => '',
    'sm'    => false,
])

<div class="pcard {{ $sm ? 'pcard-sm' : '' }} {{ $class }}">
    @if($title || $icon)
    <div class="pcard-header">
        @if($title)
            <h3 class="pcard-title">{{ $title }}</h3>
        @endif
        @if($icon)
            <div class="pcard-icon {{ $iconClass }}">
                <i class="bi {{ $icon }}"></i>
            </div>
        @endif
    </div>
    @endif
    {{ $slot }}
</div>
