@props([
    'type' => null,
    'message' => null,
    'title' => null,
    'delay' => 5000,
])

@php
    $type = $type ?? (session('success') ? 'success' : (session('error') ? 'error' : null));
    $message = $message ?? session('success') ?? session('error');

    if (! $message) {
        return;
    }

    $isSuccess = $type === 'success';
    $color = $isSuccess ? 'success' : 'danger';
    $title = $title ?? ($isSuccess ? 'Sucesso' : 'Erro');
    $icon = $isSuccess ? 'bi-check-circle-fill' : 'bi-x-circle-fill';
@endphp

<div class="toast-container position-fixed top-0 end-0 p-3" style="z-index: 1090;">
    <div
        id="toast-notification"
        class="toast bg-white shadow"
        role="alert"
        aria-live="assertive"
        aria-atomic="true"
        data-bs-delay="{{ $delay }}"
    >
        <div class="toast-header bg-white">
            <i class="bi {{ $icon }} text-{{ $color }} me-2"></i>
            <strong class="me-auto text-{{ $color }}">{{ $title }}</strong>
            <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Fechar"></button>
        </div>
        <div class="toast-body text-{{ $color }}">
            {{ $message }}
        </div>
    </div>
</div>

<script>
    (() => {
        const showToast = () => {
            const el = document.getElementById('toast-notification');
            if (el && window.bootstrap?.Toast) {
                bootstrap.Toast.getOrCreateInstance(el).show();
            }
        };

        if (document.readyState === 'complete') {
            showToast();
        } else {
            window.addEventListener('load', showToast);
        }
    })();
</script>
