#!/bin/sh

chmod -R 744 ./public
chmod 777 ./application/logins

path=pwd
crontab -l > file
echo '* * * * * php '.$path.'/phpic-daemon.php >/dev/null 2>&1' >> file
crontab file
rm file
