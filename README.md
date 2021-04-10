# WebbyLab (web application)

Application created for WebbyLab

## Getting Started
This application requires you to create your own movies database. The main feature is adding movies from .docx files, by extracting as archive and parsing .xml file in php. The UI is very clear and simple. Although there are some things, that could be improved so that exceptions were handled.

### Prerequisites
This application is simple, but to run it you need to have php local server and other requirements , so in my case I used [LEMP stack](https://www.digitalocean.com/community/tutorials/what-is-lemp):
* PHP 7.0+
* local web server (nginx in my case)
* MariaDB Database

### Installing (ArchLinux)

1. Install nginx
```
$ sudo pacman -S nginx
$ sudo systemctl enable nginx
$ sudo systemctl start nginx
$ sudo systemctl status nginx
```
(to check if nginx works, go to http://localhost/)

2. Install MariaDB database Engine
```
$ sudo pacman -S mariadb
$ sudo mysql_install_db --user=mysql --basedir=/usr --datadir=/var/lib/mysql
$ sudo systemctl enable mariadb
$ sudo systemctl start mariadb
$ mysql_secure_installation (enter password and press 'Y')
$ mysql -u root -p (enter the mysql root password that you set during  “mysql_secure_installation” command)
```

3) Install PHP & PHP-FPM
```
$ sudo pacman -S php php-fpm
$ sudo systemctl enable php-fpm
$ sudo systemctl start php-fpm
$ sudo systemctl status php-fpm (check if works)
-------------------------------------------------
$ sudo vim /etc/nginx/nginx.conf
add the changes: 
location / {
root   /usr/share/nginx/html;
index  index.html index.htm index.php;
}
location ~ \.php$ {
fastcgi_pass   unix:/var/run/php-fpm/php-fpm.sock;
fastcgi_index  index.php;
root   /usr/share/nginx/html;
include        fastcgi.conf;
}

(save the file and restart both Nginx and PHP-FPM for the changes to come into effect)
$ sudo systemctl restart nginx
$ sudo systemctl restart php-fpm
```

## Running the application

1) upload project folder abd files to your system
2) create and save nginx config (paste text from 'nginx_conf.txt', but change root to your folder root)
3) go to http://webby.localhost/ and try to create records and upload file 'movies.docx'

## Built With

* [LEMP stack](https://www.linuxtechi.com/install-lemp-stack-on-arch-linux/ - a collection of open-source software
* [Bootstrap 4](https://getbootstrap.com/docs/4.0/getting-started/introduction/) - a framework for building responsive, mobile-first sites

## Author

**Daniel Popov** - *Junior PHP Developer* - [Lewis1727](https://github.com/Lewis1727)

