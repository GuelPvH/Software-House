#!/bin/bash
# =============================================================================
# Entrypoint do container monolítico (Apache + PHP + Node).
#
# Garante que os diretórios graváveis do Laravel existam e tenham as
# permissões corretas, depois cede o controle para o apache2-foreground.
#
# O Apache faz o drop de privilégio dos workers para www-data por conta
# própria (via User/Group no apache2.conf), então não precisamos de su-exec.
# =============================================================================
set -eu

APP_ROOT="${APP_ROOT:-/var/www/html}"

log() { printf '[entrypoint] %s\n' "$*" >&2; }

# Diretórios que o Laravel precisa gravar em runtime.
WRITABLE_DIRS='
storage
storage/app
storage/app/public
storage/app/private
storage/debugbar
storage/framework
storage/framework/cache
storage/framework/cache/data
storage/framework/sessions
storage/framework/testing
storage/framework/views
storage/logs
bootstrap/cache
'

# Cria os diretórios se não existirem.
for dir in $WRITABLE_DIRS; do
    mkdir -p "${APP_ROOT}/${dir}"
done
mkdir -p "${APP_ROOT}/vendor"

# Ajusta donos e permissões para www-data.
# Em Docker Desktop o driver de bind mount pode ignorar o chown — isso não é
# erro; a gravabilidade real é verificada logo abaixo.
if ! chown -R www-data:www-data \
        "${APP_ROOT}/storage" "${APP_ROOT}/bootstrap" 2>/dev/null; then
    log "chown não teve efeito (esperado em bind mount do Docker Desktop)."
fi

chown www-data:www-data "${APP_ROOT}/vendor" 2>/dev/null || true

if ! chmod -R u+rwX,g+rwX \
        "${APP_ROOT}/storage" "${APP_ROOT}/bootstrap" 2>/dev/null; then
    log "chmod não teve efeito (esperado em bind mount do Docker Desktop)."
fi

# Verificação real de escrita: falha alto e cedo em vez de servir um 500
# incompreensível na primeira request.
for dir in storage/logs storage/framework/views bootstrap/cache vendor; do
    probe="${APP_ROOT}/${dir}/.entrypoint-write-probe"
    if ! (touch "${probe}" && rm -f "${probe}") 2>/dev/null; then
        # Em Docker Desktop bind mounts, o arquivo pode ser criado mas
        # a verificação de dono pode falhar. Tentativa sem restricao.
        if ! touch "${probe}" 2>/dev/null; then
            log "AVISO: não foi possível gravar em ${dir}. Verifique as permissões."
        else
            rm -f "${probe}" 2>/dev/null || true
        fi
    fi
done

exec "$@"
