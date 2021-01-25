#!/usr/bin/env bash

set -e

# first arg is `-f` or `--some-option`
if [ "${1#-}" != "$1" ]; then
	set -- php-fpm "$@"
fi

#setfacl -R -m u:"www-data":rwX -m u:`whoami`:rwX /var/www/var
#setfacl -dR -m u:"www-data":rwX -m u:`whoami`:rwX /var/www/var
#setfacl -R -m u:"www-data":rwX -m u:`whoami`:rwX /var/www/app
#setfacl -dR -m u:"www-data":rwX -m u:`whoami`:rwX /var/www/app


phpEnvironmentVariable() {
    PHP_INI_KEY="$1"
    PHP_ENV_NAME="$2"

    if [[ -n "${!PHP_ENV_NAME}" ]]; then
        PHP_ENV_VALUE="${!PHP_ENV_NAME}"

        if [[ 'XDEBUG_REMOTE_HOST' == ${PHP_ENV_NAME} && 'auto' == ${PHP_ENV_VALUE} ]]; then
           PHP_ENV_VALUE=$(/sbin/ip route|awk '/default/ { print $3 }')
        fi

        echo "${PHP_INI_KEY}=\"${PHP_ENV_VALUE}\"" >> /usr/local/etc/php/conf.d/conf.ini
    fi
}

# remote debugger
phpEnvironmentVariable "xdebug.remote_enable"       "XDEBUG_REMOTE_ENABLE"
phpEnvironmentVariable "xdebug.remote_connect_back" "XDEBUG_REMOTE_CONNECT_BACK"
phpEnvironmentVariable "xdebug.remote_autostart"    "XDEBUG_REMOTE_AUTOSTART"
phpEnvironmentVariable "xdebug.remote_host"         "XDEBUG_REMOTE_HOST"
phpEnvironmentVariable "xdebug.remote_port"         "XDEBUG_REMOTE_PORT"

# profiler
phpEnvironmentVariable "xdebug.profiler_enable"               "XDEBUG_PROFILER_ENABLE"
phpEnvironmentVariable "xdebug.profiler_enable_trigger"       "XDEBUG_PROFILER_ENABLE_TRIGGER"
phpEnvironmentVariable "xdebug.profiler_enable_trigger_value" "XDEBUG_PROFILER_ENABLE_TRIGGER_VALUE"
phpEnvironmentVariable "xdebug.profiler_output_dir"           "XDEBUG_PROFILER_OUTPUT_DIR"
phpEnvironmentVariable "xdebug.profiler_output_name"          "XDEBUG_PROFILER_OUTPUT_NAME"


exec "$@"