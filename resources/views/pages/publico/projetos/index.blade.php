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

            <!-- Filtros -->
            @php
                $categorias = ['Todos', 'Sistemas Web', 'Software Sob Medida', 'Dashboards', 'Landing Pages', 'APIs'];
            @endphp

            <div class="d-flex flex-wrap justify-content-center gap-2 mb-5">
                @foreach ($categorias as $categoria)
                    <button type="button"
                            class="btn btn-sm rounded-pill px-3 py-2 fw-medium {{ $loop->first ? 'btn-primary' : 'btn-outline-secondary border text-secondary bg-white' }}"
                            style="font-size: 13px;">
                        {{ $categoria }}
                    </button>
                @endforeach
            </div>

            <!-- Grade de projetos -->
            @php
                $projetos = [
                    [
                        'categoria' => 'Sistemas Web',
                        'titulo' => 'Sistema ERP Industrial',
                        'descricao' => 'Plataforma integrada de gestão industrial com módulos de produção, estoque, faturamento e relatórios em tempo real.',
                        'gradiente' => 'linear-gradient(135deg, #0f172a, #1e3a8a)',
                        'icone' => 'bi-bar-chart-line',
                    ],
                    [
                        'categoria' => 'Software Sob Medida',
                        'titulo' => 'Plataforma CRM Comercial',
                        'descricao' => 'CRM personalizado com funil de vendas visual, gestão de leads, automações e relatórios de performance comercial.',
                        'gradiente' => 'linear-gradient(135deg, #1e293b, #0d6efd)',
                        'icone' => 'bi-kanban',
                    ],
                    [
                        'categoria' => 'Dashboards',
                        'titulo' => 'Dashboard Analytics BI',
                        'descricao' => 'Painel de business intelligence com gráficos interativos, segmentação por período e integração com múltiplas fontes de dados.',
                        'gradiente' => 'linear-gradient(135deg, #7c3aed, #2563eb)',
                        'icone' => 'bi-graph-up-arrow',
                    ],
                    [
                        'categoria' => 'Landing Pages',
                        'titulo' => 'Landing Page Conversão',
                        'descricao' => 'Landing page de alta conversão para produto digital com design persuasivo, carregamento ultra-rápido e otimização para mobile.',
                        'gradiente' => 'linear-gradient(135deg, #0c1a3d, #1d4ed8)',
                        'icone' => 'bi-window-stack',
                    ],
                    [
                        'categoria' => 'APIs',
                        'titulo' => 'API Gateway Financeiro',
                        'descricao' => 'Gateway de APIs financeiras com autenticação OAuth2, rate limiting, criptografia ponta a ponta e logs de auditoria completos.',
                        'gradiente' => 'linear-gradient(135deg, #111827, #1f2937)',
                        'icone' => 'bi-code-slash',
                    ],
                    [
                        'categoria' => 'Sistemas Web',
                        'titulo' => 'Sistema de Gestão RH',
                        'descricao' => 'Plataforma completa de RH com gestão de colaboradores, controle de ponto, férias, folha de pagamento e organograma.',
                        'gradiente' => 'linear-gradient(135deg, #164e63, #0ea5e9)',
                        'icone' => 'bi-people',
                    ],
                ];
            @endphp

            <div class="row g-4">
                @foreach ($projetos as $projeto)
                    <div class="col-12 col-md-6 col-lg-4">
                        <article class="card border-0 shadow-sm rounded-4 h-100 overflow-hidden bg-white">
                            <div class="d-flex align-items-center justify-content-center text-white"
                                 style="height: 180px; background: {{ $projeto['gradiente'] }};">
                                <i class="bi {{ $projeto['icone'] }}" style="font-size: 44px; opacity: 0.85;"></i>
                            </div>

                            <div class="card-body p-4 d-flex flex-column">
                                <span class="badge bg-primary bg-opacity-10 text-primary fw-medium align-self-start mb-3 px-2 py-1"
                                      style="font-size: 10px; border-radius: 4px;">
                                    {{ $projeto['categoria'] }}
                                </span>

                                <h2 class="h6 fw-bold text-dark mb-2">{{ $projeto['titulo'] }}</h2>

                                <p class="text-secondary mb-4" style="font-size: 12px;">
                                    {{ $projeto['descricao'] }}
                                </p>

                                <a href="#" class="text-primary fw-semibold text-decoration-none mt-auto d-inline-flex align-items-center gap-1" style="font-size: 12px;">
                                    Ver projeto <i class="bi bi-arrow-right"></i>
                                </a>
                            </div>
                        </article>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    <!-- Como trabalhamos -->
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

    <!-- CTA final -->
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