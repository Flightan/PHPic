#!/bin/bash

chmod -R 755 ./public
chmod 777 ./application/logins
mkdir ./users

path=`pwd`
{ echo "* * * * * /usr/bin/php $path/phpic-daemon.php"; } | crontab -
