<x-admin.layout title="Financeiro" page="Financeiro">
    <h1 class="visually-hidden">Financeiro</h1>

    <div class="row g-4">
        
        <!-- Top Stats -->
        <section class="col-12" aria-label="Indicadores financeiros">
            <div class="row g-3">
                <div class="col-12 col-sm-6 col-lg-3">
                    <div class="card border-0 shadow-sm rounded-4 h-100 p-4 bg-white d-flex flex-column justify-content-between">
                        <div class="d-flex justify-content-between align-items-start">
                            <span class="text-secondary fw-medium" style="font-size: 13px;">Receita Total</span>
                            <div class="bg-success bg-opacity-10 text-success rounded-circle d-flex align-items-center justify-content-center" style="width: 24px; height: 24px;">
                                <i class="bi bi-check-lg" style="font-size: 12px;"></i>
                            </div>
                        </div>
                        <div class="mt-3">
                            <h3 class="fs-4 fw-bold mb-1 text-dark">R$ 142.500</h3>
                            <div class="d-flex align-items-center gap-1">
                                <span class="text-success fw-medium d-flex align-items-center" style="font-size: 11px;"><i class="bi bi-arrow-up-short"></i> +8%</span>
                                <span class="text-secondary" style="font-size: 11px;">este mês</span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-12 col-sm-6 col-lg-3">
                    <div class="card border-0 shadow-sm rounded-4 h-100 p-4 bg-white d-flex flex-column justify-content-between">
                        <div class="d-flex justify-content-between align-items-start">
                            <span class="text-secondary fw-medium" style="font-size: 13px;">Despesas</span>
                            <div class="bg-danger bg-opacity-10 text-danger rounded-circle d-flex align-items-center justify-content-center" style="width: 24px; height: 24px;">
                                <i class="bi bi-person-down" style="font-size: 12px;"></i>
                            </div>
                        </div>
                        <div class="mt-3">
                            <h3 class="fs-4 fw-bold mb-1 text-dark">R$ 38.200</h3>
                            <div class="d-flex align-items-center gap-1">
                                <span class="text-danger fw-medium d-flex align-items-center" style="font-size: 11px;"><i class="bi bi-arrow-up-short"></i> +3%</span>
                                <span class="text-secondary" style="font-size: 11px;">este mês</span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-12 col-sm-6 col-lg-3">
                    <div class="card border-0 shadow-sm rounded-4 h-100 p-4 bg-white d-flex flex-column justify-content-between">
                        <div class="d-flex justify-content-between align-items-start">
                            <span class="text-secondary fw-medium" style="font-size: 13px;">Lucro Líquido</span>
                            <div class="bg-primary bg-opacity-10 text-primary rounded-circle d-flex align-items-center justify-content-center" style="width: 24px; height: 24px;">
                                <i class="bi bi-file-earmark-text" style="font-size: 12px;"></i>
                            </div>
                        </div>
                        <div class="mt-3">
                            <h3 class="fs-4 fw-bold mb-1 text-dark">R$ 104.300</h3>
                            <div class="d-flex align-items-center gap-1">
                                <span class="text-success fw-medium d-flex align-items-center" style="font-size: 11px;"><i class="bi bi-arrow-up-short"></i> +12%</span>
                                <span class="text-secondary" style="font-size: 11px;">este mês</span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-12 col-sm-6 col-lg-3">
                    <div class="card border-0 shadow-sm rounded-4 h-100 p-4 bg-white d-flex flex-column justify-content-between">
                        <div class="d-flex justify-content-between align-items-start">
                            <span class="text-secondary fw-medium" style="font-size: 13px;">Inadimplência</span>
                            <div class="bg-warning bg-opacity-10 text-warning rounded-circle d-flex align-items-center justify-content-center" style="width: 24px; height: 24px;">
                                <i class="bi bi-hourglass-split" style="font-size: 12px;"></i>
                            </div>
                        </div>
                        <div class="mt-3">
                            <h3 class="fs-4 fw-bold mb-1 text-dark">R$ 5.800</h3>
                            <div class="d-flex align-items-center gap-1">
                                <span class="text-secondary" style="font-size: 11px;">2 faturas em atraso</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Charts Section -->
        <section class="col-12" aria-label="Gráficos financeiros">
            <div class="row g-3">
                
                <!-- Bar Chart -->
                <div class="col-12 col-lg-8">
                    <div class="card border-0 shadow-sm rounded-4 h-100 bg-white p-4">
                        <div class="d-flex justify-content-between align-items-start mb-4">
                            <div>
                                <h3 class="h6 fw-bold mb-1 text-dark">Receita por Mês</h3>
                                <p class="text-secondary small mb-0" style="font-size: 11px;">Últimos 6 meses</p>
                            </div>
                            <div class="d-flex align-items-center gap-1">
                                <i class="bi bi-circle-fill text-primary" style="font-size: 6px;"></i>
                                <span class="text-secondary" style="font-size: 11px;">Receita</span>
                            </div>
                        </div>
                        
                        <!-- Simple CSS Bar Chart -->
                        <div class="d-flex align-items-end justify-content-around h-100 pt-4 pb-2 position-relative" style="min-height: 200px;">
                            <!-- Y-axis labels -->
                            <div class="position-absolute top-0 bottom-0 start-0 d-flex flex-column justify-content-between text-secondary" style="font-size: 9px; opacity: 0.5;">
                                <span>R$ 150.000</span>
                                <span>R$ 100.000</span>
                                <span>R$ 50.000</span>
                                <span>R$ 0</span>
                            </div>
                            
                            <!-- Grid lines -->
                            <div class="position-absolute top-0 start-0 end-0 border-top" style="opacity: 0.05;"></div>
                            <div class="position-absolute top-50 start-0 end-0 border-top" style="opacity: 0.05;"></div>
                            <div class="position-absolute bottom-0 start-0 end-0 border-top" style="opacity: 0.05;"></div>

                            <!-- Bars -->
                            <div class="d-flex flex-column align-items-center gap-2" style="width: 10%; z-index: 1;">
                                <div class="w-100 bg-primary bg-opacity-25 rounded-top" style="height: 60%;"></div>
                                <span class="text-secondary" style="font-size: 10px;">Jan</span>
                            </div>
                            <div class="d-flex flex-column align-items-center gap-2" style="width: 10%; z-index: 1;">
                                <div class="w-100 bg-primary bg-opacity-25 rounded-top" style="height: 70%;"></div>
                                <span class="text-secondary" style="font-size: 10px;">Fev</span>
                            </div>
                            <div class="d-flex flex-column align-items-center gap-2" style="width: 10%; z-index: 1;">
                                <div class="w-100 bg-primary bg-opacity-50 rounded-top" style="height: 85%;"></div>
                                <span class="text-secondary" style="font-size: 10px;">Mar</span>
                            </div>
                            <div class="d-flex flex-column align-items-center gap-2" style="width: 10%; z-index: 1;">
                                <div class="w-100 bg-primary bg-opacity-25 rounded-top" style="height: 68%;"></div>
                                <span class="text-secondary" style="font-size: 10px;">Abr</span>
                            </div>
                            <div class="d-flex flex-column align-items-center gap-2" style="width: 10%; z-index: 1;">
                                <div class="w-100 bg-primary bg-opacity-75 rounded-top" style="height: 90%;"></div>
                                <span class="text-secondary" style="font-size: 10px;">Mai</span>
                            </div>
                            <div class="d-flex flex-column align-items-center gap-2" style="width: 10%; z-index: 1;">
                                <div class="w-100 bg-primary rounded-top" style="height: 95%;"></div>
                                <span class="text-secondary fw-bold" style="font-size: 10px;">Jun</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Donut Chart -->
                <div class="col-12 col-lg-4">
                    <div class="card border-0 shadow-sm rounded-4 h-100 bg-white p-4">
                        <div>
                            <h3 class="h6 fw-bold mb-1 text-dark">Despesas por Categoria</h3>
                            <p class="text-secondary small mb-4" style="font-size: 11px;">Distribuição atual</p>
                        </div>
                        
                        <div class="d-flex flex-column align-items-center mb-4">
                            <!-- CSS Donut -->
                            <div class="position-relative d-flex align-items-center justify-content-center" style="width: 160px; height: 160px; border-radius: 50%; background: conic-gradient(#0d6efd 0% 40%, #20c997 40% 70%, #ffc107 70% 85%, #a259ff 85% 100%);">
                                <div class="bg-white rounded-circle d-flex align-items-center justify-content-center" style="width: 110px; height: 110px;">
                                    <span class="fw-bold" style="font-size: 13px;">R$ 38.200</span>
                                </div>
                            </div>
                        </div>

                        <!-- Legend -->
                        <div class="d-flex flex-column gap-2 mt-auto">
                            <div class="d-flex justify-content-between align-items-center">
                                <div class="d-flex align-items-center gap-2">
                                    <i class="bi bi-circle-fill text-primary" style="font-size: 8px;"></i>
                                    <span class="text-secondary" style="font-size: 12px;">Infraestrutura</span>
                                </div>
                                <span class="fw-bold" style="font-size: 12px;">R$ 14.200</span>
                            </div>
                            <div class="d-flex justify-content-between align-items-center">
                                <div class="d-flex align-items-center gap-2">
                                    <i class="bi bi-circle-fill" style="color: #20c997; font-size: 8px;"></i>
                                    <span class="text-secondary" style="font-size: 12px;">Pessoal</span>
                                </div>
                                <span class="fw-bold" style="font-size: 12px;">R$ 16.500</span>
                            </div>
                            <div class="d-flex justify-content-between align-items-center">
                                <div class="d-flex align-items-center gap-2">
                                    <i class="bi bi-circle-fill text-warning" style="font-size: 8px;"></i>
                                    <span class="text-secondary" style="font-size: 12px;">Marketing</span>
                                </div>
                                <span class="fw-bold" style="font-size: 12px;">R$ 4.800</span>
                            </div>
                            <div class="d-flex justify-content-between align-items-center">
                                <div class="d-flex align-items-center gap-2">
                                    <i class="bi bi-circle-fill" style="color: #a259ff; font-size: 8px;"></i>
                                    <span class="text-secondary" style="font-size: 12px;">Outros</span>
                                </div>
                                <span class="fw-bold" style="font-size: 12px;">R$ 2.700</span>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </section>

        <!-- Table -->
        <section class="col-12" aria-label="Tabela de Transações">
            <div class="card border-0 shadow-sm rounded-4 bg-white overflow-hidden">
                
                <div class="card-header bg-white border-bottom d-flex flex-wrap align-items-center justify-content-between px-4 py-3">
                    <div class="d-flex align-items-center gap-2">
                        <h2 class="section-title mb-0 fs-6 fw-bold">Transações Recentes</h2>
                        <span class="badge bg-primary-subtle text-primary rounded-pill px-2">42</span>
                    </div>
                    <button type="button" class="btn btn-primary btn-sm px-3 d-flex align-items-center gap-1">
                        <i class="bi bi-plus-lg"></i> Nova Transação
                    </button>
                </div>

                <div class="table-responsive">
                    <table class="table table-hover mb-0 align-middle">
                        <thead class="text-secondary" style="font-size: 11px;">
                            <tr>
                                <th scope="col" class="fw-medium border-bottom-0 pb-3 ps-4">#</th>
                                <th scope="col" class="fw-medium border-bottom-0 pb-3">Descrição</th>
                                <th scope="col" class="fw-medium border-bottom-0 pb-3">Cliente/Fornecedor</th>
                                <th scope="col" class="fw-medium border-bottom-0 pb-3">Tipo</th>
                                <th scope="col" class="fw-medium border-bottom-0 pb-3">Valor</th>
                                <th scope="col" class="fw-medium border-bottom-0 pb-3">Data</th>
                                <th scope="col" class="fw-medium border-bottom-0 pb-3">Status</th>
                                <th scope="col" class="text-end fw-medium border-bottom-0 pb-3 pe-4">Ações</th>
                            </tr>
                        </thead>
                        <tbody class="border-top">
                            <!-- Row 1 -->
                            <tr>
                                <td class="text-secondary small ps-4">01</td>
                                <td>
                                    <span class="d-block fw-bold text-dark" style="font-size: 13px">Desenvolvimento de Sistema Web</span>
                                    <span class="d-block text-secondary" style="font-size: 11px">Projeto #2024-001</span>
                                </td>
                                <td>
                                    <span class="d-block fw-medium text-dark" style="font-size: 12px">TechBR Soluções</span>
                                    <span class="d-block text-secondary" style="font-size: 11px">Cliente</span>
                                </td>
                                <td><span class="text-success fw-medium" style="font-size: 11px">Receita</span></td>
                                <td class="fw-bold text-dark" style="font-size: 13px">R$ 28.000</td>
                                <td class="text-secondary" style="font-size: 12px">15 Jun 2025</td>
                                <td><span class="badge bg-success bg-opacity-10 text-success fw-medium px-2 py-1" style="font-size: 10px; border-radius: 4px;">Pago</span></td>
                                <td class="pe-4">
                                    <div class="d-flex justify-content-end gap-1">
                                        <button class="btn btn-sm btn-primary text-white p-1 d-flex align-items-center justify-content-center rounded" style="width: 24px; height: 24px;"><i class="bi bi-eye" style="font-size: 12px;"></i></button>
                                        <button class="btn btn-sm btn-light text-secondary border p-1 d-flex align-items-center justify-content-center rounded" style="width: 24px; height: 24px;"><i class="bi bi-file-earmark-text" style="font-size: 12px;"></i></button>
                                    </div>
                                </td>
                            </tr>
                            
                            <!-- Row 2 -->
                            <tr>
                                <td class="text-secondary small ps-4">02</td>
                                <td>
                                    <span class="d-block fw-bold text-dark" style="font-size: 13px">Assinatura AWS - Infraestrutura</span>
                                    <span class="d-block text-secondary" style="font-size: 11px">Recorrência mensal</span>
                                </td>
                                <td>
                                    <span class="d-block fw-medium text-dark" style="font-size: 12px">Amazon Web Services</span>
                                    <span class="d-block text-secondary" style="font-size: 11px">Fornecedor</span>
                                </td>
                                <td><span class="text-danger fw-medium" style="font-size: 11px">Despesa</span></td>
                                <td class="fw-bold text-dark" style="font-size: 13px">R$ 4.800</td>
                                <td class="text-secondary" style="font-size: 12px">14 Jun 2025</td>
                                <td><span class="badge bg-success bg-opacity-10 text-success fw-medium px-2 py-1" style="font-size: 10px; border-radius: 4px;">Pago</span></td>
                                <td class="pe-4">
                                    <div class="d-flex justify-content-end gap-1">
                                        <button class="btn btn-sm btn-light text-secondary border p-1 d-flex align-items-center justify-content-center rounded" style="width: 24px; height: 24px;"><i class="bi bi-eye" style="font-size: 12px;"></i></button>
                                        <button class="btn btn-sm btn-light text-secondary border p-1 d-flex align-items-center justify-content-center rounded" style="width: 24px; height: 24px;"><i class="bi bi-file-earmark-text" style="font-size: 12px;"></i></button>
                                    </div>
                                </td>
                            </tr>

                            <!-- Row 3 -->
                            <tr>
                                <td class="text-secondary small ps-4">03</td>
                                <td>
                                    <span class="d-block fw-bold text-dark" style="font-size: 13px">Dashboard BI - FinTech Plus</span>
                                    <span class="d-block text-secondary" style="font-size: 11px">Projeto #2024-005</span>
                                </td>
                                <td>
                                    <span class="d-block fw-medium text-dark" style="font-size: 12px">Carlos Mendes</span>
                                    <span class="d-block text-secondary" style="font-size: 11px">Cliente</span>
                                </td>
                                <td><span class="text-success fw-medium" style="font-size: 11px">Receita</span></td>
                                <td class="fw-bold text-dark" style="font-size: 13px">R$ 18.500</td>
                                <td class="text-secondary" style="font-size: 12px">13 Jun 2025</td>
                                <td><span class="badge bg-warning bg-opacity-10 text-warning fw-medium px-2 py-1" style="font-size: 10px; border-radius: 4px;">Pendente</span></td>
                                <td class="pe-4">
                                    <div class="d-flex justify-content-end gap-1">
                                        <button class="btn btn-sm btn-light text-secondary border p-1 d-flex align-items-center justify-content-center rounded" style="width: 24px; height: 24px;"><i class="bi bi-eye" style="font-size: 12px;"></i></button>
                                        <button class="btn btn-sm btn-light text-secondary border p-1 d-flex align-items-center justify-content-center rounded" style="width: 24px; height: 24px;"><i class="bi bi-file-earmark-text" style="font-size: 12px;"></i></button>
                                    </div>
                                </td>
                            </tr>

                            <!-- Row 4 -->
                            <tr>
                                <td class="text-secondary small ps-4">04</td>
                                <td>
                                    <span class="d-block fw-bold text-dark" style="font-size: 13px">Folha de Pagamento - Junho</span>
                                    <span class="d-block text-secondary" style="font-size: 11px">Equipe interna</span>
                                </td>
                                <td>
                                    <span class="d-block fw-medium text-dark" style="font-size: 12px">Deploy Equipe</span>
                                    <span class="d-block text-secondary" style="font-size: 11px">Fornecedor</span>
                                </td>
                                <td><span class="text-danger fw-medium" style="font-size: 11px">Despesa</span></td>
                                <td class="fw-bold text-dark" style="font-size: 13px">R$ 16.500</td>
                                <td class="text-secondary" style="font-size: 12px">10 Jun 2025</td>
                                <td><span class="badge bg-success bg-opacity-10 text-success fw-medium px-2 py-1" style="font-size: 10px; border-radius: 4px;">Pago</span></td>
                                <td class="pe-4">
                                    <div class="d-flex justify-content-end gap-1">
                                        <button class="btn btn-sm btn-light text-secondary border p-1 d-flex align-items-center justify-content-center rounded" style="width: 24px; height: 24px;"><i class="bi bi-eye" style="font-size: 12px;"></i></button>
                                        <button class="btn btn-sm btn-light text-secondary border p-1 d-flex align-items-center justify-content-center rounded" style="width: 24px; height: 24px;"><i class="bi bi-file-earmark-text" style="font-size: 12px;"></i></button>
                                    </div>
                                </td>
                            </tr>

                            <!-- Row 5 -->
                            <tr>
                                <td class="text-secondary small ps-4">05</td>
                                <td>
                                    <span class="d-block fw-bold text-dark" style="font-size: 13px">Landing Page Varejo Digital</span>
                                    <span class="d-block text-secondary" style="font-size: 11px">Projeto #2024-008</span>
                                </td>
                                <td>
                                    <span class="d-block fw-medium text-dark" style="font-size: 12px">Ana Lima</span>
                                    <span class="d-block text-secondary" style="font-size: 11px">Cliente</span>
                                </td>
                                <td><span class="text-success fw-medium" style="font-size: 11px">Receita</span></td>
                                <td class="fw-bold text-dark" style="font-size: 13px">R$ 9.200</td>
                                <td class="text-secondary" style="font-size: 12px">08 Jun 2025</td>
                                <td><span class="badge bg-danger bg-opacity-10 text-danger fw-medium px-2 py-1" style="font-size: 10px; border-radius: 4px;">Atrasado</span></td>
                                <td class="pe-4">
                                    <div class="d-flex justify-content-end gap-1">
                                        <button class="btn btn-sm btn-light text-secondary border p-1 d-flex align-items-center justify-content-center rounded" style="width: 24px; height: 24px;"><i class="bi bi-eye" style="font-size: 12px;"></i></button>
                                        <button class="btn btn-sm btn-light text-secondary border p-1 d-flex align-items-center justify-content-center rounded" style="width: 24px; height: 24px;"><i class="bi bi-file-earmark-text" style="font-size: 12px;"></i></button>
                                    </div>
                                </td>
                            </tr>

                        </tbody>
                    </table>
                </div>

                <div class="card-footer bg-white border-top d-flex flex-wrap align-items-center justify-content-between px-4 py-3">
                    <small class="text-secondary" style="font-size: 12px">Mostrando 1–5 de 42 transações</small>
                    <nav aria-label="Paginação">
                        <ul class="pagination pagination-sm gap-1 mb-0">
                            <li class="page-item disabled"><a class="page-link border-0 rounded text-secondary" href="#"><i class="bi bi-chevron-left"></i></a></li>
                            <li class="page-item active"><a class="page-link border-0 rounded bg-primary text-white" href="#">1</a></li>
                            <li class="page-item"><a class="page-link border-0 rounded text-secondary" href="#">2</a></li>
                            <li class="page-item"><a class="page-link border-0 rounded text-secondary" href="#"><i class="bi bi-chevron-right"></i></a></li>
                        </ul>
                    </nav>
                </div>

            </div>
        </section>

    </div>
</x-admin.layout>
