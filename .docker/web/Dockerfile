FROM nginx:1.23
ARG uid=1000
RUN set -eux; \
    \
    usermod -u "${uid}" www-data;
