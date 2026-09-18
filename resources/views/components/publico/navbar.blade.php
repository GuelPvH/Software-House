<nav class="navbar navbar-expand-lg bg-white border-bottom py-3 {{ $class ?? '' }}">
    <div class="container">
        <a class="navbar-brand d-flex align-items-center gap-2 fw-semibold text-dark" href="{{ route('publico.deploy.inicio-deploy') }}">
            <span class="d-inline-flex align-items-center justify-content-center bg-primary text-white rounded-2 fw-bold" style="width: 28px; height: 28px; font-size: 14px;">D</span>
            Deploy
        </a>

        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#siteNavbar" aria-controls="siteNavbar" aria-expanded="false" aria-label="Alternar navegação">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="siteNavbar">
            <ul class="navbar-nav mx-auto gap-lg-4 align-items-lg-center">
                <li class="nav-item">
                    <a class="nav-link {{ Route::is('publico.deploy.inicio-deploy') ? 'text-primary fw-medium' : 'text-secondary' }}" href="{{ route('publico.deploy.inicio-deploy') }}">Início</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ Route::is('publico.deploy.servicos-deploy') ? 'text-primary fw-medium' : 'text-secondary' }}" href="{{ route('publico.deploy.servicos-deploy')}}">Serviços</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ Route::is('publico.projetos.index') ? 'text-primary fw-medium' : 'text-secondary' }}" href="{{ route('publico.projetos.index') }}">Projetos</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ Route::is('publico.contato.index') ? 'text-primary fw-medium' : 'text-secondary' }}" href="{{ route('publico.contato.index') }}">Contato</a>
                </li>
            </ul>
            @if(!Route::is('publico.contato.index'))
            <div class="d-lg-flex mt-3 mt-lg-0">
                <a href="{{ route('publico.contato.index') }}" class="btn btn-primary fw-semibold px-3">
                    Solicitar orçamento
                </a>
            </div>
            @endif
        </div>
    </div>
</nav>
