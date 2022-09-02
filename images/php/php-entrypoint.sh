#!/usr/bin/env sh
set -e

SUPERVISOR=/etc/supervisor/conf.d/supervisord.conf;
if test -f "$SUPERVISOR"; then
    sed -i "s#%BACK_DIR%#${BACK_DIR}#g" "$SUPERVISOR";
fi

exec "$@";

