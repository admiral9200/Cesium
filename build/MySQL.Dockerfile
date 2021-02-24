FROM mysql:latest

ADD init.db.sh ./init.db.sh
ADD chip_coffee.sql /tmp/chip_coffee.sql		

EXPOSE 3306