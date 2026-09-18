@extends('layouts.site')

@section('title', 'Início')

@section('content')

    <!-- Hero Section -->
    <main class="container hero-section" style="max-width: 1280px; margin-top: 100px;">
        <div class="row align-items-center g-5">
            <div class="col-lg-7 d-flex flex-column align-items-start gap-4">
                <div class="badge bg-light border text-secondary rounded-pill d-inline-flex align-items-center gap-2 px-3 py-2 text-uppercase fw-semibold" style="font-size: 0.75rem;">
                    <span class="bg-primary rounded-circle" style="width: 8px; height: 8px;"></span>
                    Desenvolvimento de Software e Soluções Digitais
                </div>
                
                <h1 class="display-4 fw-bold text-dark mb-0 lh-sm">
                    Transformamos<br>ideias em <br><span class="text-primary">soluções digitais</span>
                </h1>
                
                <p class="text-secondary fs-5 pe-lg-5 mb-0">
                    Desenvolvemos sistemas personalizados, plataformas web e aplicativos escaláveis para impulsionar o crescimento do seu negócio com tecnologia de ponta.
                </p>
                
                <div class="d-flex flex-wrap align-items-center gap-3 mt-2">
                    <a href="{{ route('publico.contato.index') }}" class="btn btn-dark px-4 py-3 fw-medium d-flex align-items-center gap-2 shadow-sm">
                        Solicitar orçamento <i class="fas fa-arrow-right ms-2 fs-6"></i>
                    </a>
                    <a href="{{ route('publico.inicio.index') }}" class="btn border px-4 py-3 fw-medium text-dark bg-white">
                        Conhecer nossos serviços
                    </a>
                </div>
            </div>

            <div class="col-lg-5 position-relative d-none d-lg-block">
                <div class="position-absolute bg-white rounded-3 p-3 shadow-lg border" style="width: 14rem; top: 40px; left: -40px; z-index: 10;">
                    <div class="d-flex align-items-center gap-2 mb-1">
                        <div class="bg-success bg-opacity-25 rounded-circle d-flex justify-content-center align-items-center" style="width: 32px; height: 32px;">
                            <i class="fas fa-check text-success small"></i>
                        </div>
                        <span class="fw-semibold text-dark small">Deploy Status</span>
                    </div>
                    <span class="text-secondary" style="font-size: 0.75rem;">Production is online</span>
                </div>

                <div class="bg-light rounded-4 shadow-sm border overflow-hidden" style="height: 500px;">
                    <div class="bg-white border-bottom d-flex align-items-center px-3 gap-2" style="height: 40px;">
                        <div class="bg-danger rounded-circle" style="width: 12px; height: 12px;"></div>
                        <div class="bg-warning rounded-circle" style="width: 12px; height: 12px;"></div>
                        <div class="bg-success rounded-circle" style="width: 12px; height: 12px;"></div>
                    </div>
                    
                    <div class="p-4 d-flex flex-column gap-3">
                        <div class="bg-white border rounded p-3 d-flex flex-column justify-content-between h-100 shadow-sm" style="height: 120px;">
                            <div class="bg-secondary bg-opacity-25 rounded mb-3" style="width: 80px; height: 12px;"></div>
                            <div class="d-flex align-items-end gap-2" style="height: 48px;">
                                <div class="bg-primary bg-opacity-25 rounded-top w-100" style="height: 40%;"></div>
                                <div class="bg-primary bg-opacity-50 rounded-top w-100" style="height: 60%;"></div>
                                <div class="bg-primary bg-opacity-25 rounded-top w-100" style="height: 30%;"></div>
                                <div class="bg-primary bg-opacity-75 rounded-top w-100" style="height: 90%;"></div>
                                <div class="bg-primary bg-opacity-50 rounded-top w-100" style="height: 50%;"></div>
                                <div class="bg-primary rounded-top w-100" style="height: 100%;"></div>
                            </div>
                        </div>
                        
                        <div class="code-editor rounded p-3 text-white bg-dark" style="font-family: monospace; font-size: 0.75rem;">
                            <div class="text-secondary mb-2">// API Controller</div>
                            <div><span class="text-pink">const</span> <span class="text-info">deployApp</span> = <span class="text-warning">async</span> (req, res) => {</div>
                            <div class="ms-3"><span class="text-pink">try</span> {</div>
                            <div class="ms-4 text-white">const solution = await System.build({</div>
                            <div class="ms-5 text-success">scalable: true,</div>
                            <div class="ms-5 text-success">secure: true,</div>
                            <div class="ms-5 text-success">performance: 'optimal'</div>
                            <div class="ms-4 text-white">});</div>
                            <div class="ms-4 text-white mt-2">return res.status(200).json(solution);</div>
                            <div class="ms-3"><span class="text-info">}</span> <span class="text-pink">catch</span> (error) {</div>
                        </div>
                        
                        <div class="d-flex gap-3">
                            <div class="bg-white border rounded p-3 flex-fill shadow-sm">
                                <div class="bg-secondary bg-opacity-25 rounded mb-2" style="width: 50px; height: 10px;"></div>
                                <div class="fw-bold fs-4 text-dark">99.9%</div>
                            </div>
                            <div class="bg-white border rounded p-3 flex-fill shadow-sm">
                                <div class="bg-secondary bg-opacity-25 rounded mb-2" style="width: 50px; height: 10px;"></div>
                                <div class="fw-bold fs-4 text-dark">Zero</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <!-- Serviços Section -->
    <section class="bg-light border-top border-bottom py-5 mt-5" style="background-color: rgba(248, 250, 252, 0.3) !important;">
        <div class="container d-flex flex-column align-items-center gap-5 py-5" style="max-width: 1280px;">
            
            <div class="text-center d-flex flex-column gap-3" style="max-width: 672px;">
                <h2 class="fs-2 fw-bold text-dark mb-0">Nossos Serviços</h2>
                <p class="text-secondary fs-6 mb-0">Soluções completas de ponta a ponta para digitalizar e escalar sua operação.</p>
            </div>
            
            <div class="row w-100 justify-content-center g-4">
                
                <!-- Card 1 -->
                <div class="col-md-6 col-lg-4 d-flex">
                    <div class="bg-white rounded-3 shadow-sm border p-4 w-100">
                        <div class="bg-primary bg-opacity-10 rounded-2 d-flex justify-content-center align-items-center mb-3" style="width: 48px; height: 48px;">
                            <i class="fas fa-code text-primary fs-5"></i>
                        </div>
                        <h3 class="fs-5 fw-semibold text-dark">Sistemas Web</h3>
                        <p class="text-secondary small mb-0 mt-2">Plataformas robustas e escaláveis sob medida para automatizar processos complexos do seu negócio.</p>
                    </div>
                </div>

                <!-- Card 2 -->
                <div class="col-md-6 col-lg-4 d-flex">
                    <div class="bg-white rounded-3 shadow-sm border p-4 w-100">
                        <div class="bg-primary bg-opacity-10 rounded-2 d-flex justify-content-center align-items-center mb-3" style="width: 48px; height: 48px;">
                            <i class="fas fa-laptop-code text-primary fs-5"></i>
                        </div>
                        <h3 class="fs-5 fw-semibold text-dark">Software Sob Medida</h3>
                        <p class="text-secondary small mb-0 mt-2">Desenvolvimento focado nas regras de negócio específicas da sua empresa, garantindo aderência total.</p>
                    </div>
                </div>

                <!-- Card 3 -->
                <div class="col-md-6 col-lg-4 d-flex">
                    <div class="bg-white rounded-3 shadow-sm border p-4 w-100">
                        <div class="bg-primary bg-opacity-10 rounded-2 d-flex justify-content-center align-items-center mb-3" style="width: 48px; height: 48px;">
                            <i class="fas fa-chart-pie text-primary fs-5"></i>
                        </div>
                        <h3 class="fs-5 fw-semibold text-dark">Dashboards</h3>
                        <p class="text-secondary small mb-0 mt-2">Painéis analíticos interativos para visualização de dados e tomada de decisão em tempo real.</p>
                    </div>
                </div>

            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-white pt-5 pb-4 border-top">
        <div class="container d-flex flex-column gap-5" style="max-width: 1280px;">
            <div class="row gy-4">
                <div class="col-lg-6 d-flex flex-column gap-4">
                    <div class="d-flex align-items-center gap-2">
                        <div class="bg-primary text-white rounded d-flex justify-content-center align-items-center" style="width: 24px; height: 24px; font-weight: bold; font-size: 0.8rem;">D</div>
                        <span class="fs-5 fw-bold text-dark">Deploy</span>
                    </div>
                    <p class="text-secondary small mb-0">Transformando ideias em software de alto<br>impacto.</p>
                </div>
                <div class="col-lg-6 d-flex flex-column gap-3">
                    <h6 class="fw-semibold text-dark mb-1">Serviços</h6>
                    <a href="#" class="text-secondary small text-decoration-none">Sistemas Web</a>
                    <a href="#" class="text-secondary small text-decoration-none">APIs</a>
                </div>
            </div>
            <div class="d-flex flex-column flex-md-row justify-content-between align-items-center border-top pt-4">
                <p class="text-secondary small mb-0">© 2024 Deploy Software. Todos os direitos reservados.</p>
                <div class="d-flex gap-3 mt-3 mt-md-0">
                    <a href="#" class="text-secondary fs-5"><i class="fab fa-linkedin"></i></a>
                    <a href="#" class="text-secondary fs-5"><i class="fab fa-github"></i></a>
                </div>
            </div>
        </div>
    </footer>
@endsection