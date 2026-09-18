# Plano de implementação — acesso e operação

## Limites
Preservar páginas públicas, dados e tabelas. Migrações incrementais; nunca executar migrate:fresh, reset, rollback ou exclusão de volumes no banco existente. Testes automatizados em SQLite em memória.

## Perfis confirmados
- Desenvolvedor: dashboard de tarefas atribuídas, Kanban dos projetos em que participa e configurações pessoais.
- Financeiro: dashboard financeiro, financeiro e configurações pessoais.
- Gestor: todas as páginas e aprovação de acesso.
- Project Owner: clientes/leads, projetos, Kanban, dashboard operacional e configurações pessoais; sem valores financeiros.
- Administrador técnico: dashboard técnico, cadastro de permissões de rotas e perfis, usuários, auditoria e configurações de integração.

## Etapas
1. Inventariar banco real e estado do ambiente; registrar alterações preexistentes.
2. Autenticar por senha com sessão regenerada, limitação de tentativas, recuperação, verificação de e-mail e aprovação por gestor. Solicitação não concede acesso automaticamente.
3. Centralizar autorização no servidor, menus e cabeçalhos por perfil; bloquear também chamadas diretas.
4. Substituir métricas simuladas por consultas autorizadas no banco.
5. Persistir quadros, colunas, cartões, responsáveis, prazos, comentários, checklist e movimentação ordenada. Tratar concorrência e erro de rede.
6. Persistir configurações pessoais, segurança, empresa e integrações. Não exibir conexão fictícia.
7. Garantir entrega de e-mail por caixa de saída persistente, tentativas e estados auditáveis; validar SMTP local e separar de entrega externa.
8. Testar fluxo completo, recusas entre perfis, persistência após recarga e integridade da área pública.

## Implementação
Laravel/Blade e Bootstrap existentes. FormRequests validam entrada; policies e middleware aplicam autorização; transações protegem aprovação e movimentação; auditoria registra alterações sem senhas/tokens. E-mails são processados por worker e reenvio explícito de falhas.

## Critério de conclusão
Registrar testes executados, resultado visual, estado das migrações e qualquer dependência externa pendente. SMTP capturado localmente não é confirmação de chegada em caixa externa.
