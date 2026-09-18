@props(['page' => 'Dashboard'])
<header class="admin-topbar d-flex align-items-center justify-content-between gap-3" data-profile="{{ auth()->user()->role()->value }}">
<div class="d-flex align-items-center gap-3"><button class="btn btn-light d-lg-none" type="button" data-bs-toggle="offcanvas" data-bs-target="#adminSidebar" aria-controls="adminSidebar" aria-label="Abrir menu"><i class="bi bi-list"></i></button>
<div role="navigation" aria-label="breadcrumb"><strong>{{ auth()->user()->role()->label() }}</strong><div class="small text-secondary">{{ $page }}</div></div></div>
<a class="text-decoration-none text-body d-flex align-items-center gap-2" href="{{ route('admin.settings.profile') }}">@if(auth()->user()->avatar_path)<img class="rounded-circle" width="36" height="36" style="object-fit:cover" src="{{ route('admin.settings.photo',auth()->id()) }}" alt="Sua foto">@endif<span>{{ auth()->user()->name }}</span></a>
</header>
