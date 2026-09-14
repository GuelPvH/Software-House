@props(['lead' => null])

@php
    $statusName = $lead?->statusLead?->name ?? 'Novo';
    $badgeClass = match($statusName) {
        'Novo' => 'bg-primary-subtle text-primary',
        'Em Análise' => 'bg-warning-subtle text-warning',
        'Proposta Enviada' => 'bg-info-subtle text-info',
        'Fechado' => 'bg-success-subtle text-success',
        default => 'bg-danger-subtle text-danger',
    };
    $leadName = $lead?->name ?? 'Sem nome';
    $leadCompany = $lead?->company ?? 'Empresa não informada';
    $leadDate = $lead?->created_at ? $lead->created_at->format('d M Y') : '-';
    $leadType = $lead?->projectType?->name ?? 'Sistema Web';
    $leadPrazo = $lead?->deadline ? \Carbon\Carbon::parse($lead->deadline)->format('d/m/Y') : '-';
    $leadValue = $lead?->estimated_value ? 'R$ ' . number_format((float) $lead->estimated_value, 2, ',', '.') : 'A combinar';
    $leadObjective = $lead?->objective ?: 'Nenhum objetivo ou descrição detalhada informada.';
@endphp

<aside class="card border-0 bg-white shadow-sm h-100 rounded-3">
    <div class="card-header bg-white border-bottom d-flex justify-content-between align-items-center py-3 px-4">
        <h5 class="mb-0 fs-6 fw-bold text-dark d-flex align-items-center gap-2">
            <i class="bi bi-circle-fill text-primary" style="font-size: 6px;"></i> Detalhes do Lead
        </h5>
        <div class="d-flex align-items-center gap-2">
            <span class="badge {{ $badgeClass }} rounded-pill px-2">{{ $statusName }}</span>
            <button type="button" class="btn-close btn-close-lead-details" style="font-size: 10px;" aria-label="Fechar"></button>
        </div>
    </div>

    @if ($lead)
        <div class="card-body px-4 py-4 d-flex flex-column gap-4">
            <!-- User Info -->
            <div class="d-flex align-items-center gap-3">
                <img src="https://ui-avatars.com/api/?name={{ urlencode($leadName) }}&background=f3f4f6&color=6c757d" alt="{{ $leadName }}" class="rounded-circle border" style="width: 48px; height: 48px;">
                <div class="lh-sm">
                    <h4 class="fs-6 fw-bold mb-1">{{ $leadName }}</h4>
                    <span class="text-secondary d-block" style="font-size: 13px;">{{ $leadCompany }}</span>
                    <span class="text-secondary d-block" style="font-size: 11px;">Recebido em {{ $leadDate }}</span>
                </div>
            </div>

            <!-- Contact Info -->
            <div class="bg-light rounded-3 p-3 text-secondary" style="font-size: 13px;">
                <div class="text-uppercase fw-bold text-secondary mb-3" style="font-size: 10px; letter-spacing: 0.5px;">INFORMAÇÕES DE CONTATO</div>
                <div class="d-flex align-items-center gap-2 mb-2">
                    <i class="bi bi-envelope text-primary"></i>
                    @if ($lead->email)
                        <a href="mailto:{{ $lead->email }}" class="text-decoration-none text-secondary">{{ $lead->email }}</a>
                    @else
                        <span>-</span>
                    @endif
                </div>
                <div class="d-flex align-items-center gap-2 mb-2">
                    <i class="bi bi-telephone text-primary"></i>
                    @if ($lead->phone)
                        <a href="tel:{{ $lead->phone }}" class="text-decoration-none text-secondary">{{ $lead->phone }}</a>
                    @else
                        <span>-</span>
                    @endif
                </div>
                <div class="d-flex align-items-center gap-2">
                    <i class="bi bi-geo-alt text-primary"></i> {{ $leadCompany }}
                </div>
            </div>

            <!-- Project Details -->
            <div>
                <div class="text-uppercase fw-bold text-secondary mb-3" style="font-size: 10px; letter-spacing: 0.5px;">DETALHES DO PROJETO</div>
                <div class="row g-2">
                    <div class="col-6">
                        <div class="bg-light rounded-3 p-2 px-3 h-100">
                            <span class="text-secondary d-block mb-1" style="font-size: 11px;">Tipo</span>
                            <span class="text-primary bg-primary-subtle px-2 py-1 rounded-1 fw-medium d-inline-block" style="font-size: 12px;">{{ $leadType }}</span>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="bg-light rounded-3 p-2 px-3 h-100">
                            <span class="text-secondary d-block mb-1" style="font-size: 11px;">Prazo Estimado</span>
                            <span class="fw-bold d-block text-dark" style="font-size: 13px;">{{ $leadPrazo }}</span>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="bg-light rounded-3 p-2 px-3 h-100">
                            <span class="text-secondary d-block mb-1" style="font-size: 11px;">Orçamento</span>
                            <span class="text-success fw-bold d-block" style="font-size: 13px;">{{ $leadValue }}</span>
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
                        {{ $leadObjective }}
                    </p>
                </div>
            </div>

            <!-- Actions -->
            <div class="d-flex flex-column gap-2 mt-2">
                <button type="button" class="btn btn-primary d-flex justify-content-center align-items-center gap-2 w-100 fw-medium">
                    <i class="bi bi-file-earmark-text"></i> Enviar Proposta
                </button>
                <button type="button" class="btn btn-outline-primary d-flex justify-content-center align-items-center gap-2 w-100 fw-medium">
                    <i class="bi bi-calendar-event"></i> Agendar Reunião
                </button>
                <button type="button" class="btn btn-link text-secondary text-decoration-none d-flex justify-content-center align-items-center gap-1 w-100 mt-1" style="font-size: 13px;">
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
                        <div class="text-secondary" style="font-size: 11px;">Recebido via formulário — {{ $leadDate }}</div>
                    </div>
                </div>

                <div class="position-relative ms-2 border-start border-2 border-light pb-4">
                    <div class="position-absolute top-0 start-0 translate-middle p-1 bg-purple rounded-circle border border-2 border-white d-flex align-items-center justify-content-center" style="width: 24px; height: 24px; margin-left: -1px; background-color: #6f42c1;">
                        <i class="bi bi-envelope-fill text-white" style="font-size: 10px;"></i>
                    </div>
                    <div class="ms-4">
                        <div class="fw-bold text-dark" style="font-size: 13px;">Email de confirmação</div>
                        <div class="text-secondary" style="font-size: 11px;">Automático — {{ $leadDate }}</div>
                    </div>
                </div>

                <div class="position-relative ms-2">
                    <div class="position-absolute top-0 start-0 translate-middle p-1 bg-warning rounded-circle border border-2 border-white d-flex align-items-center justify-content-center" style="width: 24px; height: 24px; margin-left: -1px;">
                        <i class="bi bi-eye-fill text-white" style="font-size: 12px;"></i>
                    </div>
                    <div class="ms-4">
                        <div class="fw-bold text-dark" style="font-size: 13px;">Lead visualizado</div>
                        <div class="text-secondary" style="font-size: 11px;">Visualizado recentemente no painel</div>
                    </div>
                </div>
            </div>
        </div>
    @else
        <div class="card-body px-4 py-5 text-center text-secondary d-flex flex-column align-items-center justify-content-center" style="min-height: 400px;">
            <i class="bi bi-person-bounding-box fs-1 text-muted mb-3"></i>
            <h6 class="fw-bold text-dark">Nenhum lead selecionado</h6>
            <p class="small text-secondary mb-0">Clique no ícone de visualizar em qualquer lead da tabela para ver seus detalhes completos.</p>
        </div>
    @endif
</aside>

