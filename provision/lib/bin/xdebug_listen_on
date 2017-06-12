#!/bin/bash
sudo sh -c  "grep -q -F 'xdebug.remote_autostart = 1' /etc/php/7.1/mods-available/xdebug.ini || echo 'xdebug.remote_autostart = 1' >> /etc/php/7.1/mods-available/xdebug.ini"
sudo service php7.1-fpm restart
