#!/bin/sh

chmod -R 777 ./public/users
#write out current crontab
crontab -l > mycron
#echo new cron into cron file
echo "* * * * * php ./CreateImages.php" >> mycron
#install new cron file
crontab mycron
rm mycron
