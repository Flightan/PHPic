#!/bin/sh

chmod -R 755 ./public
chmod 777 ./application/logins

path=`pwd`

php phpic-daemon.php
{ echo "* * * * * /usr/bin/php $path/phpic-daemon.php"; } | crontab -
