@props(['categoria', 'titulo', 'descricao', 'imagem'])

<div class="col-12 col-md-6 col-lg-4">
    <article class="card border-0 shadow-sm rounded-4 h-100 overflow-hidden bg-white">
        <div class="overflow-hidden" style="height: 180px;">
            <img src="{{ asset($imagem) }}" alt="{{ $titulo }}" class="w-100 h-100 object-fit-cover transition-transform hover-scale">
        </div>

        <div class="card-body p-4 d-flex flex-column">
            <span class="badge bg-primary bg-opacity-10 text-primary fw-medium align-self-start mb-3 px-2 py-1"
                  style="font-size: 10px; border-radius: 4px;">
                {{ $categoria }}
            </span>

            <h2 class="h6 fw-bold text-dark mb-2">{{ $titulo }}</h2>

            <p class="text-secondary mb-4" style="font-size: 12px;">
                {{ $descricao }}
            </p>

            <a href="#" class="text-primary fw-semibold text-decoration-none mt-auto d-inline-flex align-items-center gap-1" style="font-size: 12px;">
                Ver projeto <i class="bi bi-arrow-right"></i>
            </a>
        </div>
    </article>
</div>
