#!/bin/sh

chmod -R 755 ./public
chmod 777 ./application/logins

path=`pwd`

{ echo "* * * * * php $path/phpic-daemon.php"; } | crontab -
