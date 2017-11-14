#!/bin/sh

set -e
host="$1"
shift
user="$1"
shift
password="$1"

cd /var/www/app

echo "Waiting for mysql"
until mysql -h"$host" -u"$user" -p"$password" mydb < database/sql/init/mydb.sql &> /dev/null
do
        sleep 1
        echo "Waiting for mysql"
done

until mysql -h"$host" -u"$user" -p"$password" mydb < database/sql/alter.sql &> /dev/null
do
        sleep 1
        echo "Waiting for mysql"
done

echo "MySQL is up - executing command"

php artisan serve --port=8080