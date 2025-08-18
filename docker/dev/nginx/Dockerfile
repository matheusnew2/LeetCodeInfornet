FROM nginx:stable-alpine
WORKDIR /var/www/html/
COPY ./docker/dev/nginx/nginx.conf /etc/nginx/nginx.conf
 
RUN apk  add \
    nodejs-current \
    npm



COPY ./vue/package.json ./vue/package-lock.json ./
RUN npm ci --omit=dev && npm cache clean --force
COPY . .
EXPOSE 80 5173


COPY ./docker/dev/nginx/start-dev.sh /start.sh
RUN chmod +x /start.sh
CMD ["/start.sh"]


 