ARG docker_registry=docker.io
FROM ${docker_registry}/alpine:3.14

RUN apk add --update nginx ca-certificates shadow su-exec brotli nginx-mod-http-brotli
RUN rm -rf /var/cache/apk/* && rm -rf /tmp/*

COPY nginx.conf /etc/nginx/
COPY darty2.conf /etc/nginx/conf.d/default.conf
COPY upstream.conf /etc/nginx/conf.d/

COPY entrypoint.sh /usr/local/bin/entrypoint.sh

RUN mkdir -p /etc/nginx/ssl/
COPY ssl/nginx.crt /etc/nginx/ssl/
COPY ssl/nginx.key /etc/nginx/ssl/

RUN mkdir -p /tmp/nginx/cache/

RUN adduser -D -g '' -G www-data www-data

ENTRYPOINT ["/usr/local/bin/entrypoint.sh"]
CMD ["nginx"]

EXPOSE 80 443
