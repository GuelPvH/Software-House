<x-admin.layout title="Leads & Orçamentos" page="Leads & Orçamentos">
    <h1 class="visually-hidden">Leads & Orçamentos</h1>

    <div class="row g-3">
        <!-- Main Content -->
        <div class="col-12 col-xl-9 d-flex flex-column gap-3">
            <!-- Stats -->
            <section class="row g-3" aria-label="Indicadores de leads">
                <div class="col-12 col-sm-6 col-md-3">
                    <x-admin.stat-card label="Total de Leads" value="28" icon="bi-person-fill" tone="blue"
                        note="+12% este mês" />
                </div>
                <div class="col-12 col-sm-6 col-md-3">
                    <x-admin.stat-card label="Em Análise" value="11" icon="bi-hourglass-split" tone="yellow"
                        note="aguardando retorno" />
                </div>
                <div class="col-12 col-sm-6 col-md-3">
                    <x-admin.stat-card label="Proposta Enviada" value="6" icon="bi-file-earmark-text-fill"
                        tone="purple" note="com proposta em aberto" />
                </div>
                <div class="col-12 col-sm-6 col-md-3">
                    <x-admin.stat-card label="Fechados" value="9" icon="bi-check-circle-fill" tone="green"
                        note="convertidos em projeto" />
                </div>
            </section>

            <!-- Filters -->
            <section class="card dashboard-card bg-white p-3 mb-0 border" aria-label="Filtros">
                <form action="{{ route('admin.leads.index') }}" method="GET" class="row g-2 align-items-center">
                    <div class="col-12 col-md-3">
                        <div class="input-group">
                            <span class="input-group-text bg-white border-end-0 text-secondary"><i
                                    class="bi bi-search"></i></span>
                            <input type="text" class="form-control border-start-0 ps-0" name="search"
                                value="{{ request('search') }}" placeholder="Buscar lead...">
                        </div>
                    </div>
                    <div class="col-12 col-md-2 d-flex align-items-center">
                        <label class="me-2 text-secondary small text-nowrap">Status:</label>
                        <select class="form-select border-0 shadow-sm text-secondary bg-light" style="font-size: 13px;"
                            name="status_leads">
                            <option value="">Todos</option>
                            @if (isset($statusLeads))
                                @foreach ($statusLeads as $status)
                                    <option value="{{ $status->id ?? $status->name }}"
                                        {{ request('status_leads') == ($status->id ?? $status->name) ? 'selected' : '' }}>
                                        {{ $status->name }}
                                    </option>
                                @endforeach
                            @endif
                        </select>
                    </div>
                    <div class="col-12 col-md-3 d-flex align-items-center">
                        <label class="me-2 text-secondary small text-nowrap">Tipo de Projeto:</label>
                        <select class="form-select border-0 shadow-sm text-secondary bg-light" style="font-size: 13px;"
                            name="fk_project_type">
                            <option value="">Todos</option>
                            @if (isset($projectsTypes))
                                @foreach ($projectsTypes as $pt)
                                    <option value="{{ $pt->id }}"
                                        {{ request('fk_project_type') == $pt->id ? 'selected' : '' }}>
                                        {{ $pt->name }}
                                    </option>
                                @endforeach
                            @endif
                        </select>
                    </div>
                    <div class="col-12 col-md-2 d-flex align-items-center">
                        <label class="me-2 text-secondary small text-nowrap">Período:</label>
                        <select class="form-select border-0 shadow-sm text-secondary bg-light" style="font-size: 13px;"
                            name="periodo">
                            <option value="">Todos</option>
                            <option value="today" {{ request('periodo') === 'today' ? 'selected' : '' }}>Hoje</option>
                            <option value="this_week" {{ request('periodo') === 'this_week' ? 'selected' : '' }}>Esta
                                semana</option>
                            <option value="this_month" {{ request('periodo') === 'this_month' ? 'selected' : '' }}>Este
                                mês</option>
                            <option value="this_year" {{ request('periodo') === 'this_year' ? 'selected' : '' }}>Este
                                ano</option>
                        </select>
                    </div>
                    <div class="col-12 col-md-2 d-flex gap-2 justify-content-md-end mt-3 mt-md-0">
                        @if (request()->hasAny(['search', 'status_leads', 'fk_project_type', 'periodo']))
                            <a href="{{ route('admin.leads.index') }}" class="btn btn-outline-secondary btn-sm"
                                title="Limpar filtros">
                                <i class="bi bi-x-lg"></i>
                            </a>
                        @endif
                        <button type="submit" class="btn btn-primary btn-sm d-flex align-items-center gap-1">
                            <i class="bi bi-funnel-fill"></i> Filtrar
                        </button>
                    </div>
                </form>
            </section>

            <!-- Table -->
            <section aria-label="Tabela de leads">
                @php
                    $isPaginated = isset($leads) && $leads instanceof \Illuminate\Pagination\LengthAwarePaginator;
                    $leadsCount = $isPaginated
                        ? $leads->total()
                        : (isset($leads) && is_countable($leads)
                            ? count($leads)
                            : 0);
                @endphp

                <article class="card dashboard-card leads-card overflow-hidden border-0 bg-white">
                    <div
                        class="card-header d-flex flex-wrap align-items-center justify-content-between bg-white px-4 py-3 border-bottom">
                        <div class="d-flex align-items-center gap-2">
                            <h2 class="section-title mb-0 fs-5 fw-bold">Todos os Leads</h2>
                            <span class="badge rounded-pill bg-primary-subtle text-primary">{{ $leadsCount }}</span>
                        </div>
                        <x-form.btnModal target="modal-new-lead" color="primary" size="sm"
                            class="d-flex align-items-center gap-1">
                            <i class="bi bi-plus-lg"></i> Novo Lead
                        </x-form.btnModal>
                    </div>

                    <div class="table-responsive">
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
                                @forelse ($leads ?? [] as $lead)
                                    @php
                                        $rawLeadId = is_array($lead) ? $lead['id'] : $lead->id;
                                        $leadId = str_pad((string) $rawLeadId, 2, '0', STR_PAD_LEFT);
                                        $leadName = is_array($lead) ? $lead['name'] : $lead->name;
                                        $leadCompany = is_array($lead) ? $lead['company'] : $lead->company;
                                        $leadEmail = is_array($lead)
                                            ? explode("\n", $lead['contact'] ?? '')[0] ?? ''
                                            : $lead->email;
                                        $leadPhone = is_array($lead)
                                            ? explode("\n", $lead['contact'] ?? '')[1] ?? ''
                                            : $lead->phone;
                                        $leadType = is_array($lead)
                                            ? $lead['type']
                                            : $lead->projectType?->name ?? 'Sistema Web';
                                        $leadTypeClass = is_array($lead) ? $lead['typeClass'] ?? '' : '';
                                        $leadPrazo = is_array($lead)
                                            ? $lead['prazo']
                                            : ($lead->deadline
                                                ? \Carbon\Carbon::parse($lead->deadline)->format('d/m/Y')
                                                : '-');
                                        $leadObjetivo = is_array($lead) ? $lead['objetivo'] : $lead->objective;
                                        $leadStatus = is_array($lead)
                                            ? $lead['status']
                                            : $lead->statusLead?->name ?? 'Novo';
                                        $leadStatusClass = is_array($lead)
                                            ? $lead['statusClass'] ?? 'badge-blue'
                                            : match ($leadStatus) {
                                                'Novo' => 'badge-blue',
                                                'Em Análise' => 'badge-yellow',
                                                'Proposta Enviada' => 'badge-purple',
                                                'Fechado' => 'badge-green',
                                                default => 'bg-danger-subtle text-danger',
                                            };
                                        $leadDate = is_array($lead)
                                            ? $lead['date']
                                            : ($lead->created_at
                                                ? $lead->created_at->format('d M Y')
                                                : '-');
                                        $leadActive =
                                            isset($selectedLead) &&
                                            (is_array($selectedLead)
                                                ? $selectedLead['id'] == $rawLeadId
                                                : $selectedLead->id == $rawLeadId);
                                    @endphp
                                    <tr class="lead-row {{ $leadActive ? 'is-selected' : '' }}"
                                        data-lead-id="{{ $rawLeadId }}"
                                        style="cursor: pointer;">
                                        <td class="text-secondary small">{{ $leadId }}</td>
                                        <td>
                                            <div class="d-flex align-items-center gap-2">
                                                <img src="https://ui-avatars.com/api/?name={{ urlencode($leadName) }}&background=f3f4f6&color=6c757d"
                                                    alt="" class="admin-avatar-sm rounded-circle border">
                                                <div class="lh-sm">
                                                    <span class="d-block fw-medium text-dark"
                                                        style="font-size: 13px">{{ $leadName }}</span>
                                                    <span class="d-block text-secondary"
                                                        style="font-size: 11px">{{ $leadCompany }}</span>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="lh-sm">
                                            <span class="d-block text-secondary"
                                                style="font-size: 12px">{{ $leadEmail }}</span>
                                            <span class="d-block text-secondary"
                                                style="font-size: 12px">{{ $leadPhone }}</span>
                                        </td>
                                        <td><span
                                                class="type-badge {{ $leadTypeClass ?: 'text-primary bg-primary-subtle' }} px-2 py-1 rounded-1 fw-medium"
                                                style="font-size: 11px">{{ $leadType }}</span></td>
                                        <td class="text-secondary small">{{ $leadPrazo }}</td>
                                        <td class="text-secondary small text-truncate" style="max-width: 150px;">
                                            {{ $leadObjetivo }}</td>
                                        <td><span
                                                class="soft-badge {{ $leadStatusClass }} rounded-pill px-2 py-1 fw-medium"
                                                style="font-size: 11px">{{ $leadStatus }}</span></td>
                                        <td class="text-secondary small text-nowrap">{{ $leadDate }}</td>
                                        <td>
                                            <div class="d-flex justify-content-end gap-1">
                                                <button type="button"
                                                    class="btn btn-sm btn-light text-primary {{ $leadActive ? 'bg-primary text-white' : '' }} border-0 btn-view-lead"
                                                    data-lead-id="{{ $rawLeadId }}" aria-label="Visualizar"
                                                    style="border-radius: 4px;">
                                                    <i class="bi bi-eye-fill"></i>
                                                </button>
                                                <button type="button"
                                                    class="btn btn-sm btn-light text-danger border-0 btn-delete-lead"
                                                    data-lead-id="{{ $rawLeadId }}"
                                                    data-lead-name="{{ $leadName }}"
                                                    data-bs-toggle="modal"
                                                    data-bs-target="#modal-delete-lead"
                                                    aria-label="Excluir" style="border-radius: 4px;"
                                                    title="Excluir Lead">
                                                    <i class="bi bi-trash"></i>
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="9" class="text-center py-5 text-secondary">
                                            <i class="bi bi-inbox fs-2 d-block mb-2 text-muted"></i>
                                            Nenhum lead encontrado com os filtros aplicados.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <div
                        class="card-footer d-flex flex-wrap align-items-center justify-content-between gap-3 bg-white px-4 py-3 border-top">
                        @if ($isPaginated && $leads->total() > 0)
                            <small class="text-secondary" style="font-size: 12px">
                                Mostrando {{ $leads->firstItem() }}–{{ $leads->lastItem() }} de {{ $leads->total() }}
                                leads
                            </small>
                            <div>
                                {{ $leads->links() }}
                            </div>
                        @else
                            <small class="text-secondary" style="font-size: 12px">
                                Total: {{ $leadsCount }} leads
                            </small>
                        @endif
                    </div>
                </article>
            </section>
        </div>

        <!-- Right Side Panel / Componente de Detalhes do Lead -->
        <div class="col-12 col-xl-3" id="lead-details-container">
            <x-admin.leads.details :lead="$selectedLead" />
        </div>
    </div>

    <!-- Modal Novo Lead -->
    <x-form.modal id="modal-new-lead" title="Novo Lead" size="lg" submit-label="Salvar Lead"
        form="formNovoLead">
        <form id="formNovoLead" action="{{ route('admin.leads.store') }}" method="POST">
            @csrf
            <div class="row g-3">
                <div class="col-12 col-md-6">
                    <label for="lead-name" class="form-label small fw-medium text-secondary">Nome Completo</label>
                    <input type="text" class="form-control" id="lead-name" name="name"
                        value="{{ old('name') }}" placeholder="Ex: João Silva" required>
                </div>
                <div class="col-12 col-md-6">
                    <label for="lead-company" class="form-label small fw-medium text-secondary">Empresa</label>
                    <input type="text" class="form-control" id="lead-company" name="company"
                        value="{{ old('company') }}" placeholder="Ex: TechBR" required>
                </div>
                <div class="col-12 col-md-6">
                    <label for="lead-email" class="form-label small fw-medium text-secondary">E-mail</label>
                    <input type="email" class="form-control" id="lead-email" name="email"
                        value="{{ old('email') }}" placeholder="joao@empresa.com" required>
                </div>
                <div class="col-12 col-md-6">
                    <label for="lead-phone" class="form-label small fw-medium text-secondary">Telefone /
                        WhatsApp</label>
                    <input type="text" class="form-control" id="lead-phone" name="phone"
                        value="{{ old('phone') }}" placeholder="(11) 99999-9999" required>
                </div>
                <div class="col-12 col-md-4">
                    <label for="lead-type" class="form-label small fw-medium text-secondary">Tipo de Projeto</label>
                    <select class="form-select" id="lead-type" name="fk_project_type" required>
                        <option value="" selected disabled>Selecione o tipo</option>
                        @foreach ($projectsTypes as $pt)
                            <option value="{{ $pt->id }}"
                                {{ old('fk_project_type') == $pt->id ? 'selected' : '' }}>{{ $pt->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-12 col-md-4">
                    <label for="lead-deadline" class="form-label small fw-medium text-secondary">Data Limite
                        (Deadline)</label>
                    <input type="date" class="form-control" id="lead-deadline" name="deadline"
                        value="{{ old('deadline') }}" required>
                </div>
                @if(auth()->user()->canModule('finance'))
                <div class="col-12 col-md-4">
                    <label for="lead-estimated-value" class="form-label small fw-medium text-secondary">Valor Estimado
                        (R$)</label>
                    <input type="number" step="0.01" min="0" class="form-control"
                        id="lead-estimated-value" name="estimated_value" value="{{ old('estimated_value') }}"
                        placeholder="0.00" required>
                </div>
                @endif
                <div class="col-12">
                    <label for="lead-objective" class="form-label small fw-medium text-secondary">Objetivo /
                        Descrição</label>
                    <textarea class="form-control" id="lead-objective" name="objective" rows="3"
                        placeholder="Descreva resumidamente o objetivo do projeto..." required>{{ old('objective') }}</textarea>
                </div>
            </div>
        </form>
    </x-form.modal>
    <x-form.modal id="modal-delete-lead" title="Excluir Lead" size="md" color="danger" submit-label="Excluir Lead"
        form="formDeleteLead">
        <form id="formDeleteLead" action="{{ route('admin.leads.destroy') }}" method="POST">
            @csrf
            @method('DELETE')
            <div class="row g-3">
                <div class="col-12">
                    <p class="text-secondary mb-2 text-center">Tem certeza que deseja excluir este lead?</p>
                    <p class="text-danger small mb-0 text-center"><i class="bi bi-exclamation-triangle-fill me-1"></i> Esta ação não pode ser desfeita.</p>
                    <input type="hidden" name="id" id="delete-lead-id" value="">
                </div>
            </div>
        </form>
    </x-form.modal>

    <!-- Extra styles to match design if not present -->
    @push('styles')
        <style>
            .badge-blue {
                background-color: #e0f2fe;
                color: #0284c7;
            }

            .badge-yellow {
                background-color: #fef08a;
                color: #a16207;
            }

            .badge-purple {
                background-color: #f3e8ff;
                color: #7e22ce;
            }

            .badge-green {
                background-color: #dcfce7;
                color: #15803d;
            }

            .type-purple {
                background-color: #f3e8ff;
                color: #7e22ce;
            }

            .type-pink {
                background-color: #fce7f3;
                color: #be185d;
            }

            .lead-row {
                cursor: pointer;
                transition: background-color 0.15s ease-in-out;
            }

            .lead-row:hover > td {
                background-color: #f8fafc !important;
            }

            .lead-row.is-selected > td {
                background-color: #e0f2fe !important;
            }

            .lead-row.is-selected > td:first-child {
                border-left: 4px solid #0d6efd !important;
                font-weight: 600;
            }
        </style>
    @endpush

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const container = document.getElementById('lead-details-container');
            if (!container) return;

            // Fechar / limpar painel de detalhes ao clicar no botão fechar
            container.addEventListener('click', function(e) {
                if (e.target.closest('.btn-close-lead-details')) {
                    container.innerHTML = `
                        <aside class="card border-0 bg-white shadow-sm h-100 rounded-3">
                            <div class="card-header bg-white border-bottom d-flex justify-content-between align-items-center py-3 px-4">
                                <h5 class="mb-0 fs-6 fw-bold text-dark d-flex align-items-center gap-2">
                                    <i class="bi bi-circle-fill text-secondary" style="font-size: 6px;"></i> Detalhes do Lead
                                </h5>
                            </div>
                            <div class="card-body px-4 py-5 text-center text-secondary d-flex flex-column align-items-center justify-content-center" style="min-height: 400px;">
                                <i class="bi bi-person-bounding-box fs-1 text-muted mb-3"></i>
                                <h6 class="fw-bold text-dark">Nenhum lead selecionado</h6>
                                <p class="small text-secondary mb-0">Clique no ícone de visualizar em qualquer lead da tabela para ver seus detalhes completos.</p>
                            </div>
                        </aside>
                    `;

                    document.querySelectorAll('.lead-row').forEach(row => {
                        row.classList.remove('is-selected');
                        const btn = row.querySelector('.btn-view-lead');
                        if (btn) {
                            btn.classList.remove('bg-primary', 'text-white');
                        }
                    });
                }
            });

            function loadLeadDetails(leadId) {
                if (!leadId) return;

                // Atualizar destaque das linhas na tabela
                document.querySelectorAll('.lead-row').forEach(row => {
                    const isTarget = String(row.dataset.leadId) === String(leadId);
                    row.classList.toggle('is-selected', isTarget);
                    const btn = row.querySelector('.btn-view-lead');
                    if (btn) {
                        btn.classList.toggle('bg-primary', isTarget);
                        btn.classList.toggle('text-white', isTarget);
                    }
                });

                // Feedback visual de carregamento suave
                container.style.opacity = '0.5';
                container.style.pointerEvents = 'none';

                fetch(`{{ route('admin.leads.index') }}?lead_id=${leadId}`, {
                        headers: {
                            'X-Requested-With': 'XMLHttpRequest',
                            'Accept': 'text/html'
                        }
                    })
                    .then(response => {
                        if (!response.ok) throw new Error('Erro ao carregar os dados do lead');
                        return response.text();
                    })
                    .then(html => {
                        container.innerHTML = html;
                    })
                    .catch(err => {
                        console.error('Falha ao carregar detalhes:', err);
                    })
                    .finally(() => {
                        container.style.opacity = '1';
                        container.style.pointerEvents = 'auto';
                    });
            }

            // Clique na linha inteira para selecionar o lead (ou no botão do olho)
            document.querySelectorAll('.lead-row').forEach(row => {
                row.addEventListener('click', function(e) {
                    // Se o clique foi no botão de excluir (ou botão diferente do olho), não seleciona
                    if (e.target.closest('.btn-delete-lead') || (e.target.closest('button') && !e.target.closest('.btn-view-lead'))) {
                        return;
                    }

                    const leadId = this.dataset.leadId;
                    if (leadId) {
                        loadLeadDetails(leadId);
                    }
                });
            });

            // Configurar dados na modal de exclusão
            const modalDelete = document.getElementById('modal-delete-lead');
            if (modalDelete) {
                modalDelete.addEventListener('show.bs.modal', function(event) {
                    const button = event.relatedTarget;
                    if (button && button.dataset.leadId) {
                        const idInput = document.getElementById('delete-lead-id');
                        const nameEl = document.getElementById('delete-lead-name');
                        if (idInput) idInput.value = button.dataset.leadId;
                        if (nameEl) nameEl.textContent = button.dataset.leadName ? `"${button.dataset.leadName}"` : '';
                    }
                });
            }

            // Fallback de clique direto no botão de excluir
            document.querySelectorAll('.btn-delete-lead').forEach(btn => {
                btn.addEventListener('click', function(e) {
                    e.stopPropagation();
                    const leadId = this.dataset.leadId;
                    const leadName = this.dataset.leadName || '';
                    const idInput = document.getElementById('delete-lead-id');
                    const nameEl = document.getElementById('delete-lead-name');
                    if (idInput) idInput.value = leadId;
                    if (nameEl) nameEl.textContent = leadName ? `"${leadName}"` : '';
                });
            });
        });
    </script>
</x-admin.layout>
