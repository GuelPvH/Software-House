@props([
    'title' => 'Dashboard',
    'page' => 'Dashboard',
])

<x-layouts.base :title="$title" body-class="admin-dashboard-body" :theme="auth()->user()?->preferences['theme'] ?? 'light'">
    <style>
        [data-bs-theme="dark"] .admin-dashboard-body, [data-bs-theme="dark"] .admin-content { background: #121922; color: #e6edf5; }
        [data-bs-theme="dark"] .admin-sidebar, [data-bs-theme="dark"] .admin-topbar, [data-bs-theme="dark"] .settings-section, [data-bs-theme="dark"] .settings-section-card, [data-bs-theme="dark"] .card { background-color: #1c2633; color: #e6edf5; border-color: #344252 !important; }
        [data-bs-theme="dark"] .admin-brand, [data-bs-theme="dark"] .settings-heading, [data-bs-theme="dark"] .settings-section-title, [data-bs-theme="dark"] .admin-sidebar .nav-link, [data-bs-theme="dark"] .settings-tab { color: #dbe5ef; }
        [data-bs-theme="dark"] .admin-sidebar .nav-link.active { color: white; }
        [data-bs-theme="dark"] .admin-content :is(h1,h2,h3,h4,h5,h6), [data-bs-theme="dark"] .admin-content .ui-panel-title { color: #e6edf5 !important; }
        [data-bs-theme="dark"] .admin-content :is(.text-secondary,.text-muted,.ui-page-header-subtitle,.ui-panel-subtitle) { color: #aab9cb !important; }
        [data-bs-theme="dark"] .admin-content .bg-white { background-color: #1c2633 !important; }
        .settings-tabs { overflow-y: hidden; }
        .kanban-live-card { cursor: grab; }
        .kanban-live-card:active { cursor: grabbing; }
    </style>
    <div class="admin-shell">
        <x-admin.sidebar />

        <div class="admin-main">
            <x-admin.topbar :page="$page ?? 'Dashboard'" />

            <main class="admin-content">
                @if(session('success'))<div class="alert alert-success" role="status">{{ session('success') }}</div>@endif
                @if($errors->any())<div class="alert alert-danger" role="alert"><ul class="mb-0">@foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul></div>@endif
                {{ $slot }}
            </main>
        </div>
    </div>

    <x-form.notification />
</x-layouts.base>
