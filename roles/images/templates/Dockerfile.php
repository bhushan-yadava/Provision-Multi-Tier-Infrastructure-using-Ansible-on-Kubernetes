FROM ubuntu:22.04
RUN apt-get update && apt-get install -y apache2 php libapache2-mod-php php-mysql && rm -rf /var/lib/apt/lists/*
COPY index.php /var/www/html/
EXPOSE 80
CMD ["apachectl", "-D", "FOREGROUND"]
