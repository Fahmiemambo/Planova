@props([
    'type'    => 'success',  {{-- success | danger | warning | info --}}
    'message' => '',
    'icon'    => null,
    'dismiss' => true,
])

@php
    $icons = [
        'success' => 'bi-check-circle-fill',
        'danger'  => 'bi-exclamation-circle-fill',
        'warning' => 'bi-exclamation-triangle-fill',
        'info'    => 'bi-info-circle-fill',
    ];
    $resolvedIcon = $icon ?? ($icons[$type] ?? $icons['info']);
@endphp

<div class="alert-p alert-p-{{ $type }} animate-fadeInUp" {{ $dismiss ? 'data-auto-dismiss' : '' }}>
    <i class="bi {{ $resolvedIcon }}"></i>
    <div class="flex-1">
        {{ $message ?: $slot }}
    </div>
</div>
