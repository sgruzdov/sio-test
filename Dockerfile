FROM php:8.3-cli-alpine

RUN apk add --no-cache git zip bash mysql-client

RUN docker-php-ext-install mysqli
RUN docker-php-ext-install pdo_mysql

# Setup php app user
ARG USER_ID=1000
RUN adduser -u ${USER_ID} -D -H app
USER app

COPY --chown=app . /home/sio-test/htdocs
WORKDIR /home/sio-test/htdocs

EXPOSE 8337

CMD ["php", "-S", "0.0.0.0:8337", "-t", "public"]