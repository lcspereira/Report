FROM ubuntu:focal

COPY ./ /var/www/html/

RUN     apt-get update \
        && ln -sf /usr/share/zoneinfo/Brazil/East /etc/localtime \
        && apt-get install -y \
                php7.4 \
                php7.4-ds \
                nodejs \
                npm \
                composer \
        && apt-get clean \
        && rm -rf /var/lib/apt/lists/* /tmp/* /var/tmp/* \
        && cd /var/www/html/ \
        && composer install \
        && composer dump-autoload \
        && npm install -d \
        && npx webpack -c webpack.js

EXPOSE 8000
ENTRYPOINT ["php7.4", "-S", "0.0.0.0:8000", "-t", "public/"]