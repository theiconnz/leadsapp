FROM httpd:latest

ARG PROJECT_DOMAIN
ARG PROJECT_ROOT

RUN apt-get update && apt-get install -y vim curl libxml2-dev

RUN apt-get update && apt-get install -y vim mcrypt varnish

COPY httpd.conf /usr/local/apache2/conf/httpd.conf
COPY httpd-vhosts.conf /usr/local/apache2/conf/extra/httpd-vhosts.conf

RUN sed -i 's#__PROJECT_DOMAIN__#'"${PROJECT_DOMAIN}"'#g' /usr/local/apache2/conf/httpd.conf
RUN sed -i 's#__PROJECT_ROOT__#'"${PROJECT_ROOT}"'#g' /usr/local/apache2/conf/httpd.conf

#RUN echo "upstream php-upstream { server php:9000; }" > /etc/nginx/conf.d/upstream.conf
