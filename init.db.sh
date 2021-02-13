#!/bin/bash
mysql -u root -e "CREATE DATABASE chip_coffee"
mysql -u root chip_coffee < /tmp/chip_coffee.sql