FROM php:8.3-cli as builder

RUN apt update && apt install -y unzip && apt clean

ADD --chmod=0755 https://github.com/mlocati/docker-php-extension-installer/releases/latest/download/install-php-extensions /usr/local/bin/
RUN install-php-extensions gd phar apcu pdo_mysql mysqli zip
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

WORKDIR /app
COPY . ./
RUN touch storage/database.sqlite
# RUN DB_CONNECTION=${DB_CONNECTION} composer install --no-dev --no-interaction --no-progress
RUN composer install --no-dev --no-interaction --no-progress && composer dump-autoload

FROM node:18.20.7-bookworm as node_builder
# RUN apt update && apt install -y build-essential
# RUN curl -fsSL https://pyenv.run | bash && /root/.pyenv/bin/pyenv install 2.7.18 && ln -s /root/.pyenv/versions/2.7.18/bin/python /usr/bin/python2
WORKDIR /app
COPY package.json package-lock.json webpack.mix.js ./
COPY resources/ ./resources/
COPY public/ ./public/
RUN npm install && npm run prod

FROM php:8.4-fpm
COPY --from=builder /usr/local/bin/install-php-extensions /usr/local/bin/install-php-extensions
RUN apt update && apt install -y nginx sendmail && apt clean
RUN install-php-extensions gd phar apcu pdo_mysql mysqli zip
RUN mkdir -p /var/run/php && \
    chown -R www-data:www-data /var/run/php && \
    chmod 775 /var/run/php && \
    echo "[www]\nuser = www-data\ngroup = www-data\nlisten.owner = www-data\nlisten.group = www-data\nlisten = /var/run/php/php7.4-fpm.sock\npm = dynamic\npm.max_children = 5\npm.start_servers = 2\npm.min_spare_servers = 1\npm.max_spare_servers = 3" > /usr/local/etc/php-fpm.d/zz-docker.conf
RUN echo "max_execution_time = 300" >> /usr/local/etc/php/php.ini && \
    echo "memory_limit = 512M" >> /usr/local/etc/php/php.ini && \
    echo "max_input_vars = 3000" >> /usr/local/etc/php/php.ini && \
    echo "post_max_size = 100M" >> /usr/local/etc/php/php.ini && \
    echo "upload_max_filesize = 100M" >> /usr/local/etc/php/php.ini && \
    echo "max_file_uploads = 50" >> /usr/local/etc/php/php.ini



RUN mkdir -p /var/lib/nginx/body /var/lib/nginx/proxy \
    && chown -R www-data:www-data /var/lib/nginx \
    && chmod -R 755 /var/lib/nginx \
    && sed -i "s/pid\s.*$/pid \/tmp\/nginx.pid;/" /etc/nginx/nginx.conf

# RUN adduser --uid 1000 user
WORKDIR /app
COPY --from=builder /app/vendor ./vendor
COPY --from=node_builder /app/public/js ./public/js
COPY --from=node_builder /app/public/css ./public/css
COPY --from=builder /app/storage/database.sqlite ./storage/database.sqlite
COPY . .
COPY docker/nginx.conf /etc/nginx/sites-available/default
COPY docker/start.sh /usr/local/bin/start
RUN chown -R www-data:www-data /app/storage /app/bootstrap/cache && \
    php artisan storage:link
RUN ln -sf /etc/nginx/sites-available/default /etc/nginx/sites-enabled/default && chmod +x /usr/local/bin/start
USER www-data

EXPOSE 80
CMD ["start"]
