# Kanbasks

Minimalist tasks manager, [kanban](https://en.wikipedia.org/wiki/Kanban) style inspired.

A running instance is few files that weight **only 32,0 kB**.

![dvdn_kanbasks_preview](https://github.com/dvdn/Kanbasks/assets/7195916/3a51960e-20ee-42c7-a002-13d5a84c7233)

It's a flat file database interaction as a json file is directly modified by your actions, for example ['data.json'](https://github.com/dvdn/kanbasks/blob/master/data/data.json)

By challenge and to keep this project simple, ![no Javascript is used](https://news.ycombinator.com/item?id=12690842).

\> See [demo](http://dvdn.online.fr/kanbasks/)

## Configuration

Clone or download it in your server.

Rename ['config.php.dist'](https://github.com/dvdn/kanbasks/blob/master/inc/config.php.dist) to 'config.php' and adapt it according to your needs.

Job done :)

## Local usage

To run it locally if you don't have PHP installed, you can use [Docker](https://docs.docker.com/) to start an Apache/PHP server in few seconds.

For a very specific reason this project should run with an old PHP version. I recommand using a recent PHP image version.

Download this project, move it in a directory where you put some php projects, for example `/home/zaphod/myprojects/php` (adapt path for your configuration). Then run :

    docker run -d --rm --name php-local -p 8082:80 -v /home/zaphod/myprojects/php:/var/www/html php:5.6-apache

This project will be accessible at : [http://localhost:8082/Kanbasks/](http://localhost:8082/Kanbasks/)

---

Note : as this docker php container runs with `www-data` apache user, to avoid denied permissions problem you should give him rights to `data/data.json` file (or your custom one). For example :

    sudo chown www-data:www-data data/*.json
