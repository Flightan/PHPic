#!/bin/sh

chmod -R 777 ./public

crontab -l > file
echo '* * * * * php ./phpic-daemon.php >/dev/null 2>&1' >> file
crontab file
rm file
