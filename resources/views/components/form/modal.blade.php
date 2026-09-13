@props([
    'id' => null,
    'title' => null,
    'size' => 'md',
    'color' => 'primary',
    'centered' => false,
    'scrollable' => false,
    'staticBackdrop' => false,
    'fade' => true,
    'showHeader' => true,
    'showFooter' => true,
    'closeLabel' => 'Cancelar',
    'submitLabel' => 'Salvar',
    'submitType' => 'submit',
    'form' => null,
])

@php
    $modalId = $id ?? 'modal-' . substr(md5((string) mt_rand()), 0, 8);

    $sizeClass = match ($size) {
        'sm' => 'modal-sm',
        'lg' => 'modal-lg',
        'xl' => 'modal-xl',
        'fullscreen' => 'modal-fullscreen',
        default => null,
    };

    $btnColor = $color
        ? (str_starts_with($color, 'btn-') ? $color : 'btn-' . $color)
        : 'btn-primary';
@endphp

<div
    {{ $attributes->class(['modal', 'fade' => $fade]) }}
    id="{{ $modalId }}"
    tabindex="-1"
    @if ($title) aria-labelledby="{{ $modalId }}-title" @endif
    aria-hidden="true"
    @if ($staticBackdrop)
        data-bs-backdrop="static"
        data-bs-keyboard="false"
    @endif
>
    <div @class([
        'modal-dialog',
        $sizeClass,
        'modal-dialog-centered' => $centered,
        'modal-dialog-scrollable' => $scrollable,
    ])>
        <div class="modal-content">
            @if ($showHeader)
                <div class="modal-header">
                    @isset($header)
                        {{ $header }}
                    @else
                        @if ($title)
                            <h5 class="modal-title" id="{{ $modalId }}-title">{{ $title }}</h5>
                        @endif
                    @endisset
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fechar"></button>
                </div>
            @endif

            <div class="modal-body">
                {{ $slot }}
            </div>

            @isset($footer)
                <div class="modal-footer">
                    {{ $footer }}
                </div>
            @elseif ($showFooter)
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{ $closeLabel }}</button>
                    @if ($submitLabel)
                        <button
                            type="{{ $submitType }}"
                            class="btn {{ $btnColor }}"
                            @if ($form) form="{{ $form }}" @endif
                        >
                            {{ $submitLabel }}
                        </button>
                    @endif
                </div>
            @endisset
        </div>
    </div>
</div>
