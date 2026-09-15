<x-layouts.base :title="trim($__env->yieldContent('title')) ?: null" body-class="bg-white">
    <nav class="navbar navbar-expand-lg bg-white border-bottom py-3">
        <div class="container">
            <a class="navbar-brand d-flex align-items-center gap-2 fw-semibold text-dark" href="{{ route('publico.index') }}">
                <span class="d-inline-flex align-items-center justify-content-center bg-primary text-white rounded-2 fw-bold" style="width: 28px; height: 28px; font-size: 14px;">D</span>
                Deploy
            </a>

            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#siteNavbar" aria-controls="siteNavbar" aria-expanded="false" aria-label="Alternar navegação">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse justify-content-end" id="siteNavbar">
                <ul class="navbar-nav gap-lg-4 align-items-lg-center">
                    <li class="nav-item"><a class="nav-link text-secondary" href="{{ route('publico.index') }}">Início</a></li>
                    <li class="nav-item"><a class="nav-link text-secondary" href="#servicos">Serviços</a></li>
                    <li class="nav-item"><a class="nav-link text-secondary" href="{{ route('publico.projetos.index') }}">Projetos</a></li>
                    <li class="nav-item"><a class="nav-link text-secondary" href="{{ route('publico.contato.index') }}">Contato</a></li>
                </ul>

                <a href="{{ route('publico.contato.index') }}" class="btn btn-primary fw-semibold px-3 ms-lg-4 mt-3 mt-lg-0">
                    Solicitar orçamento
                </a>
            </div>
        </div>
    </nav>

    <main>
        @yield('content')
    </main>

    <footer class="bg-white border-top py-5">
        <div class="container">
            <div class="row g-4">
                <div class="col-12 col-md-4">
                    <div class="d-flex align-items-center gap-2 fw-semibold text-dark mb-2">
                        <span class="d-inline-flex align-items-center justify-content-center bg-primary text-white rounded-2 fw-bold" style="width: 24px; height: 24px; font-size: 12px;">D</span>
                        Deploy
                    </div>
                    <p class="text-secondary small mb-0">Transformando ideias em software de alto impacto.</p>
                </div>

                <div class="col-6 col-md-2">
                    <h6 class="fw-bold small text-dark mb-3">Serviços</h6>
                    <ul class="list-unstyled d-flex flex-column gap-2">
                        <li><a href="#" class="text-secondary small text-decoration-none">Sistemas Web</a></li>
                        <li><a href="#" class="text-secondary small text-decoration-none">Software Custom</a></li>
                        <li><a href="#" class="text-secondary small text-decoration-none">Dashboards</a></li>
                    </ul>
                </div>

                <div class="col-6 col-md-2">
                    <h6 class="fw-bold small text-dark mb-3">Empresa</h6>
                    <ul class="list-unstyled d-flex flex-column gap-2">
                        <li><a href="#" class="text-secondary small text-decoration-none">Sobre Nós</a></li>
                        <li><a href="#" class="text-secondary small text-decoration-none">Projetos</a></li>
                        <li><a href="{{ route('publico.contato.index') }}" class="text-secondary small text-decoration-none">Contato</a></li>
                    </ul>
                </div>

                <div class="col-12 col-md-4">
                    <h6 class="fw-bold small text-dark mb-3">Siga-nos</h6>
                    <div class="d-flex gap-3">
                        <a href="#" class="text-secondary"><i class="bi bi-linkedin fs-5"></i></a>
                        <a href="#" class="text-secondary"><i class="bi bi-github fs-5"></i></a>
                        <a href="#" class="text-secondary"><i class="bi bi-instagram fs-5"></i></a>
                    </div>
                </div>
            </div>

            <hr class="my-4">

            <div class="d-flex flex-column flex-md-row justify-content-between align-items-center gap-2">
                <small class="text-secondary">&copy; {{ now()->year }} Deploy Software. Todos os direitos reservados.</small>
                <div class="d-flex gap-3">
                    <a href="#" class="text-secondary small text-decoration-none">Privacidade</a>
                    <a href="#" class="text-secondary small text-decoration-none">Termos de Uso</a>
                </div>
            </div>
        </div>
    </footer>
</x-layouts.base>