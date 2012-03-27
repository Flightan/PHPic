#!/bin/bash

chmod -R 755 ./public
chmod 555 ./application/logins

#Execution du script instantane
php phpic-daemon.php

#Utilisation de crontab pour gere l'appel toute les minutes
{ echo "* * * * * php 'phpic-daemon.php'"; } | crontab -
