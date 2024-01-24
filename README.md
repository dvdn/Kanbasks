# Kanbasks

Minimalist tasks manager, [kanban](https://en.wikipedia.org/wiki/Kanban) style inspired.

A running instance is few files that weight only 32,0 kB.

![dvdn_kanbasks_preview](https://github.com/dvdn/Kanbasks/assets/7195916/90c7bf8f-2b0c-43af-86bc-0a56079deab6)

It's a flat file database interaction as a json file is directly modified by your actions, for example ['data.json'](https://github.com/dvdn/kanbasks/blob/master/data/data.json)

By challenge and to keep this project simple, no Javascript is used.

\> See [demo](http://dvdn.online.fr/kanbasks/)

## Configuration

Clone or download it in your server.

Rename ['config.php.dist'](https://github.com/dvdn/kanbasks/blob/master/inc/config.php.dist) to 'config.php' and adapt it according to your needs.

Job done :)

## Local usage

To run it locally if you don't have PHP installed, you can use [Docker](https://docs.docker.com/) to start an Apache/PHP server in few seconds.

I recommand using a recent PHP image version. For very specific reason this projet uses an older version.

Download this project, move it in a directory where you put some php projects, for example `/home/zaphod/myprojects/php` (adapt path for your configuration). Then run :

    docker run -d --rm --name php-local -p 8082:80 -v /home/zaphod/myprojects/php:/var/www/html php:5.6-apache

This project will be accessible at : [http://localhost:8082/Kanbasks/](http://localhost:8082/Kanbasks/)

---

Note : if you encounter denied permission problem, as docker php container runs with `www-data` apache user, you should give him rights to `data/data.json` file. For example :

    sudo chown www-data:www-data data/data.json
