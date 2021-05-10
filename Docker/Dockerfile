FROM ubuntu:focal

COPY ./ /var/www/html/

RUN     apt-get update \
        && ln -sf /usr/share/zoneinfo/Brazil/East /etc/localtime \
        && apt-get install -y \
                php7.4 \
                php7.4-ds \
                php7.4-xml \
                nodejs \
                npm \
                composer \
        && apt-get clean \
        && rm -rf /var/lib/apt/lists/* /tmp/* /var/tmp/*

EXPOSE 8000
CMD [ "./run.sh" ]