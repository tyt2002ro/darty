#!/bin/sh
set -e

echo ${USER_ID}
usermod --uid ${USER_ID} www-data

exec su-exec node "$@"
