#!/bin/bash
sudo chown work:work /run/php-fpm/www.sock 
sudo nginx -s reload -c /home/work/tp-blog/nginx/nginx.conf
