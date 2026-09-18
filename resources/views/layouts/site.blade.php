<x-layouts.base :title="trim($__env->yieldContent('title')) ?: null" body-class="bg-white">
    <x-publico.navbar />

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

    <x-form.notification />
</x-layouts.base>