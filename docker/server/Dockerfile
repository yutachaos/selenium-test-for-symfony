# from CentOS7 Image
FROM centos:centos7

USER root
# repository setting
RUN yum -y install epel-release
RUN rpm -Uvh http://rpms.famillecollet.com/enterprise/remi-release-7.rpm
RUN yum update

# Apache
RUN yum -y install httpd
RUN sed -i -e "s/Listen 80/Listen 8000/" /etc/httpd/conf/httpd.conf
RUN sed -i -e "s/AllowOverride None/AllowOverride All/" /etc/httpd/conf/httpd.conf
RUN sed -i -e "s/Options Indexes FollowSymLinks/Options -Indexes +FollowSymLinks/" /etc/httpd/conf/httpd.conf

# PHP 5.6
RUN yum -y install --enablerepo=remi --enablerepo=remi-php56 php php-opcache php-devel php-mbstring php-mcrypt php-mysqlnd php-phpunit-PHPUnit php-pecl-xdebug php-pecl-xhprof
RUN sed -i -e "s/;date.timezone *=.*$/date.timezone = UTC/" /etc/php.ini

RUN rm -rf /var/www/html
RUN mkdir -p /var/www/app/web
RUN ln -snf /var/www/app/web /var/www/html

ENTRYPOINT /usr/sbin/httpd -D FOREGROUND
EXPOSE 8000
