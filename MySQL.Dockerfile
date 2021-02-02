FROM mysql:latest

ENV MYSQL_ALLOW_EMPTY_PASSWORD='yes'
ENV MYSQL_ROOT_PASSWORD='root'

RUN /bin/bash -c 'mysql -u root -p${MYSQL_ROOT_PASSWORD} -e "CREATE DATABASE chip_coffee"'
RUN /bin/bash -c 'mysql -u root -p${MYSQL_ROOT_PASSWORD} -D "chip_coffee" < chip_coffee.sql'					

EXPOSE 3306