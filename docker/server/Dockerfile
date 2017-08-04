# from amazonlinux Image
FROM amazonlinux:latest

RUN yum -y update

# Apache
RUN yum -y install httpd24
RUN sed -i -e "s/Listen 80/Listen 8000/" /etc/httpd/conf/httpd.conf
RUN sed -i -e "s/AllowOverride None/AllowOverride All/" /etc/httpd/conf/httpd.conf
RUN sed -i -e "s/Options Indexes FollowSymLinks/Options -Indexes +FollowSymLinks/" /etc/httpd/conf/httpd.conf

# PHP 5.6
RUN yum -y install php56 php56-opcache php56-devel php56-mbstring php56-mcrypt php56-mysqlnd php56-phpunit-PHPUnit php56-pecl-xdebug
RUN sed -i -e "s/;date.timezone *=.*$/date.timezone = UTC/" /etc/php.ini

RUN rm -rf /var/www/html
RUN mkdir -p /var/www/app/web
RUN ln -snf /var/www/app/web /var/www/html

WORKDIR  /var/www/app

ENTRYPOINT /usr/sbin/httpd -D FOREGROUND
EXPOSE 8000
