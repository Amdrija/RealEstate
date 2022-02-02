FROM nginx
COPY . /var/www/nekretnine/
COPY ./site.conf /etc/nginx/conf.d/default.conf