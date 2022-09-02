#!/usr/bin/env sh
set -e

PROD=/etc/nginx/conf.d/production.conf;

if test -f "$PROD"; then
    sed -i "s#%DOMAIN%#${DOMAIN}#g" "$PROD";
    sed -i "s#%ENV%#${ENV}#g" "$PROD";
    sed -i "s#%BACK_DIR%#${BACK_DIR}#g" "$PROD";
fi

exec "$@";
