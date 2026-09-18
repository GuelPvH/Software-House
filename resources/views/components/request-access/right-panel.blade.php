<div class="col-lg-5 bg-white position-relative d-flex flex-column justify-content-center align-items-center">
    <!-- Efeito de Fundo -->
    <div class="position-absolute opacity-25" style="width: 192px; height: 192px; right: 0; top: 0; background: radial-gradient(circle at 100% 0%, #2563eb 0%, transparent 70%);"></div>
    
    <!-- Container do Form -->
    <div class="w-100 px-4 position-relative z-1" style="max-width: 384px;">
        <div class="d-flex flex-column align-items-center gap-3 pb-4">
            <x-request-access.logo size="lg" />
            <div class="text-center">
                <h2 class="text-dark fs-4 fw-bold mb-1">Solicitar Acesso</h2>
                <p class="text-secondary small mb-0" style="max-width: 220px; margin: 0 auto;">Preencha os dados para solicitar acesso à plataforma</p>
            </div>
        </div>
        
        @if(session('sucesso'))
    <!-- Cardzinho -->
    <div class="text-center py-4">
        <div class="bg-primary-subtle text-primary rounded-circle d-inline-flex justify-content-center align-items-center mb-3" style="width: 64px; height: 64px;">
            <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" fill="currentColor" class="bi bi-check-lg" viewBox="0 0 16 16">
                <path d="M12.736 3.97a.733.733 0 0 1 1.047 0c.286.289.29.756.01 1.05L7.88 12.01a.733.733 0 0 1-1.065.02L3.217 8.384a.757.757 0 0 1 0-1.06.733.733 0 0 1 1.047 0l3.052 3.093 5.4-6.425z"/>
            </svg>
        </div>
        <h3 class="text-dark fs-4 fw-bold mb-2">Solicitação Enviada!</h3>
        <p class="text-secondary small mb-4">Recebemos seu pedido. Em breve você receberá um e-mail com as instruções.</p>
        <a href="{{ url('/login') }}" class="btn btn-primary w-100 py-2 fw-semibold" style="border-radius: 10px;">Voltar para o Login</a>
    </div>

@else

        <form action="{{ url('/solicitar-acesso') }}" method="POST" class="d-flex flex-column mb-4">
            @csrf
            
            <x-request-access.input-field 
                id="email" 
                label="Email corporativo" 
                type="email" 
                placeholder="admin@deploy.com.br" 
                required 
            />
            
            <x-request-access.input-field 
                id="name" 
                label="Nome completo" 
                placeholder="••••••••••••" 
                required 
            />
            
            <div class="form-check d-flex align-items-center gap-2 mb-4 mt-2">
                <input class="form-check-input mt-0 rounded-1" type="checkbox" id="termos" name="termos" required>
                <label class="form-check-label text-secondary" style="font-size: 13px;" for="termos">
                    Li e aceito os termos de uso
                </label>
            </div>
            
            <button type="submit" class="btn btn-primary w-100 py-2 fw-semibold shadow-sm mb-4" style="border-radius: 10px;">
                Enviar Solicitação
            </button>
        </form>
@endif
        
        <x-request-access.divider text="ou" />

        <div class="text-center text-secondary" style="font-size: 14px;">
    Já tem acesso? <a href="{{ url('/login') }}" class="text-primary text-decoration-none">Fazer login</a>
        </div>
    </div>

    <!-- Footer Direito -->
    <div class="position-absolute bottom-0 w-100 text-center pb-4 z-1">
        <span class="text-secondary" style="font-size: 12px;">Deploy &copy; {{ date('Y') }} &middot; Todos os direitos reservados</span>
    </div>
</div>