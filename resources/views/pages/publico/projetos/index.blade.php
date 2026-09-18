@extends('layouts.site')

@section('title', 'Projetos')

@section('content')
    <section class="bg-body-tertiary py-5 border-bottom">
        <div class="container text-center py-5">
            <span class="badge rounded-pill bg-primary-subtle text-primary fw-semibold px-3 py-2 mb-3 d-inline-flex align-items-center gap-2" style="font-size: 11px; letter-spacing: 0.5px;">
                <i class="bi bi-circle-fill" style="font-size: 6px;"></i> NOSSOS PROJETOS
            </span>
            <h1 class="fw-bold display-5 mb-3 lh-sm">
                Projetos que geram<br>
                <span class="text-primary">resultados reais</span>
            </h1>
            <p class="text-secondary mx-auto mb-0" style="max-width: 520px;">
                Conheça os sistemas, plataformas e soluções digitais que desenvolvemos para nossos clientes.
            </p>
        </div>
    </section>

    <section class="py-5">
        <div class="container">
            @php
                $categorias = ['Todos', 'Sistemas Web', 'Software Sob Medida', 'Dashboards', 'Landing Pages', 'APIs'];
            @endphp

            <div class="d-flex flex-wrap justify-content-center gap-2 mb-5">
                @foreach ($categorias as $categoria)
                    <button type="button"
                            onclick="showCategory('{{ Str::slug($categoria) }}', this)"
                            class="btn btn-sm rounded-pill px-3 py-2 fw-medium category-btn {{ $loop->first ? 'btn-primary' : 'btn-outline-secondary border text-secondary bg-white' }}"
                            style="font-size: 13px;">
                        {{ $categoria }}
                    </button>
                @endforeach
            </div>

            @include('pages.publico.projetos.categorias.todos')
            @include('pages.publico.projetos.categorias.sistemas-web')
            @include('pages.publico.projetos.categorias.software-sob-medida')
            @include('pages.publico.projetos.categorias.dashboards')
            @include('pages.publico.projetos.categorias.landing-pages')
            @include('pages.publico.projetos.categorias.apis')

            <script>
                function showCategory(slug, btnElement) {
                    // Oculta todas as grids de categorias
                    document.querySelectorAll('.category-grid').forEach(function(grid) {
                        grid.classList.add('d-none');
                    });
                    
                    // Mostra apenas a selecionada
                    const selectedGrid = document.getElementById('category-' + slug);
                    if (selectedGrid) {
                        selectedGrid.classList.remove('d-none');
                    }
                    
                    // Atualiza o estilo dos botões
                    document.querySelectorAll('.category-btn').forEach(function(btn) {
                        btn.classList.remove('btn-primary');
                        btn.classList.add('btn-outline-secondary', 'border', 'text-secondary', 'bg-white');
                    });
                    
                    // Ativa o botão clicado
                    btnElement.classList.remove('btn-outline-secondary', 'border', 'text-secondary', 'bg-white');
                    btnElement.classList.add('btn-primary');
                }
            </script>
        </div>
    </section>

    <section class="py-5">
        <div class="container">
            <div class="bg-dark text-white rounded-4 p-5">
                <div class="text-center mb-5">
                    <h2 class="fw-bold h3 mb-2">Como trabalhamos</h2>
                    <p class="text-white-50 mb-0" style="font-size: 13px;">Um processo transparente para levar seu projeto do papel à realidade.</p>
                </div>

                @php
                    $etapas = [
                        ['numero' => '01', 'titulo' => 'Contato', 'descricao' => 'Briefing inicial para entender seu desafio e objetivos.'],
                        ['numero' => '02', 'titulo' => 'Análise', 'descricao' => 'Estudo de viabilidade técnica e arquitetura.'],
                        ['numero' => '03', 'titulo' => 'Proposta', 'descricao' => 'Cronograma detalhado e investimento transparente.'],
                        ['numero' => '04', 'titulo' => 'Dev', 'descricao' => 'Desenvolvimento ágil com entregas semanais.'],
                        ['numero' => '05', 'titulo' => 'Entrega', 'descricao' => 'Lançamento, treinamento e início do suporte.'],
                    ];
                @endphp

                <div class="row g-4 text-center">
                    @foreach ($etapas as $etapa)
                        <div class="col-6 col-md-4 col-lg">
                            <div class="d-inline-flex align-items-center justify-content-center rounded-circle border border-secondary border-opacity-25 mb-3"
                                 style="width: 64px; height: 64px; background: rgba(255,255,255,0.04);">
                                <span class="fw-bold fs-5">{{ $etapa['numero'] }}</span>
                            </div>
                            <h3 class="fw-bold mb-2" style="font-size: 13px;">{{ $etapa['titulo'] }}</h3>
                            <p class="text-white-50 mb-0" style="font-size: 11px;">{{ $etapa['descricao'] }}</p>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </section>

    <section class="bg-body-tertiary py-5">
        <div class="container text-center py-4">
            <h2 class="fw-bold h3 mb-3">Tem um projeto em mente?</h2>
            <p class="text-secondary mx-auto mb-4" style="max-width: 460px;">
                Cada negócio é único. Vamos conversar sobre sua ideia e construir uma solução personalizada.
            </p>
            <a href="{{ route('publico.contato.index') }}" class="btn btn-primary fw-semibold px-4 py-2 d-inline-flex align-items-center gap-2">
                <i class="bi bi-chat-dots"></i> Falar sobre meu projeto
            </a>
        </div>
    </section>
@endsection