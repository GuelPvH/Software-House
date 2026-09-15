@props([
    'target' => null,
    'modal' => null,
    'variant' => 'primary',
    'color' => null,
    'size' => null,
    'icon' => null,
    'label' => null,
    'type' => 'button',
])

@php
    $targetId = $target ?? $modal;
    $modalTarget = null;
    if ($targetId) {
        $modalTarget = (str_starts_with($targetId, '#') || str_starts_with($targetId, '.'))
            ? $targetId
            : '#' . $targetId;
    }

    $btnVariant = $color ?? $variant;
    $hasExplicitBtnClass = $btnVariant && str_starts_with($btnVariant, 'btn-');
    $variantClass = $btnVariant
        ? ($hasExplicitBtnClass ? $btnVariant : 'btn-' . $btnVariant)
        : 'btn-primary';

    $sizeClass = match ($size) {
        'sm' => 'btn-sm',
        'lg' => 'btn-lg',
        default => null,
    };

    $iconClass = null;
    if ($icon) {
        if (str_starts_with($icon, 'bi ') || str_starts_with($icon, 'fa ') || str_starts_with($icon, 'fas ')) {
            $iconClass = $icon;
        } elseif (str_starts_with($icon, 'bi-')) {
            $iconClass = 'bi ' . $icon;
        } else {
            $iconClass = 'bi bi-' . $icon;
        }
    }
@endphp

<button
    type="{{ $type }}"
    data-bs-toggle="modal"
    @if ($modalTarget) data-bs-target="{{ $modalTarget }}" @endif
    {{ $attributes->class([
        'btn',
        $variantClass,
        $sizeClass,
        'd-inline-flex align-items-center gap-1' => (bool) $icon,
    ]) }}
>
    @if ($icon)
        <i class="{{ $iconClass }}" aria-hidden="true"></i>
    @endif

    {{ $slot->isNotEmpty() ? $slot : $label }}
</button>

