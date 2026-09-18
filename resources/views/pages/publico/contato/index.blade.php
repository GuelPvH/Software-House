@extends('layouts.site')

@section('title', 'Contato')

@section('content')
    <section class="bg-body-tertiary py-5 border-bottom">
        <div class="container text-center py-4">
            <span class="badge rounded-pill bg-primary-subtle text-primary fw-semibold px-3 py-2 mb-3" style="font-size: 11px; letter-spacing: 0.5px;">
                VAMOS COMEÇAR
            </span>
            <h1 class="fw-bold display-6 mb-3">
                Conte para nós sobre <span class="text-primary">seu projeto</span>
            </h1>
            <p class="text-secondary mx-auto mb-0" style="max-width: 560px;">
                Analisamos cada detalhe das suas necessidades para propor a melhor solução tecnológica, com prazos realistas e arquitetura escalável.
            </p>
        </div>
    </section>

    <section class="py-5">
        <div class="container">
            <div class="row g-4">
                <!-- Coluna esquerda -->
                <div class="col-12 col-lg-4">
                    <h2 class="h5 fw-bold mb-4">Informações de Contato</h2>

                    <div class="d-flex align-items-start gap-3 mb-4">
                        <span class="d-inline-flex align-items-center justify-content-center bg-primary bg-opacity-10 text-primary rounded-3" style="width: 40px; height: 40px; flex-shrink: 0;">
                            <i class="bi bi-whatsapp"></i>
                        </span>
                        <div>
                            <span class="d-block fw-semibold small text-dark">WhatsApp</span>
                            <span class="d-block text-secondary small">+55 (11) 99999-9999</span>
                        </div>
                    </div>

                    <div class="d-flex align-items-start gap-3 mb-4">
                        <span class="d-inline-flex align-items-center justify-content-center bg-primary bg-opacity-10 text-primary rounded-3" style="width: 40px; height: 40px; flex-shrink: 0;">
                            <i class="bi bi-envelope"></i>
                        </span>
                        <div>
                            <span class="d-block fw-semibold small text-dark">E-mail</span>
                            <span class="d-block text-secondary small">contato@deploy.com.br</span>
                        </div>
                    </div>

                    <div class="d-flex align-items-start gap-3 mb-4">
                        <span class="d-inline-flex align-items-center justify-content-center bg-primary bg-opacity-10 text-primary rounded-3" style="width: 40px; height: 40px; flex-shrink: 0;">
                            <i class="bi bi-clock"></i>
                        </span>
                        <div>
                            <span class="d-block fw-semibold small text-dark">Horário de Atendimento</span>
                            <span class="d-block text-secondary small">Segunda à Sexta, 09:00 às 18:00</span>
                        </div>
                    </div>

                    <div class="bg-dark text-white rounded-4 p-4 mb-4">
                        <h3 class="fw-bold fs-6 mb-3">Por que a Deploy?</h3>
                        <ul class="list-unstyled d-flex flex-column gap-2 mb-0">
                            <li class="d-flex align-items-start gap-2">
                                <i class="bi bi-check-lg text-primary mt-1"></i>
                                <span class="small">Especialistas em tecnologias modernas (React, Node, Cloud).</span>
                            </li>
                            <li class="d-flex align-items-start gap-2">
                                <i class="bi bi-check-lg text-primary mt-1"></i>
                                <span class="small">Processo de desenvolvimento ágil e transparente.</span>
                            </li>
                            <li class="d-flex align-items-start gap-2">
                                <i class="bi bi-check-lg text-primary mt-1"></i>
                                <span class="small">Foco total em ROI e experiência do usuário.</span>
                            </li>
                        </ul>
                    </div>

                    <div class="rounded-4 overflow-hidden" style="height: 160px; background: linear-gradient(135deg, #dbeafe, #eff6ff);">
                        <div class="d-flex align-items-center justify-content-center h-100 text-primary">
                            <i class="bi bi-building fs-1"></i>
                        </div>
                    </div>
                </div>

                <!-- Formulário -->
                <div class="col-12 col-lg-8">
                    <div class="card border-0 shadow-sm rounded-4 p-4 p-md-5">
                        <form action="#" method="POST">
                            @csrf

                            <div class="row g-3">
                                <div class="col-12 col-md-6">
                                    <label for="nome" class="form-label small fw-semibold">Seu Nome</label>
                                    <input type="text" class="form-control" id="nome" name="nome" placeholder="Ex: João Silva">
                                </div>
                                <div class="col-12 col-md-6">
                                    <label for="empresa" class="form-label small fw-semibold">Empresa</label>
                                    <input type="text" class="form-control" id="empresa" name="empresa" placeholder="Nome da sua empresa">
                                </div>

                                <div class="col-12 col-md-6">
                                    <label for="email" class="form-label small fw-semibold">E-mail Corporativo</label>
                                    <input type="email" class="form-control" id="email" name="email" placeholder="joao@empresa.com.br">
                                </div>
                                <div class="col-12 col-md-6">
                                    <label for="whatsapp" class="form-label small fw-semibold">WhatsApp</label>
                                    <input type="text" class="form-control" id="whatsapp" name="whatsapp" placeholder="(11) 00000-0000">
                                </div>

                                <div class="col-12 col-md-6">
                                    <label for="tipo_projeto" class="form-label small fw-semibold">Tipo de Projeto</label>
                                    <select class="form-select" id="tipo_projeto" name="tipo_projeto">
                                        <option selected disabled>Selecione uma opção</option>
                                        <option>Sistema Web</option>
                                        <option>Aplicativo Mobile</option>
                                        <option>Dashboard / BI</option>
                                        <option>Landing Page</option>
                                        <option>Outro</option>
                                    </select>
                                </div>
                                <div class="col-12 col-md-6">
                                    <label for="prazo" class="form-label small fw-semibold">Prazo Estimado</label>
                                    <select class="form-select" id="prazo" name="prazo">
                                        <option selected disabled>Selecione o prazo</option>
                                        <option>Até 1 mês</option>
                                        <option>1 a 3 meses</option>
                                        <option>3 a 6 meses</option>
                                        <option>Ainda não sei</option>
                                    </select>
                                </div>

                                <div class="col-12">
                                    <label for="objetivo" class="form-label small fw-semibold">Objetivo do Projeto</label>
                                    <input type="text" class="form-control" id="objetivo" name="objetivo" placeholder="O que você deseja alcançar com este projeto?">
                                </div>

                                <div class="col-12">
                                    <label for="funcionalidades" class="form-label small fw-semibold">Funcionalidades Principais</label>
                                    <textarea class="form-control" id="funcionalidades" name="funcionalidades" rows="3" placeholder="Descreva brevemente o que o sistema deve fazer..."></textarea>
                                </div>

                                <div class="col-12">
                                    <label for="referencia" class="form-label small fw-semibold">Link de Referência (Opcional)</label>
                                    <input type="text" class="form-control" id="referencia" name="referencia" placeholder="Ex: concorrente.com.br ou design que você gosta">
                                </div>

                                <div class="col-12">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="termos" name="termos">
                                        <label class="form-check-label small text-secondary" for="termos">
                                            Concordo com os <a href="#" class="text-primary">Termos de Privacidade</a> e autorizo o contato da equipe comercial da Deploy.
                                        </label>
                                    </div>
                                </div>

                                <div class="col-12">
                                    <button type="submit" class="btn btn-primary w-100 py-2 fw-semibold d-flex align-items-center justify-content-center gap-2">
                                        Enviar solicitação <i class="bi bi-send"></i>
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- FAQ -->
    <section class="bg-body-tertiary py-5">
        <div class="container">
            <div class="text-center mb-5">
                <h2 class="fw-bold h3 mb-2">Perguntas Frequentes</h2>
                <p class="text-secondary mb-0">Tire suas dúvidas rápidas sobre o nosso processo de trabalho.</p>
            </div>

            <div class="accordion mx-auto" id="faqAccordion" style="max-width: 760px;">
                @php
                    $faqs = [
                        [
                            'pergunta' => 'Como funciona a precificação dos projetos?',
                            'resposta' => 'Nossos orçamentos são baseados na complexidade técnica, volume de funcionalidades e prazo de entrega. Trabalhamos com escopo fechado para projetos definidos ou squad dedicada para evolução contínua.',
                        ],
                        [
                            'pergunta' => 'Qual o tempo médio de desenvolvimento?',
                            'resposta' => 'Uma landing page pode levar de 1 a 2 semanas, enquanto sistemas web complexos variam entre 3 a 6 meses. O cronograma é detalhado logo após a análise técnica inicial.',
                        ],
                        [
                            'pergunta' => 'Vocês oferecem manutenção pós-entrega?',
                            'resposta' => 'Sim. Oferecemos planos de suporte técnico, correções de bugs, atualizações de segurança e monitoramento de servidores para garantir que seu software esteja sempre operando perfeitamente.',
                        ],
                        [
                            'pergunta' => 'Eu serei o dono do código-fonte?',
                            'resposta' => 'Com certeza. Ao finalizar o projeto e concluir os pagamentos, o código-fonte e toda a propriedade intelectual do software desenvolvido pertencem integralmente à sua empresa.',
                        ],
                        [
                            'pergunta' => 'Quais tecnologias a Deploy utiliza?',
                            'resposta' => 'Trabalhamos com o ecossistema moderno de JavaScript (Node.js, React, Next.js), além de bancos de dados robustos (PostgreSQL, MongoDB) e infraestrutura em nuvem (AWS, Google Cloud).',
                        ],
                        [
                            'pergunta' => 'Como acompanho o desenvolvimento do meu projeto?',
                            'resposta' => 'Utilizamos metodologias ágeis com reuniões de status periódicas e um ambiente de homologação onde você pode testar as funcionalidades conforme são finalizadas em cada sprint.',
                        ],
                    ];
                @endphp

                @foreach ($faqs as $index => $faq)
                    <div class="accordion-item border-0 border-bottom bg-transparent">
                        <h3 class="accordion-header">
                            <button class="accordion-button collapsed bg-transparent fw-semibold px-0 shadow-none" type="button" data-bs-toggle="collapse" data-bs-target="#faq{{ $index }}">
                                {{ $faq['pergunta'] }}
                            </button>
                        </h3>
                        <div id="faq{{ $index }}" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                            <div class="accordion-body px-0 pt-0 text-secondary small">
                                {{ $faq['resposta'] }}
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>
@endsection