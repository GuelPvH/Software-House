<x-admin.layout title="Leads & Orçamentos" page="Leads & Orçamentos">
    <h1 class="visually-hidden">Leads & Orçamentos</h1>

    <div class="row g-3">
        <!-- Main Content -->
        <div class="col-12 col-xl-9 d-flex flex-column gap-3">
            <!-- Stats -->
            <section class="row g-3" aria-label="Indicadores de leads">
                <div class="col-12 col-sm-6 col-md-3">
                    <x-admin.stat-card label="Total de Leads" value="28" icon="bi-person-fill" tone="blue" note="+12% este mês" />
                </div>
                <div class="col-12 col-sm-6 col-md-3">
                    <x-admin.stat-card label="Em Análise" value="11" icon="bi-hourglass-split" tone="yellow" note="aguardando retorno" />
                </div>
                <div class="col-12 col-sm-6 col-md-3">
                    <x-admin.stat-card label="Proposta Enviada" value="6" icon="bi-file-earmark-text-fill" tone="purple" note="com proposta em aberto" />
                </div>
                <div class="col-12 col-sm-6 col-md-3">
                    <x-admin.stat-card label="Fechados" value="9" icon="bi-check-circle-fill" tone="green" note="convertidos em projeto" />
                </div>
            </section>

            <!-- Filters -->
            <section class="card dashboard-card bg-white p-3 mb-0 border" aria-label="Filtros">
                <form class="row g-2 align-items-center">
                    <div class="col-12 col-md-3">
                        <div class="input-group">
                            <span class="input-group-text bg-white border-end-0 text-secondary"><i class="bi bi-search"></i></span>
                            <input type="text" class="form-control border-start-0 ps-0" placeholder="Buscar lead...">
                        </div>
                    </div>
                    <div class="col-12 col-md-2 d-flex align-items-center">
                        <label class="me-2 text-secondary small text-nowrap">Status:</label>
                        <select class="form-select border-0 shadow-sm text-secondary bg-light" style="font-size: 13px;">
                            <option>Todos</option>
                        </select>
                    </div>
                    <div class="col-12 col-md-3 d-flex align-items-center">
                        <label class="me-2 text-secondary small text-nowrap">Tipo de Projeto:</label>
                        <select class="form-select border-0 shadow-sm text-secondary bg-light" style="font-size: 13px;">
                            <option>Todos</option>
                        </select>
                    </div>
                    <div class="col-12 col-md-2 d-flex align-items-center">
                        <label class="me-2 text-secondary small text-nowrap">Período:</label>
                        <select class="form-select border-0 shadow-sm text-secondary bg-light" style="font-size: 13px;">
                            <option>Este mês</option>
                        </select>
                    </div>
                    <div class="col-12 col-md-2 d-flex gap-2 justify-content-md-end mt-3 mt-md-0">
                        <button type="button" class="btn btn-outline-secondary btn-sm bg-white d-flex align-items-center gap-1">
                            <i class="bi bi-download"></i> Exportar CSV
                        </button>
                        <button type="submit" class="btn btn-primary btn-sm d-flex align-items-center gap-1">
                            <i class="bi bi-funnel-fill"></i> Filtrar
                        </button>
                    </div>
                </form>
            </section>

            <!-- Table -->
            <section aria-label="Tabela de leads">
                @php
                    $leads = [
                        ['id' => '01', 'name' => 'João Silva', 'company' => 'TechBR', 'avatar' => 'joao-silva.png', 'contact' => "joao@techbr.com\n(11) 99999-1111", 'type' => 'Sistema Web', 'typeClass' => '', 'prazo' => '3 meses', 'objetivo' => 'Automatizar gestão de...', 'status' => 'Novo', 'statusClass' => 'badge-blue', 'date' => '15 Jun 2025', 'active' => true],
                        ['id' => '02', 'name' => 'Maria Santos', 'company' => 'Logística SA', 'avatar' => 'maria-santos.png', 'contact' => "maria@logistica.com.br\n(21) 98888-2222", 'type' => 'Software Custom', 'typeClass' => 'type-purple', 'prazo' => '6 meses', 'objetivo' => 'Sistema de rastreamento...', 'status' => 'Em Análise', 'statusClass' => 'badge-yellow', 'date' => '14 Jun 2025', 'active' => false],
                        ['id' => '03', 'name' => 'Carlos Mendes', 'company' => 'FinTech Plus', 'avatar' => 'carlos-mendes.png', 'contact' => "carlos@fintech.com\n(11) 97777-3333", 'type' => 'Dashboard BI', 'typeClass' => 'type-purple', 'prazo' => '2 meses', 'objetivo' => 'Painel de métricas...', 'status' => 'Proposta Enviada', 'statusClass' => 'badge-purple', 'date' => '13 Jun 2025', 'active' => false],
                        ['id' => '04', 'name' => 'Ana Lima', 'company' => 'Varejo Digital', 'avatar' => 'ana-lima.png', 'contact' => "ana@varejo.com\n(31) 96666-4444", 'type' => 'Landing Page', 'typeClass' => 'type-pink', 'prazo' => '1 mês', 'objetivo' => 'Aumentar conversão...', 'status' => 'Fechado', 'statusClass' => 'badge-green', 'date' => '12 Jun 2025', 'active' => false],
                        ['id' => '05', 'name' => 'Pedro Costa', 'company' => 'Ind. Moderna', 'avatar' => 'pedro-costa.png', 'contact' => "pedro@ind.com\n(41) 95555-5555", 'type' => 'API Gateway', 'typeClass' => 'text-warning bg-warning-subtle', 'prazo' => '4 meses', 'objetivo' => 'Integração com ERP...', 'status' => 'Novo', 'statusClass' => 'badge-blue', 'date' => '11 Jun 2025', 'active' => false],
                        ['id' => '06', 'name' => 'Beatriz Rocha', 'company' => 'Saúde Tech', 'avatar' => 'beatriz-rocha.png', 'contact' => "bea@saude.com\n(85) 94444-6666", 'type' => 'Sistema Web', 'typeClass' => '', 'prazo' => '5 meses', 'objetivo' => 'Prontuário eletrônico...', 'status' => 'Em Análise', 'statusClass' => 'badge-yellow', 'date' => '10 Jun 2025', 'active' => false],
                        ['id' => '07', 'name' => 'Rafael Moura', 'company' => 'EduPlat', 'avatar' => 'rafael-moura.png', 'contact' => "rafael@edu.com\n(51) 93333-7777", 'type' => 'Software Custom', 'typeClass' => 'type-purple', 'prazo' => '8 meses', 'objetivo' => 'Plataforma de ensino...', 'status' => 'Proposta Enviada', 'statusClass' => 'badge-purple', 'date' => '9 Jun 2025', 'active' => false],
                        ['id' => '08', 'name' => 'Camila Nunes', 'company' => 'AgriTech', 'avatar' => 'camila-nunes.png', 'contact' => "camila@agri.com\n(62) 92222-8888", 'type' => 'Dashboard BI', 'typeClass' => 'type-purple', 'prazo' => '3 meses', 'objetivo' => 'Monitoramento de...', 'status' => 'Perdido', 'statusClass' => 'bg-danger-subtle text-danger', 'date' => '8 Jun 2025', 'active' => false],
                        ['id' => '09', 'name' => 'Lucas Ferreira', 'company' => 'Construtech', 'avatar' => 'lucas-ferreira.png', 'contact' => "lucas@constru.com\n(12) 91111-9999", 'type' => 'Sistema Web', 'typeClass' => '', 'prazo' => '12 meses', 'objetivo' => 'Gestão de obras e...', 'status' => 'Em Análise', 'statusClass' => 'badge-yellow', 'date' => '7 Jun 2025', 'active' => false],
                        ['id' => '10', 'name' => 'Fernanda Gomes', 'company' => 'RetailMax', 'avatar' => 'fernanda-gomes.png', 'contact' => "fernanda@retail.com\n(11) 90000-0000", 'type' => 'Landing Page', 'typeClass' => 'type-pink', 'prazo' => '2 semanas', 'objetivo' => 'Lançamento de...', 'status' => 'Fechado', 'statusClass' => 'badge-green', 'date' => '6 Jun 2025', 'active' => false],
                    ];
                @endphp

                <article class="card dashboard-card leads-card overflow-hidden border-0 bg-white">
                    <div class="card-header d-flex flex-wrap align-items-center justify-content-between bg-white px-4 py-3 border-bottom">
                        <div class="d-flex align-items-center gap-2">
                            <h2 class="section-title mb-0 fs-5 fw-bold">Todos os Leads</h2>
                            <span class="badge rounded-pill bg-primary-subtle text-primary">28</span>
                        </div>
                        <button type="button" class="btn btn-primary btn-sm px-3 d-flex align-items-center gap-1">
                            <i class="bi bi-plus-lg"></i> Novo Lead
                        </button>
                    </div>

                    <div class="table-responsive flex-grow-1" style="min-height: 500px">
                        <table class="table table-hover leads-table mb-0 align-middle">
                            <thead class="table-light text-secondary" style="font-size: 11px;">
                                <tr>
                                    <th scope="col" class="fw-medium">#</th>
                                    <th scope="col" class="fw-medium">NOME & EMPRESA</th>
                                    <th scope="col" class="fw-medium">CONTATO</th>
                                    <th scope="col" class="fw-medium">TIPO DE PROJETO</th>
                                    <th scope="col" class="fw-medium">PRAZO</th>
                                    <th scope="col" class="fw-medium">OBJETIVO</th>
                                    <th scope="col" class="fw-medium">STATUS</th>
                                    <th scope="col" class="fw-medium">DATA</th>
                                    <th scope="col" class="text-end fw-medium">AÇÕES</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($leads as $lead)
                                    <tr class="{{ $lead['active'] ? 'bg-primary-subtle' : '' }}" style="cursor: pointer; {{ $lead['active'] ? 'border-left: 3px solid #0d6efd;' : '' }}">
                                        <td class="text-secondary small">{{ $lead['id'] }}</td>
                                        <td>
                                            <div class="d-flex align-items-center gap-2">
                                                <img src="{{ asset('images/admin/'.$lead['avatar']) }}" onerror="this.src='https://ui-avatars.com/api/?name={{ urlencode($lead['name']) }}&background=f3f4f6&color=6c757d'" alt="" class="admin-avatar-sm rounded-circle border">
                                                <div class="lh-sm">
                                                    <span class="d-block fw-medium text-dark" style="font-size: 13px">{{ $lead['name'] }}</span>
                                                    <span class="d-block text-secondary" style="font-size: 11px">{{ $lead['company'] }}</span>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="lh-sm">
                                            @php $contacts = explode("\n", $lead['contact']); @endphp
                                            <span class="d-block text-secondary" style="font-size: 12px">{{ $contacts[0] }}</span>
                                            <span class="d-block text-secondary" style="font-size: 12px">{{ $contacts[1] }}</span>
                                        </td>
                                        <td><span class="type-badge {{ $lead['typeClass'] ?: 'text-primary bg-primary-subtle' }} px-2 py-1 rounded-1 fw-medium" style="font-size: 11px">{{ $lead['type'] }}</span></td>
                                        <td class="text-secondary small">{{ $lead['prazo'] }}</td>
                                        <td class="text-secondary small text-truncate" style="max-width: 150px;">{{ $lead['objetivo'] }}</td>
                                        <td><span class="soft-badge {{ $lead['statusClass'] }} rounded-pill px-2 py-1 fw-medium" style="font-size: 11px">{{ $lead['status'] }}</span></td>
                                        <td class="text-secondary small text-nowrap">{{ $lead['date'] }}</td>
                                        <td>
                                            <div class="d-flex justify-content-end gap-1">
                                                <button type="button" class="btn btn-sm btn-light text-primary {{ $lead['active'] ? 'bg-primary text-white' : '' }} border-0" aria-label="Visualizar" style="border-radius: 4px;">
                                                    <i class="bi bi-eye-fill"></i>
                                                </button>
                                                <button type="button" class="btn btn-sm btn-light text-secondary border-0" aria-label="Excluir" style="border-radius: 4px;">
                                                    <i class="bi bi-trash"></i>
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <div class="card-footer d-flex flex-wrap align-items-center justify-content-between gap-3 bg-white px-4 py-3 border-top">
                        <small class="text-secondary" style="font-size: 12px">Mostrando 1–10 de 28 leads</small>
                        <nav aria-label="Paginação dos leads">
                            <ul class="pagination pagination-sm gap-1 mb-0">
                                <li class="page-item disabled"><a class="page-link border-0 rounded text-secondary" href="#" aria-label="Anterior"><i class="bi bi-chevron-left"></i></a></li>
                                <li class="page-item active"><a class="page-link border-0 rounded bg-primary" href="#" aria-current="page">1</a></li>
                                <li class="page-item"><a class="page-link border-0 rounded text-secondary" href="#">2</a></li>
                                <li class="page-item"><a class="page-link border-0 rounded text-secondary" href="#">3</a></li>
                                <li class="page-item"><a class="page-link border-0 rounded text-secondary" href="#" aria-label="Próxima"><i class="bi bi-chevron-right"></i></a></li>
                            </ul>
                        </nav>
                    </div>
                </article>
            </section>
        </div>

        <!-- Right Side Panel / Offcanvas content shown as col -->
        <div class="col-12 col-xl-3">
            <aside class="card border-0 bg-white shadow-sm h-100 rounded-3">
                <div class="card-header bg-white border-bottom d-flex justify-content-between align-items-center py-3 px-4">
                    <h5 class="mb-0 fs-6 fw-bold text-dark d-flex align-items-center gap-2">
                        <i class="bi bi-circle-fill text-primary" style="font-size: 6px;"></i> Detalhes do Lead
                    </h5>
                    <div class="d-flex align-items-center gap-2">
                        <span class="badge bg-primary-subtle text-primary rounded-pill px-2">Novo</span>
                        <button class="btn-close" style="font-size: 10px;"></button>
                    </div>
                </div>

                <div class="card-body px-4 py-4 d-flex flex-column gap-4">
                    <!-- User Info -->
                    <div class="d-flex align-items-center gap-3">
                        <img src="https://ui-avatars.com/api/?name=Joao+Silva&background=f3f4f6&color=6c757d" alt="João Silva" class="rounded-circle border" style="width: 48px; height: 48px;">
                        <div class="lh-sm">
                            <h4 class="fs-6 fw-bold mb-1">João Silva</h4>
                            <span class="text-secondary d-block" style="font-size: 13px;">TechBR</span>
                            <span class="text-secondary d-block" style="font-size: 11px;">Recebido em 15 Jun 2025</span>
                        </div>
                    </div>

                    <!-- Contact Info -->
                    <div class="bg-light rounded-3 p-3 text-secondary" style="font-size: 13px;">
                        <div class="text-uppercase fw-bold text-secondary mb-3" style="font-size: 10px; letter-spacing: 0.5px;">INFORMAÇÕES DE CONTATO</div>
                        <div class="d-flex align-items-center gap-2 mb-2">
                            <i class="bi bi-envelope text-primary"></i> joao@techbr.com
                        </div>
                        <div class="d-flex align-items-center gap-2 mb-2">
                            <i class="bi bi-telephone text-primary"></i> (11) 99999-1111
                        </div>
                        <div class="d-flex align-items-center gap-2">
                            <i class="bi bi-geo-alt text-primary"></i> TechBR - São Paulo, SP
                        </div>
                    </div>

                    <!-- Project Details -->
                    <div>
                        <div class="text-uppercase fw-bold text-secondary mb-3" style="font-size: 10px; letter-spacing: 0.5px;">DETALHES DO PROJETO</div>
                        <div class="row g-2">
                            <div class="col-6">
                                <div class="bg-light rounded-3 p-2 px-3 h-100">
                                    <span class="text-secondary d-block mb-1" style="font-size: 11px;">Tipo</span>
                                    <span class="text-primary bg-primary-subtle px-2 py-1 rounded-1 fw-medium d-inline-block" style="font-size: 12px;">Sistema Web</span>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="bg-light rounded-3 p-2 px-3 h-100">
                                    <span class="text-secondary d-block mb-1" style="font-size: 11px;">Prazo Estimado</span>
                                    <span class="fw-bold d-block text-dark" style="font-size: 13px;">3 meses</span>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="bg-light rounded-3 p-2 px-3 h-100">
                                    <span class="text-secondary d-block mb-1" style="font-size: 11px;">Orçamento</span>
                                    <span class="text-success fw-bold d-block" style="font-size: 13px;">R$ 25.000</span>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="bg-light rounded-3 p-2 px-3 h-100">
                                    <span class="text-secondary d-block mb-1" style="font-size: 11px;">Prioridade</span>
                                    <span class="text-danger fw-medium d-flex align-items-center gap-1" style="font-size: 13px;"><i class="bi bi-circle-fill" style="font-size: 6px;"></i> Alta</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Objective/Description -->
                    <div>
                        <div class="text-uppercase fw-bold text-secondary mb-2" style="font-size: 10px; letter-spacing: 0.5px;">OBJETIVO / DESCRIÇÃO</div>
                        <div class="bg-light rounded-3 p-3">
                            <p class="text-secondary m-0 lh-base" style="font-size: 13px;">
                                Automatizar a gestão de estoque da empresa TechBR, com módulos de entrada/saída, alertas de reposição automáticos e relatórios de movimentação em tempo real integrados ao sistema financeiro existente.
                            </p>
                        </div>
                    </div>

                    <!-- Actions -->
                    <div class="d-flex flex-column gap-2 mt-2">
                        <button class="btn btn-primary d-flex justify-content-center align-items-center gap-2 w-100 fw-medium">
                            <i class="bi bi-file-earmark-text"></i> Enviar Proposta
                        </button>
                        <button class="btn btn-outline-primary d-flex justify-content-center align-items-center gap-2 w-100 fw-medium">
                            <i class="bi bi-calendar-event"></i> Agendar Reunião
                        </button>
                        <button class="btn btn-link text-secondary text-decoration-none d-flex justify-content-center align-items-center gap-1 w-100 mt-1" style="font-size: 13px;">
                            <i class="bi bi-x"></i> Marcar como Perdido
                        </button>
                    </div>

                    <!-- Activity -->
                    <div class="mt-2 border-top pt-4">
                        <div class="text-uppercase fw-bold text-secondary mb-4" style="font-size: 10px; letter-spacing: 0.5px;">ATIVIDADE DO LEAD</div>
                        
                        <div class="position-relative ms-2 border-start border-2 border-light pb-4">
                            <div class="position-absolute top-0 start-0 translate-middle p-1 bg-primary rounded-circle border border-2 border-white d-flex align-items-center justify-content-center" style="width: 24px; height: 24px; margin-left: -1px;">
                                <i class="bi bi-person-fill text-white" style="font-size: 12px;"></i>
                            </div>
                            <div class="ms-4">
                                <div class="fw-bold text-dark" style="font-size: 13px;">Lead recebido</div>
                                <div class="text-secondary" style="font-size: 11px;">Formulário do site — 15 Jun 2025, 08:42</div>
                            </div>
                        </div>

                        <div class="position-relative ms-2 border-start border-2 border-light pb-4">
                            <div class="position-absolute top-0 start-0 translate-middle p-1 bg-purple rounded-circle border border-2 border-white d-flex align-items-center justify-content-center" style="width: 24px; height: 24px; margin-left: -1px; background-color: #6f42c1;">
                                <i class="bi bi-envelope-fill text-white" style="font-size: 10px;"></i>
                            </div>
                            <div class="ms-4">
                                <div class="fw-bold text-dark" style="font-size: 13px;">Email de boas-vindas enviado</div>
                                <div class="text-secondary" style="font-size: 11px;">Automático — 15 Jun 2025, 08:45</div>
                            </div>
                        </div>
                        
                        <div class="position-relative ms-2 border-start border-2 border-light pb-4">
                            <div class="position-absolute top-0 start-0 translate-middle p-1 bg-warning rounded-circle border border-2 border-white d-flex align-items-center justify-content-center" style="width: 24px; height: 24px; margin-left: -1px;">
                                <i class="bi bi-eye-fill text-white" style="font-size: 12px;"></i>
                            </div>
                            <div class="ms-4">
                                <div class="fw-bold text-dark" style="font-size: 13px;">Lead visualizado</div>
                                <div class="text-secondary" style="font-size: 11px;">Admin User — 15 Jun 2025, 11:00</div>
                            </div>
                        </div>

                        <div class="position-relative ms-2">
                            <div class="position-absolute top-0 start-0 translate-middle p-1 bg-success rounded-circle border border-2 border-white d-flex align-items-center justify-content-center" style="width: 24px; height: 24px; margin-left: -1px;">
                                <i class="bi bi-telephone-fill text-white" style="font-size: 12px;"></i>
                            </div>
                            <div class="ms-4">
                                <div class="fw-bold text-dark" style="font-size: 13px;">Tentativa de contato</div>
                                <div class="text-secondary mb-1" style="font-size: 11px;">Admin User — 15 Jun 2025, 14:30</div>
                                <div class="bg-light p-2 rounded text-secondary" style="font-size: 12px;">Ligou, não atendeu. Deixou recado.</div>
                            </div>
                        </div>

                    </div>
                </div>
            </aside>
        </div>
    </div>

    <!-- Extra styles to match design if not present -->
    @push('styles')
    <style>
        .badge-blue { background-color: #e0f2fe; color: #0284c7; }
        .badge-yellow { background-color: #fef08a; color: #a16207; }
        .badge-purple { background-color: #f3e8ff; color: #7e22ce; }
        .badge-green { background-color: #dcfce7; color: #15803d; }
        .type-purple { background-color: #f3e8ff; color: #7e22ce; }
        .type-pink { background-color: #fce7f3; color: #be185d; }
    </style>
    @endpush
</x-admin.layout>
