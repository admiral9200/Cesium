FROM ubuntu:latest

ENV DEBIAN_FRONTEND=noninteractive

RUN apt update -y
RUN apt install -y apache2 
RUN apt install -y php 
RUN apt install -y php-dev 
RUN apt install -y php-mysql 
RUN apt install -y libapache2-mod-php 
RUN apt install -y php-curl 
RUN apt install -y php-json 
RUN apt install -y php-common 
RUN apt install -y php-mbstring 
RUN apt install -y composer
RUN rm -rfv /etc/apache2/sites-enabled/*.conf
RUN ln -s /etc/apache2/sites-available/slc.conf /etc/apache2/sites-enabled/slc.conf

CMD ["apachectl","-D","FOREGROUND"]
RUN a2enmod rewrite

EXPOSE 80