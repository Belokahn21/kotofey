<p align="center">
    <a href="https://github.com/yiisoft" target="_blank">
        <img src="https://kotofey.store/upload/images/_logo.png" height="100px" style="border-radius:50%;">
    </a>
    <h1 align="center">Зоомагазин Котофей</h1>
    <br>
</p>
<!-- https://www.figma.com/file/ML5jkKLLnes1BHC11dZwVj/izbastroev -->
Репозиторий проекта <a href="https://kotofey.store/" target="_blank">интернет-магазина Котофей</a>. <br>
Что под внутри?: <br>
Yii2 (Basic)<br>
Node v12.18.4<br>
Npm v6.14.6<br>
React<br>
v1: Gulp, Babel, Sass, Pug<br>
v2: webpack, pug, react
MySQL<br><br>
Используется:<br>
 - Интеграция с TinyPNG API (free 500/mounth)<br>
 - Интеграция с Cloudinary (CDN)<br>
 - Интеграция с OFD.RU (Ferma)<br>
 - Интеграция с Почта России (API расчётов)<br>
 - Elasticsearch<br>

Crontab
0 * * * * /usr/bin/php /var/www/kotofey.store/application/yii sibagro/update
0 */1 * * * /usr/bin/php /var/www/kotofey.store/application/yii sibagro/clean-product-sync
0 * * * * /usr/bin/php /var/www/kotofey.store/application/yii backup/save
0 8 * * * /usr/bin/php /var/www/kotofey.store/application/yii content/clean
10 10 25 * * /usr/bin/php /var/www/kotofey.store/application/yii instagram/rebase
0 * * * * /usr/bin/php /var/www/kotofey.store/application/yii admission/send
0 10 * * * /usr/bin/php /var/www/kotofey.store/application/yii promotion/group-notify
0 10 * */1 * /usr/bin/php /var/www/kotofey.store/application/yii sender/remember