<x-admin.layout title="Serviços & Conteúdo" page="Serviços & Conteúdo">
    <h1 class="visually-hidden">Serviços & Conteúdo</h1>

    <div class="row g-3 h-100">
        <!-- Main Content -->
        <div class="col-12 col-xl-9 d-flex flex-column gap-3">
            
            <!-- Tabs Navigation -->
            <ul class="nav nav-tabs border-bottom mb-2 gap-3" style="font-size: 14px;">
                <li class="nav-item">
                    <a class="nav-link active fw-bold text-primary border-bottom border-2 border-primary bg-transparent px-0 pb-3" href="#">Serviços</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-secondary bg-transparent px-0 pb-3 border-0" href="#">Portfólio / Projetos</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-secondary bg-transparent px-0 pb-3 border-0" href="#">Textos do Site</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-secondary bg-transparent px-0 pb-3 border-0" href="#">FAQ</a>
                </li>
            </ul>

            <!-- Header -->
            <div class="d-flex justify-content-between align-items-center mb-2 mt-2">
                <div>
                    <h2 class="h5 fw-bold mb-1">Serviços</h2>
                    <p class="text-secondary small mb-0">Gerencie os serviços exibidos no site público da Deploy.</p>
                </div>
                <button type="button" class="btn btn-primary d-flex align-items-center gap-2 fw-medium px-3" style="font-size: 13px;">
                    <i class="bi bi-plus-lg"></i> Novo Serviço
                </button>
            </div>

            <!-- Grid -->
            <div class="row g-3 flex-grow-1 align-content-start pb-4">
                
                <!-- Card 1 (Active) -->
                <div class="col-12 col-md-6 col-lg-4">
                    <div class="card border-primary shadow-sm rounded-4 h-100 p-3" style="border-width: 2px;">
                        <div class="d-flex justify-content-between align-items-start mb-2">
                            <div class="d-flex align-items-center gap-2">
                                <div class="bg-primary text-white rounded d-flex align-items-center justify-content-center" style="width: 32px; height: 32px;">
                                    <i class="bi bi-code-slash"></i>
                                </div>
                                <h3 class="h6 fw-bold mb-0 text-dark" style="font-size: 13px;">Desenvolvimento de Sites</h3>
                            </div>
                            <button class="btn btn-link text-secondary p-0" aria-label="Editar"><i class="bi bi-pencil-fill" style="font-size: 12px;"></i></button>
                        </div>
                        <div class="d-flex align-items-center gap-2 mb-2">
                            <div class="form-check form-switch m-0 p-0 d-flex align-items-center gap-2 ms-0 ps-0">
                                <input class="form-check-input m-0" type="checkbox" role="switch" checked style="width: 36px; height: 20px; border:none;">
                                <label class="form-check-label text-success fw-medium d-flex align-items-center gap-1" style="font-size: 11px;">
                                    <i class="bi bi-circle-fill" style="font-size: 5px;"></i> Publicado
                                </label>
                            </div>
                        </div>
                        <p class="text-secondary lh-sm mb-3 flex-grow-1" style="font-size: 11px;">
                            Criamos sites institucionais com SEO técnico, performance extrema e experiência que converte visitantes em clientes.
                        </p>
                        <div class="d-flex gap-1 flex-wrap mb-3">
                            <span class="badge text-primary bg-primary-subtle fw-medium" style="font-size: 10px;">Web Design</span>
                            <span class="badge text-primary bg-primary-subtle fw-medium" style="font-size: 10px;">SEO</span>
                            <span class="badge text-primary bg-primary-subtle fw-medium" style="font-size: 10px;">CMS</span>
                        </div>
                        <div class="d-flex justify-content-between align-items-center mt-auto">
                            <button class="btn btn-outline-primary btn-sm px-3 fw-medium" style="font-size: 11px; border-radius: 6px;">Editar</button>
                            <button class="btn btn-link text-danger text-decoration-none p-0 fw-medium" style="font-size: 11px;">Despublicar</button>
                        </div>
                    </div>
                </div>

                <!-- Card 2 -->
                <div class="col-12 col-md-6 col-lg-4">
                    <div class="card border border-light-subtle shadow-sm rounded-4 h-100 p-3">
                        <div class="d-flex justify-content-between align-items-start mb-2">
                            <div class="d-flex align-items-center gap-2">
                                <div class="bg-primary-subtle text-primary rounded d-flex align-items-center justify-content-center" style="width: 32px; height: 32px;">
                                    <i class="bi bi-grid-1x2"></i>
                                </div>
                                <h3 class="h6 fw-bold mb-0 text-dark" style="font-size: 13px;">Sistemas Web de Gestão</h3>
                            </div>
                            <button class="btn btn-link text-secondary p-0" aria-label="Editar"><i class="bi bi-pencil-fill" style="font-size: 12px;"></i></button>
                        </div>
                        <div class="d-flex align-items-center gap-2 mb-2">
                            <div class="form-check form-switch m-0 p-0 d-flex align-items-center gap-2 ms-0 ps-0">
                                <input class="form-check-input m-0" type="checkbox" role="switch" checked style="width: 36px; height: 20px; border:none;">
                                <label class="form-check-label text-success fw-medium d-flex align-items-center gap-1" style="font-size: 11px;">
                                    <i class="bi bi-circle-fill" style="font-size: 5px;"></i> Publicado
                                </label>
                            </div>
                        </div>
                        <p class="text-secondary lh-sm mb-3 flex-grow-1" style="font-size: 11px;">
                            Digitalize processos complexos com sistemas web escaláveis, seguros e integrados ao seu fluxo de trabalho.
                        </p>
                        <div class="d-flex gap-1 flex-wrap mb-3">
                            <span class="badge text-primary bg-primary-subtle fw-medium" style="font-size: 10px;">React</span>
                            <span class="badge text-primary bg-primary-subtle fw-medium" style="font-size: 10px;">Node.js</span>
                            <span class="badge text-primary bg-primary-subtle fw-medium" style="font-size: 10px;">Cloud</span>
                        </div>
                        <div class="d-flex justify-content-between align-items-center mt-auto">
                            <button class="btn btn-outline-primary btn-sm px-3 fw-medium" style="font-size: 11px; border-radius: 6px;">Editar</button>
                            <button class="btn btn-link text-danger text-decoration-none p-0 fw-medium" style="font-size: 11px;">Despublicar</button>
                        </div>
                    </div>
                </div>

                <!-- Card 3 -->
                <div class="col-12 col-md-6 col-lg-4">
                    <div class="card border border-light-subtle shadow-sm rounded-4 h-100 p-3">
                        <div class="d-flex justify-content-between align-items-start mb-2">
                            <div class="d-flex align-items-center gap-2">
                                <div class="bg-primary-subtle text-primary rounded d-flex align-items-center justify-content-center" style="width: 32px; height: 32px;">
                                    <i class="bi bi-layers"></i>
                                </div>
                                <h3 class="h6 fw-bold mb-0 text-dark" style="font-size: 13px;">Software Sob Medida</h3>
                            </div>
                            <button class="btn btn-link text-secondary p-0" aria-label="Editar"><i class="bi bi-pencil-fill" style="font-size: 12px;"></i></button>
                        </div>
                        <div class="d-flex align-items-center gap-2 mb-2">
                            <div class="form-check form-switch m-0 p-0 d-flex align-items-center gap-2 ms-0 ps-0">
                                <input class="form-check-input m-0" type="checkbox" role="switch" checked style="width: 36px; height: 20px; border:none;">
                                <label class="form-check-label text-success fw-medium d-flex align-items-center gap-1" style="font-size: 11px;">
                                    <i class="bi bi-circle-fill" style="font-size: 5px;"></i> Publicado
                                </label>
                            </div>
                        </div>
                        <p class="text-secondary lh-sm mb-3 flex-grow-1" style="font-size: 11px;">
                            Quando os produtos prontos não resolvem, nós criamos do zero. Soluções exclusivas para o seu negócio.
                        </p>
                        <div class="d-flex gap-1 flex-wrap mb-3">
                            <span class="badge text-primary bg-primary-subtle fw-medium" style="font-size: 10px;">Custom</span>
                            <span class="badge text-primary bg-primary-subtle fw-medium" style="font-size: 10px;">API</span>
                            <span class="badge text-primary bg-primary-subtle fw-medium" style="font-size: 10px;">Segurança</span>
                        </div>
                        <div class="d-flex justify-content-between align-items-center mt-auto">
                            <button class="btn btn-outline-primary btn-sm px-3 fw-medium" style="font-size: 11px; border-radius: 6px;">Editar</button>
                            <button class="btn btn-link text-danger text-decoration-none p-0 fw-medium" style="font-size: 11px;">Despublicar</button>
                        </div>
                    </div>
                </div>

                <!-- Card 4 -->
                <div class="col-12 col-md-6 col-lg-4">
                    <div class="card border border-light-subtle shadow-sm rounded-4 h-100 p-3">
                        <div class="d-flex justify-content-between align-items-start mb-2">
                            <div class="d-flex align-items-center gap-2">
                                <div class="bg-primary-subtle text-primary rounded d-flex align-items-center justify-content-center" style="width: 32px; height: 32px;">
                                    <i class="bi bi-lightning-charge"></i>
                                </div>
                                <h3 class="h6 fw-bold mb-0 text-dark" style="font-size: 13px;">Landing Pages de Alta Conversão</h3>
                            </div>
                            <button class="btn btn-link text-secondary p-0" aria-label="Editar"><i class="bi bi-pencil-fill" style="font-size: 12px;"></i></button>
                        </div>
                        <div class="d-flex align-items-center gap-2 mb-2">
                            <div class="form-check form-switch m-0 p-0 d-flex align-items-center gap-2 ms-0 ps-0">
                                <input class="form-check-input m-0" type="checkbox" role="switch" checked style="width: 36px; height: 20px; border:none;">
                                <label class="form-check-label text-success fw-medium d-flex align-items-center gap-1" style="font-size: 11px;">
                                    <i class="bi bi-circle-fill" style="font-size: 5px;"></i> Publicado
                                </label>
                            </div>
                        </div>
                        <p class="text-secondary lh-sm mb-3 flex-grow-1" style="font-size: 11px;">
                            Transforme cliques em clientes com páginas focadas em produto, persuasão e conversão otimizada.
                        </p>
                        <div class="d-flex gap-1 flex-wrap mb-3">
                            <span class="badge text-primary bg-primary-subtle fw-medium" style="font-size: 10px;">Conversão</span>
                            <span class="badge text-primary bg-primary-subtle fw-medium" style="font-size: 10px;">Design</span>
                            <span class="badge text-primary bg-primary-subtle fw-medium" style="font-size: 10px;">UX</span>
                        </div>
                        <div class="d-flex justify-content-between align-items-center mt-auto">
                            <button class="btn btn-outline-primary btn-sm px-3 fw-medium" style="font-size: 11px; border-radius: 6px;">Editar</button>
                            <button class="btn btn-link text-danger text-decoration-none p-0 fw-medium" style="font-size: 11px;">Despublicar</button>
                        </div>
                    </div>
                </div>

                <!-- Card 5 -->
                <div class="col-12 col-md-6 col-lg-4">
                    <div class="card border border-light-subtle shadow-sm rounded-4 h-100 p-3">
                        <div class="d-flex justify-content-between align-items-start mb-2">
                            <div class="d-flex align-items-center gap-2">
                                <div class="bg-primary-subtle text-primary rounded d-flex align-items-center justify-content-center" style="width: 32px; height: 32px;">
                                    <i class="bi bi-bar-chart"></i>
                                </div>
                                <h3 class="h6 fw-bold mb-0 text-dark" style="font-size: 13px;">Dashboards & BI</h3>
                            </div>
                            <button class="btn btn-link text-secondary p-0" aria-label="Editar"><i class="bi bi-pencil-fill" style="font-size: 12px;"></i></button>
                        </div>
                        <div class="d-flex align-items-center gap-2 mb-2">
                            <div class="form-check form-switch m-0 p-0 d-flex align-items-center gap-2 ms-0 ps-0">
                                <input class="form-check-input m-0" type="checkbox" role="switch" checked style="width: 36px; height: 20px; border:none;">
                                <label class="form-check-label text-success fw-medium d-flex align-items-center gap-1" style="font-size: 11px;">
                                    <i class="bi bi-circle-fill" style="font-size: 5px;"></i> Publicado
                                </label>
                            </div>
                        </div>
                        <p class="text-secondary lh-sm mb-3 flex-grow-1" style="font-size: 11px;">
                            Tome decisões baseadas em dados com painéis interativos, relatórios em tempo real e visualizações inteligentes.
                        </p>
                        <div class="d-flex gap-1 flex-wrap mb-3">
                            <span class="badge text-primary bg-primary-subtle fw-medium" style="font-size: 10px;">BI</span>
                            <span class="badge text-primary bg-primary-subtle fw-medium" style="font-size: 10px;">Data</span>
                            <span class="badge text-primary bg-primary-subtle fw-medium" style="font-size: 10px;">Analytics</span>
                        </div>
                        <div class="d-flex justify-content-between align-items-center mt-auto">
                            <button class="btn btn-outline-primary btn-sm px-3 fw-medium" style="font-size: 11px; border-radius: 6px;">Editar</button>
                            <button class="btn btn-link text-danger text-decoration-none p-0 fw-medium" style="font-size: 11px;">Despublicar</button>
                        </div>
                    </div>
                </div>

                <!-- Card 6 -->
                <div class="col-12 col-md-6 col-lg-4">
                    <div class="card border border-light-subtle shadow-sm rounded-4 h-100 p-3">
                        <div class="d-flex justify-content-between align-items-start mb-2">
                            <div class="d-flex align-items-center gap-2">
                                <div class="bg-primary-subtle text-primary rounded d-flex align-items-center justify-content-center" style="width: 32px; height: 32px;">
                                    <i class="bi bi-plug"></i>
                                </div>
                                <h3 class="h6 fw-bold mb-0 text-dark" style="font-size: 13px;">APIs & Integrações</h3>
                            </div>
                            <button class="btn btn-link text-secondary p-0" aria-label="Editar"><i class="bi bi-pencil-fill" style="font-size: 12px;"></i></button>
                        </div>
                        <div class="d-flex align-items-center gap-2 mb-2">
                            <div class="form-check form-switch m-0 p-0 d-flex align-items-center gap-2 ms-0 ps-0">
                                <input class="form-check-input m-0" type="checkbox" role="switch" checked style="width: 36px; height: 20px; border:none;">
                                <label class="form-check-label text-success fw-medium d-flex align-items-center gap-1" style="font-size: 11px;">
                                    <i class="bi bi-circle-fill" style="font-size: 5px;"></i> Publicado
                                </label>
                            </div>
                        </div>
                        <p class="text-secondary lh-sm mb-3 flex-grow-1" style="font-size: 11px;">
                            Conectamos seus sistemas ao mundo. REST, GraphQL, webhooks e muito mais para fluxos automatizados.
                        </p>
                        <div class="d-flex gap-1 flex-wrap mb-3">
                            <span class="badge text-primary bg-primary-subtle fw-medium" style="font-size: 10px;">REST</span>
                            <span class="badge text-primary bg-primary-subtle fw-medium" style="font-size: 10px;">GraphQL</span>
                            <span class="badge text-primary bg-primary-subtle fw-medium" style="font-size: 10px;">Integrações</span>
                        </div>
                        <div class="d-flex justify-content-between align-items-center mt-auto">
                            <button class="btn btn-outline-primary btn-sm px-3 fw-medium" style="font-size: 11px; border-radius: 6px;">Editar</button>
                            <button class="btn btn-link text-danger text-decoration-none p-0 fw-medium" style="font-size: 11px;">Despublicar</button>
                        </div>
                    </div>
                </div>
                
                <!-- Card 7 (Despublicado/Opaco) -->
                <div class="col-12 col-md-6 col-lg-4" style="opacity: 0.6;">
                    <div class="card border border-light-subtle shadow-sm rounded-4 h-100 p-3 bg-light">
                        <div class="d-flex justify-content-between align-items-start mb-2">
                            <div class="d-flex align-items-center gap-2">
                                <div class="bg-secondary bg-opacity-10 text-secondary rounded d-flex align-items-center justify-content-center" style="width: 32px; height: 32px;">
                                    <i class="bi bi-wrench"></i>
                                </div>
                                <h3 class="h6 fw-bold mb-0 text-secondary" style="font-size: 13px;">Manutenção & Evolução</h3>
                            </div>
                            <button class="btn btn-link text-secondary p-0" aria-label="Editar"><i class="bi bi-pencil-fill" style="font-size: 12px;"></i></button>
                        </div>
                        <div class="d-flex align-items-center gap-2 mb-2">
                            <div class="form-check form-switch m-0 p-0 d-flex align-items-center gap-2 ms-0 ps-0">
                                <input class="form-check-input m-0 bg-secondary" type="checkbox" role="switch" style="width: 36px; height: 20px; border:none; opacity: 0.5;">
                                <label class="form-check-label text-secondary fw-medium d-flex align-items-center gap-1" style="font-size: 11px;">
                                    <i class="bi bi-circle-fill text-secondary" style="font-size: 5px;"></i> Não publicado
                                </label>
                            </div>
                        </div>
                        <p class="text-secondary lh-sm mb-3 flex-grow-1" style="font-size: 11px;">
                            Seu software nunca para. Correções de bugs, atualizações de segurança e evolução contínua do sistema.
                        </p>
                        <div class="d-flex gap-1 flex-wrap mb-3">
                            <span class="badge text-secondary bg-secondary bg-opacity-10 fw-medium" style="font-size: 10px;">Suporte</span>
                            <span class="badge text-secondary bg-secondary bg-opacity-10 fw-medium" style="font-size: 10px;">Updates</span>
                        </div>
                        <div class="d-flex justify-content-between align-items-center mt-auto">
                            <button class="btn btn-outline-secondary btn-sm px-3 fw-medium" style="font-size: 11px; border-radius: 6px;">Editar</button>
                            <button class="btn btn-link text-success text-decoration-none p-0 fw-medium" style="font-size: 11px;">Publicar</button>
                        </div>
                    </div>
                </div>

                <!-- Add New -->
                <div class="col-12 col-md-6 col-lg-4">
                    <button class="card border-primary border-2 border-dashed shadow-none rounded-4 h-100 p-4 w-100 d-flex flex-column align-items-center justify-content-center bg-transparent gap-2" style="border-style: dashed; opacity: 0.7; transition: all 0.2s;">
                        <div class="bg-primary-subtle text-primary rounded-circle d-flex align-items-center justify-content-center mb-2" style="width: 48px; height: 48px;">
                            <i class="bi bi-plus" style="font-size: 24px;"></i>
                        </div>
                        <span class="fw-bold text-primary" style="font-size: 14px;">Adicionar Serviço</span>
                        <span class="text-secondary" style="font-size: 11px;">Clique para criar um novo serviço no site</span>
                    </button>
                </div>

            </div>
        </div>

        <!-- Right Side Panel / Offcanvas content shown as col -->
        <div class="col-12 col-xl-3 h-100">
            <aside class="card border border-light-subtle bg-white shadow-sm h-100 rounded-3 d-flex flex-column">
                <div class="card-header bg-white border-bottom d-flex justify-content-between align-items-center py-3 px-4">
                    <h5 class="mb-0 fs-6 fw-bold text-dark d-flex align-items-center gap-2" style="font-size: 14px !important;">
                        <i class="bi bi-pencil-square text-primary"></i> Editar Serviço
                    </h5>
                    <button class="btn-close" style="font-size: 10px;"></button>
                </div>
                
                <div class="card-body px-4 py-4 d-flex flex-column gap-4 overflow-auto">
                    
                    <!-- Title -->
                    <div>
                        <label class="text-uppercase fw-bold text-secondary mb-2" style="font-size: 10px; letter-spacing: 0.5px;">TÍTULO DO SERVIÇO</label>
                        <input type="text" class="form-control text-dark fw-medium" value="Desenvolvimento de Sites" style="font-size: 13px;">
                    </div>

                    <!-- Icon -->
                    <div>
                        <label class="text-uppercase fw-bold text-secondary mb-2" style="font-size: 10px; letter-spacing: 0.5px;">ÍCONE</label>
                        <div class="d-flex gap-2 flex-wrap">
                            <button class="btn btn-primary d-flex align-items-center justify-content-center p-0" style="width: 32px; height: 32px;"><i class="bi bi-code-slash"></i></button>
                            <button class="btn btn-light border d-flex align-items-center justify-content-center p-0 text-secondary" style="width: 32px; height: 32px;"><i class="bi bi-grid-1x2"></i></button>
                            <button class="btn btn-light border d-flex align-items-center justify-content-center p-0 text-secondary" style="width: 32px; height: 32px;"><i class="bi bi-list-task"></i></button>
                            <button class="btn btn-light border d-flex align-items-center justify-content-center p-0 text-secondary" style="width: 32px; height: 32px;"><i class="bi bi-lightning-charge"></i></button>
                            <button class="btn btn-light border d-flex align-items-center justify-content-center p-0 text-secondary" style="width: 32px; height: 32px;"><i class="bi bi-bar-chart"></i></button>
                            <button class="btn btn-light border d-flex align-items-center justify-content-center p-0 text-secondary" style="width: 32px; height: 32px;"><i class="bi bi-plug"></i></button>
                            <button class="btn btn-light border d-flex align-items-center justify-content-center p-0 text-secondary" style="width: 32px; height: 32px;"><i class="bi bi-wrench"></i></button>
                        </div>
                    </div>

                    <!-- Status -->
                    <div>
                        <label class="text-uppercase fw-bold text-secondary mb-2" style="font-size: 10px; letter-spacing: 0.5px;">STATUS</label>
                        <div class="d-flex align-items-center justify-content-between p-3 border rounded">
                            <span class="text-success fw-medium d-flex align-items-center gap-1" style="font-size: 12px;">
                                <i class="bi bi-circle-fill" style="font-size: 6px;"></i> Publicado
                            </span>
                            <div class="form-check form-switch m-0 p-0 d-flex align-items-center ms-0 ps-0">
                                <input class="form-check-input m-0" type="checkbox" role="switch" checked style="width: 40px; height: 22px; border:none;">
                            </div>
                        </div>
                    </div>

                    <!-- Short description -->
                    <div>
                        <label class="text-uppercase fw-bold text-secondary mb-2" style="font-size: 10px; letter-spacing: 0.5px;">DESCRIÇÃO CURTA</label>
                        <textarea class="form-control text-secondary lh-sm" rows="3" style="font-size: 12px;">Criamos sites institucionais com SEO técnico, performance extrema e experiência que converte visitantes em clientes.</textarea>
                    </div>

                    <!-- Features -->
                    <div>
                        <label class="text-uppercase fw-bold text-secondary mb-2" style="font-size: 10px; letter-spacing: 0.5px;">FUNCIONALIDADES</label>
                        <div class="d-flex flex-column gap-2 mb-2">
                            <div class="d-flex align-items-center justify-content-between bg-primary-subtle bg-opacity-50 p-2 rounded">
                                <div class="d-flex align-items-center gap-2">
                                    <div class="bg-primary text-white rounded d-flex align-items-center justify-content-center" style="width: 16px; height: 16px;"><i class="bi bi-check" style="font-size: 12px;"></i></div>
                                    <span class="fw-medium text-dark" style="font-size: 12px;">SEO Avançado</span>
                                </div>
                                <i class="bi bi-question-circle text-secondary" style="opacity: 0.5;"></i>
                            </div>
                            <div class="d-flex align-items-center justify-content-between bg-primary-subtle bg-opacity-50 p-2 rounded">
                                <div class="d-flex align-items-center gap-2">
                                    <div class="bg-primary text-white rounded d-flex align-items-center justify-content-center" style="width: 16px; height: 16px;"><i class="bi bi-check" style="font-size: 12px;"></i></div>
                                    <span class="fw-medium text-dark" style="font-size: 12px;">Carregamento ultra-rápido</span>
                                </div>
                                <i class="bi bi-question-circle text-secondary" style="opacity: 0.5;"></i>
                            </div>
                            <div class="d-flex align-items-center justify-content-between bg-primary-subtle bg-opacity-50 p-2 rounded">
                                <div class="d-flex align-items-center gap-2">
                                    <div class="bg-primary text-white rounded d-flex align-items-center justify-content-center" style="width: 16px; height: 16px;"><i class="bi bi-check" style="font-size: 12px;"></i></div>
                                    <span class="fw-medium text-dark" style="font-size: 12px;">Gestão de Conteúdo (CMS)</span>
                                </div>
                                <i class="bi bi-question-circle text-secondary" style="opacity: 0.5;"></i>
                            </div>
                        </div>
                        <button class="btn btn-link text-primary text-decoration-none p-0 d-flex align-items-center gap-1" style="font-size: 11px;">
                            <i class="bi bi-plus"></i> Adicionar funcionalidade
                        </button>
                    </div>

                    <!-- Tags -->
                    <div>
                        <label class="text-uppercase fw-bold text-secondary mb-2" style="font-size: 10px; letter-spacing: 0.5px;">TAGS</label>
                        <div class="d-flex flex-wrap gap-2 mb-2">
                            <span class="badge text-primary bg-primary-subtle fw-medium d-flex align-items-center gap-1 p-2 px-2" style="font-size: 11px;">Web Design <i class="bi bi-x text-primary" style="cursor:pointer; font-size:12px;"></i></span>
                            <span class="badge text-primary bg-primary-subtle fw-medium d-flex align-items-center gap-1 p-2 px-2" style="font-size: 11px;">SEO <i class="bi bi-x text-primary" style="cursor:pointer; font-size:12px;"></i></span>
                            <span class="badge text-primary bg-primary-subtle fw-medium d-flex align-items-center gap-1 p-2 px-2" style="font-size: 11px;">CMS <i class="bi bi-x text-primary" style="cursor:pointer; font-size:12px;"></i></span>
                        </div>
                        <button class="btn btn-link text-secondary text-decoration-none p-0 d-flex align-items-center gap-1" style="font-size: 11px;">
                            <i class="bi bi-plus"></i> nova tag
                        </button>
                    </div>

                    <!-- Order -->
                    <div>
                        <label class="text-uppercase fw-bold text-secondary mb-2" style="font-size: 10px; letter-spacing: 0.5px;">ORDEM DE EXIBIÇÃO</label>
                        <div class="d-flex align-items-center gap-3">
                            <input type="number" class="form-control text-center" value="1" style="width: 60px; font-size: 13px;">
                            <span class="text-secondary" style="font-size: 11px;">Posição na listagem do site</span>
                        </div>
                    </div>

                </div>

                <div class="card-footer bg-white border-top p-4 mt-auto d-flex flex-column gap-2">
                    <button class="btn btn-primary w-100 d-flex justify-content-center align-items-center gap-2 fw-medium py-2">
                        <i class="bi bi-lock-fill" style="font-size: 14px;"></i> Salvar Alterações
                    </button>
                    <button class="btn btn-link text-secondary text-decoration-none w-100" style="font-size: 13px;">Cancelar</button>
                </div>
            </aside>
        </div>
    </div>
    
    @push('styles')
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
    @endpush
</x-admin.layout>
