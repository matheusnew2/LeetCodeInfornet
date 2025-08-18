#!/bin/sh
cd /var/www/html && npm install &&  npm run dev --host &
nginx -g 'daemon off;'