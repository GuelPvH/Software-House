<x-layouts.base title="Admin Login" body-class="bg-white">
    <div class="container-fluid p-0">
        <div class="row g-0 min-vh-100">

            <!-- Painel esquerdo -->
            <div class="col-lg-6 d-none d-lg-flex flex-column justify-content-between p-5 text-white position-relative"
                 style="background: linear-gradient(160deg, #0b1220 0%, #0f1c33 55%, #13294d 100%);">

                <div class="d-flex align-items-center gap-2 fw-semibold">
                    <span class="d-inline-flex align-items-center justify-content-center bg-primary text-white rounded-2 fw-bold"
                          style="width: 28px; height: 28px; font-size: 14px;">D</span>
                    Deploy
                </div>

                <div style="max-width: 420px;">
                    <span class="badge rounded-pill fw-medium px-3 py-2 mb-4 d-inline-flex align-items-center gap-2"
                          style="font-size: 11px; background: rgba(255,255,255,0.08); color: rgba(255,255,255,0.75);">
                        <i class="bi bi-circle-fill text-primary" style="font-size: 6px;"></i>
                        Plataforma de Gestão
                    </span>

                    <h1 class="fw-bold display-6 lh-sm mb-3">
                        Solicite seu acesso<br>
                        <span class="text-primary">com segurança</span>
                    </h1>

                    <p class="text-white-50 mb-0" style="font-size: 14px;">
                        Uma plataforma completa para gerenciar leads, projetos, serviços e finanças da sua software house.
                    </p>
                </div>

                <small class="text-white-50" style="font-size: 11px;">
                    Deploy &copy; {{ now()->year }} &middot; Todos os direitos reservados.
                </small>
            </div>

            <!-- Formulário -->
            <div class="col-12 col-lg-6 d-flex flex-column justify-content-between p-4 p-lg-5">

                <div class="flex-grow-1 d-flex align-items-center justify-content-center">
                    <div class="w-100" style="max-width: 380px;">

                        <div class="text-center mb-4">
                            <span class="d-inline-flex align-items-center justify-content-center bg-primary text-white rounded-3 fw-bold mb-3"
                                  style="width: 40px; height: 40px; font-size: 18px;">D</span>
                            <h2 class="h4 fw-bold mb-1" style="font-size: 28px;">Solicitar Acesso</h2>
                            <p class="text-secondary mb-0" style="font-size: 16px;">Preencha os dados para solicitar acesso à plataforma</p>
                        </div>

                        <form method="POST" action="{{ route('auth.solicitar-acesso.store') }}">
                            @csrf
                            <div class="mb-3">
                                <label for="email" class="form-label small fw-semibold">Email Corporativo</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-white border-end-0 text-secondary">
                                        <i class="bi bi-envelope"></i>
                                    </span>
                                    <input
                                        id="email"
                                        name="email"
                                        type="email"
                                        value="{{ old('email') }}"
                                        class="form-control border-start-0 ps-0 @error('email') is-invalid @enderror"
                                        placeholder="admin@deploy.com.br"
                                        autocomplete="username"
                                        required
                                        autofocus
                                    >
                                    @error('email')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="mb-2">
                                <label for="name" class="form-label small fw-semibold">Nome Completo</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-white border-end-0 text-secondary">
                                        <i class="bi bi-lock"></i>
                                    </span>
                                    <input
                                        id="name"
                                        name="name"
                                        type="text"
                                        class="form-control border-start-0 ps-0 @error('name') is-invalid @enderror"
                                        placeholder="••••••••••"
                                        autocomplete="name"
                                        required
                                    >
                                    @error('name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-check mb-4">
                                <input id="remember" name="remember" type="checkbox" value="1" class="form-check-input">
                                <label for="remember" class="form-check-label text-secondary" style="font-size: 13px;">
                                    Li e aceito os Termos de Uso
                                </label>
                            </div>

                            <button type="submit" class="btn btn-primary w-100 py-2 fw-semibold d-flex align-items-center justify-content-center gap-2">
                                <i class="bi bi-box-arrow-in-right"></i> Enviar Solicitação
                            </button>
                        </form>

                        <p class="text-center text-secondary mt-4 mb-0" style="font-size: 12px;">
                            Já tem acesso?
                            <a href="{{ route('admin.login.index') }}" class="text-primary text-decoration-none fw-medium">Fazer login</a>
                        </p>
                    </div>
                </div>

                <small class="text-secondary text-center d-block" style="font-size: 11px;">
                    Deploy &copy; {{ now()->year }} &middot; Todos os direitos reservados.
                </small>
            </div>

        </div>
    </div>
</x-layouts.base>