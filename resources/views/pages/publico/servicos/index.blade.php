@extends('layouts.site')

@section('title', 'Serviços')

@section('content')

    <!-- Cabeçalho / Hero -->
    <div class="container-fluid bg-slate-50 border-bottom py-5" style="background-color: #f8fafc80; margin-top: 80px;">
        <div class="container py-5 text-center" style="max-width: 1280px;">
            <div class="d-inline-flex px-3 py-1 bg-white rounded-pill border border-gray-200 mb-4">
                <span class="text-primary text-uppercase fs-7 fw-semibold tracking-tight">O que fazemos</span>
            </div>
            <h1 class="display-4 fw-bold text-dark mb-4">
                Tecnologia <span class="text-primary">sob medida</span> para cada<br>desafio
            </h1>
            <p class="text-muted fs-5 mx-auto" style="max-width: 672px;">
                Desde o planejamento estratégico e UX design até o desenvolvimento robusto e evolução contínua do seu produto digital.
            </p>
        </div>
    </div>

    <!-- Serviços Detalhados -->
    <div class="container py-5" style="max-width: 1280px;">
        
        <!-- 01. Web Design -->
        <div class="row align-items-center mb-5 pb-5 g-5">
            <div class="col-lg-6">
                <span class="text-primary text-uppercase fs-7 fw-bold tracking-wider">01. Web Design</span>
                <h2 class="fw-bold text-dark display-6 mt-2 mb-3">Desenvolvimento de Sites</h2>
                <p class="text-muted fs-6">
                    Criamos sites institucionais que não são apenas bonitos, mas máquinas de autoridade. Focamos em SEO técnico, performance extrema e total responsividade para garantir a melhor experiência em qualquer dispositivo.
                </p>
                <div class="d-flex flex-column gap-3 mt-4">
                    <div class="d-flex align-items-center gap-3">
                        <i class="fas fa-check-circle text-primary"></i>
                        <span class="text-dark">SEO Avançado</span>
                    </div>
                    <div class="d-flex align-items-center gap-3">
                        <i class="fas fa-check-circle text-primary"></i>
                        <span class="text-dark">Carregamento ultra-rápido</span>
                    </div>
                    <div class="d-flex align-items-center gap-3">
                        <i class="fas fa-check-circle text-primary"></i>
                        <span class="text-dark">Gestão de Conteúdo (CMS)</span>
                    </div>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="p-4 bg-light rounded-4 border shadow-sm position-relative">
                    <img src="https://www.image2url.com/r2/default/images/1788499028495-674795f0-592e-4e9d-81ea-7bd028e2932b.png" class="img-fluid rounded-3 shadow" alt="Web Design">
                </div>
            </div>
        </div>

        <!-- 02. Operações -->
        <div class="row align-items-center mb-5 pb-5 g-5 flex-lg-row-reverse">
            <div class="col-lg-6">
                <span class="text-primary text-uppercase fs-7 fw-bold tracking-wider">02. Operações</span>
                <h2 class="fw-bold text-dark display-6 mt-2 mb-3">Sistemas Web de Gestão</h2>
                <p class="text-muted fs-6">
                    Digitalize processos complexos com sistemas web escaláveis. Do ERP ao CRM personalizado, construímos ferramentas que centralizam sua operação e eliminam gargalos manuais.
                </p>
                <div class="p-4 bg-dark text-white rounded-3 mt-4 shadow">
                    <p class="mb-3 fst-italic">"A automação reduziu nosso tempo de resposta em 40% nas primeiras semanas."</p>
                    <div class="d-flex align-items-center gap-3">
                        <img src="https://placehold.co/40x40" class="rounded-circle" width="40" height="40" alt="Ricardo S.">
                        <div>
                            <h6 class="mb-0 fw-bold">Ricardo S.</h6>
                            <small class="text-white-50">Diretor de Operações</small>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="bg-white rounded-4 border shadow-sm overflow-hidden">
                    <div class="bg-light px-3 py-2 border-bottom d-flex gap-2 align-items-center">
                        <div class="bg-danger rounded-circle" style="width: 10px; height: 10px;"></div>
                        <div class="bg-warning rounded-circle" style="width: 10px; height: 10px;"></div>
                        <div class="bg-success rounded-circle" style="width: 10px; height: 10px;"></div>
                    </div>
                    <div class="p-4">
                        <div class="p-3 bg-primary bg-opacity-10 border border-primary-subtle rounded mb-3">
                            <div class="bg-primary-subtle rounded mb-2" style="width: 32px; height: 8px;"></div>
                            <div class="bg-primary rounded" style="width: 48px; height: 16px;"></div>
                        </div>
                        <div class="d-flex flex-column gap-2">
                            <div class="bg-light rounded" style="height: 16px; width: 100%;"></div>
                            <div class="bg-light rounded" style="height: 16px; width: 85%;"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- 03. Customizado -->
        <div class="row align-items-center mb-5 g-5">
            <div class="col-lg-6">
                <span class="text-primary text-uppercase fs-7 fw-bold tracking-wider">03. Customizado</span>
                <h2 class="fw-bold text-dark display-6 mt-2 mb-3">Software Sob Medida</h2>
                <p class="text-muted fs-6">
                    Quando ferramentas prontas não resolvem, nós criamos do zero. Software focado em regras de negócio específicas, com total segurança, logs de auditoria e arquitetura resiliente.
                </p>
                <div class="row g-3 mt-2">
                    <div class="col-6">
                        <div class="p-3 bg-light border rounded-3">
                            <i class="fas fa-shield-alt text-primary fs-4 mb-2"></i>
                            <h6 class="fw-bold mb-0">Segurança</h6>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="p-3 bg-light border rounded-3">
                            <i class="fas fa-server text-primary fs-4 mb-2"></i>
                            <h6 class="fw-bold mb-0">Escalabilidade</h6>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="p-4 bg-dark rounded-4 text-white font-monospace small">
                    <div class="text-muted mb-2">// Business Logic Layer</div>
                    <div><span class="text-pink">class</span> <span class="text-warning">CustomValidator</span> <span class="text-info">{</span></div>
                    <div class="ps-3 text-info">validateRules(data) {</div>
                    <div class="ps-5 text-success">const results = data.map(rule => rule.check());</div>
                    <div class="ps-5 text-info">return results.allPass();</div>
                    <div class="ps-3 text-info">}</div>
                    <div class="text-info">}</div>
                    <div class="text-muted mt-3 mb-1">// Audit Trail Integration</div>
                    <div><span class="text-white">logger.info(</span><span class="text-warning">"Process validated and executed"</span><span class="text-white">);</span></div>
                </div>
            </div>
        </div>

    </div>

    <!-- Processo - Como Contratar -->
    <div class="container-fluid bg-dark text-white py-5">
        <div class="container py-5" style="max-width: 1280px;">
            <div class="text-center mb-5">
                <h2 class="fw-bold display-6">Como contratar</h2>
                <p class="text-white-50">Um processo transparente para levar seu projeto do papel à realidade.</p>
            </div>
            
            <div class="row text-center g-4">
                <div class="col">
                    <div class="rounded-circle bg-white bg-opacity-10 border border-white border-opacity-25 d-flex align-items-center justify-content-center mx-auto mb-3" style="width: 64px; height: 64px;">
                        <span class="fw-bold fs-5">01</span>
                    </div>
                    <h6 class="fw-bold">Contato</h6>
                    <small class="text-white-50">Briefing inicial para entender seu desafio.</small>
                </div>
                <div class="col">
                    <div class="rounded-circle bg-white bg-opacity-10 border border-white border-opacity-25 d-flex align-items-center justify-content-center mx-auto mb-3" style="width: 64px; height: 64px;">
                        <span class="fw-bold fs-5">02</span>
                    </div>
                    <h6 class="fw-bold">Análise</h6>
                    <small class="text-white-50">Estudo de viabilidade técnica e arquitetura.</small>
                </div>
                <div class="col">
                    <div class="rounded-circle bg-white bg-opacity-10 border border-white border-opacity-25 d-flex align-items-center justify-content-center mx-auto mb-3" style="width: 64px; height: 64px;">
                        <span class="fw-bold fs-5">03</span>
                    </div>
                    <h6 class="fw-bold">Proposta</h6>
                    <small class="text-white-50">Cronograma detalhado e investimento.</small>
                </div>
                <div class="col">
                    <div class="rounded-circle bg-white bg-opacity-10 border border-white border-opacity-25 d-flex align-items-center justify-content-center mx-auto mb-3" style="width: 64px; height: 64px;">
                        <span class="fw-bold fs-5">04</span>
                    </div>
                    <h6 class="fw-bold">Dev</h6>
                    <small class="text-white-50">Desenvolvimento ágil com entregas semanais.</small>
                </div>
                <div class="col">
                    <div class="rounded-circle bg-white bg-opacity-10 border border-white border-opacity-25 d-flex align-items-center justify-content-center mx-auto mb-3" style="width: 64px; height: 64px;">
                        <span class="fw-bold fs-5">05</span>
                    </div>
                    <h6 class="fw-bold">Entrega</h6>
                    <small class="text-white-50">Lançamento, treinamento e suporte.</small>
                </div>
            </div>
        </div>
    </div>

    <!-- CTA Final -->
    <div class="container-fluid bg-light py-5 text-center border-top">
        <div class="container py-4" style="max-width: 896px;">
            <h3 class="fw-bold text-dark mb-3">Não encontrou exatamente o que precisa?</h3>
            <p class="text-muted mb-4">Cada negócio é único. Vamos conversar sobre sua ideia e construir uma solução personalizada.</p>
            <a href="#" class="btn btn-primary px-4 py-3 fw-bold rounded-3 shadow d-inline-flex align-items-center gap-2">
                <i class="fab fa-whatsapp fs-5"></i> Falar sobre meu projeto
            </a>
        </div>
    </div>

    <!-- Footer -->
    <footer class="bg-white border-top py-5">
        <div class="container" style="max-width: 1280px;">
            <div class="row gy-4">
                <div class="col-lg-6">
                    <div class="d-flex align-items-center gap-2 mb-2">
                        <div class="bg-primary text-white fw-bold rounded px-2 py-1">D</div>
                        <span class="fw-bold fs-5">Deploy</span>
                    </div>
                    <p class="text-muted small">Transformando ideias em software de alto impacto.</p>
                </div>
                <div class="col-lg-3">
                    <h6 class="fw-bold mb-3">Serviços</h6>
                    <ul class="list-unstyled text-muted small d-flex flex-column gap-2">
                        <li>Sistemas Web</li>
                        <li>Software Custom</li>
                        <li>Dashboards</li>
                    </ul>
                </div>
                <div class="col-lg-3">
                    <h6 class="fw-bold mb-3">Empresa</h6>
                    <ul class="list-unstyled text-muted small d-flex flex-column gap-2">
                        <li>Sobre Nós</li>
                    </ul>
                </div>
            </div>
        </div>
    </footer>
@endsection