#!/bin/sh

chmod -R 777 ./public

path=pwd
crontab -l > file
echo '* * * * * php '.$path.'/phpic-daemon.php >/dev/null 2>&1' >> file
crontab file
rm file
