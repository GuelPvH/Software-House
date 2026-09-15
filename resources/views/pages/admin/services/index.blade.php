<x-admin.layout title="Serviços & Conteúdo" page="Serviços & Conteúdo">
    <h1 class="visually-hidden">Serviços & Conteúdo</h1>

    <div class="row g-3 h-100">
        <div class="col-12 col-xl-9 d-flex flex-column gap-3">
            <ul class="nav nav-tabs border-bottom mb-2 gap-3" style="font-size: 14px;">
                <li class="nav-item">
                    <a class="nav-link active fw-bold text-primary border-bottom border-2 border-primary bg-transparent px-0 pb-3" href="#">Serviços</a>
                </li>
            </ul>

            <!-- Header -->
            <div class="d-flex justify-content-between align-items-center mb-2 mt-2">
                <div>
                    <h2 class="h5 fw-bold mb-1">Serviços</h2>
                    <p class="text-secondary small mb-0">Gerencie os serviços exibidos no site público da Deploy.</p>
                </div>
            </div>
            <div class="row g-3 flex-grow-1 align-content-start pb-4">
                <div class="col-12 col-md-6 col-lg-4">
                    <button id="btn-add-service" class="card border-primary border-2 border-dashed shadow-none rounded-4 h-100 p-4 w-100 d-flex flex-column align-items-center justify-content-center bg-transparent gap-2" style="border-style: dashed; opacity: 0.7; transition: all 0.2s;">
                        <div class="bg-primary-subtle text-primary rounded-circle d-flex align-items-center justify-content-center mb-2" style="width: 48px; height: 48px;">
                            <i class="bi bi-plus" style="font-size: 24px;"></i>
                        </div>
                        <span class="fw-bold text-primary" style="font-size: 14px;">Adicionar Serviço</span>
                        <span class="text-secondary" style="font-size: 11px;">Clique para criar um novo serviço no site</span>
                    </button>
                </div>
                @foreach ($services as $service)                    
                <div class="col-12 col-md-6 col-lg-4">
                    <div class="card border border-light-subtle shadow-sm rounded-4 h-100 p-3">
                        <div class="d-flex justify-content-between align-items-start mb-2">
                            <div class="d-flex align-items-center gap-2">
                                <div class="bg-primary-subtle text-primary rounded d-flex align-items-center justify-content-center" style="width: 32px; height: 32px;">
                                    <i class="{{$service->icon}}"></i>
                                </div>
                                <h3 class="h6 fw-bold mb-0 text-dark" style="font-size: 13px;">{{$service->name}}</h3>
                            </div>
                        </div>
                        <div class="d-flex align-items-center gap-2 mb-2">
                            <div class="form-check form-switch m-0 p-0 d-flex align-items-center gap-2 ms-0 ps-0">
                                <label class="form-check-label text-{{$service->status == 1 ? 'success' : 'danger'}} fw-medium d-flex align-items-center gap-1" style="font-size: 14px;">
                                    <i class="bi bi-circle-fill" style="font-size: 11px;">{{$service->status == 1 ? 'Publicado' : 'Despublicado'}}</i>
                                </label>
                            </div>
                        </div>
                        <p class="text-secondary lh-sm mb-3 flex-grow-1" style="font-size: 11px;">
                            {{$service->description}}
                        </p>
                        <div class="d-flex gap-1 flex-wrap mb-3">
                            @foreach ($service->tags as $tag)
                                <span class="badge text-primary bg-primary-subtle fw-medium" style="font-size: 10px;">{{$tag}}</span>
                            @endforeach
                        </div>
                        <div class="d-flex justify-content-between align-items-center mt-auto">
                            <button type="button" class="btn btn-outline-primary btn-sm px-3 fw-medium btn-edit-service" data-id="{{$service->id}}" style="font-size: 11px; border-radius: 6px;">Editar</button>
                            <form action="{{ route('admin.services.unpublish', $service->id) }}" method="POST" class="m-0 p-0">
                                @csrf
                                @method('PATCH')
                                <button type="submit" class="btn btn-outline-{{$service->status == 1 ? 'danger' : 'success'}} btn-sm px-3 fw-medium" style="font-size: 11px; border-radius: 6px;">{{$service->status == 1 ? 'Despublicar' : 'Publicar'}}</button>
                            </form>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
        <div class="col-12 col-xl-3 h-100" id="service-form-container">
            @include('components.admin.services.cad-edit', ['service' => $selectedService ?? null])
        </div>
    </div>
    
    <style>
        .nav-tabs .nav-link.active {
            color: #0d6efd !important;
            border-bottom-color: #0d6efd !important;
        }
        .nav-tabs .nav-link:hover:not(.active) {
            border-color: transparent !important;
            color: #495057 !important;
        }
    </style>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const container = document.getElementById('service-form-container');

            // Adicionar novo serviço
            const btnAdd = document.getElementById('btn-add-service');
            if (btnAdd) {
                btnAdd.addEventListener('click', function() {
                    fetch('{{ route('admin.services.index') }}?create=1', {
                        headers: {
                            'X-Requested-With': 'XMLHttpRequest'
                        }
                    })
                    .then(response => response.text())
                    .then(html => {
                        container.innerHTML = html;
                    });
                });
            }

            // Editar serviço
            document.querySelectorAll('.btn-edit-service').forEach(btn => {
                btn.addEventListener('click', function() {
                    const serviceId = this.getAttribute('data-id');
                    fetch(`{{ route('admin.services.index') }}?service_id=${serviceId}`, {
                        headers: {
                            'X-Requested-With': 'XMLHttpRequest'
                        }
                    })
                    .then(response => response.text())
                    .then(html => {
                        container.innerHTML = html;
                    });
                });
            });

            document.querySelectorAll('.btn-edit-service').forEach(btn => {
                btn.addEventListener('click', function() {
                    const serviceId = this.getAttribute('data-id');
                    fetch(`{{ route('admin.services.index') }}?service_id=${serviceId}`, {
                        headers: {
                            'X-Requested-With': 'XMLHttpRequest'
                        }
                    })
                    .then(response => response.text())
                    .then(html => {
                        container.innerHTML = html;
                    });
                });
            });
        });
    </script>
</x-admin.layout>
