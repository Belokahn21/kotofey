build:
	rm -rf tmp/browser_ext/catalog/dist && cd tmp/browser_ext/catalog && npm run-script build

webpack: webpack-build webpack-copy
webpack-backend: webpack-build-backend webpack-copy-backend
webpack-mail: webpack-build-mail

webpack-copy:
	cp -R markup/frontend/build/js application/web
	cp -R markup/frontend/build/css application/web
	cp -R markup/frontend/build/assets/images application/web

webpack-copy-backend:
	cp -R markup/backend/build/js application/web
	cp -R markup/backend/build/css application/web
	cp -R markup/backend/build/assets/images application/web

webpack-build:
	cd markup/frontend && npm run build

webpack-build-backend:
	cd markup/backend && npm run build

webpack-build-mail:
	cd markup/mails && npm run build

gulp-build:
	rm -rf markup/build/ && rm -rf application/web/css/ && rm -rf application/web/js/ && rm -rf application/web/images/ && cd markup && gulp build

push:
	git add . && git commit -m "update" && git push

console:
	cd application && php yii console/run

admission:
	cd application && php yii admission/send

pull:
	git pull

config-dev:
	cp application/web/index.dev.php application/web/index.php
	cp application/config/params.local.php application/config/params.php
	cp application/config/main.db.php application/config/db.php

config-prod:
	cp application/web/index.prod.php application/web/index.php
	cp application/config/params.prod.php application/config/params.php
	cp application/config/main.db.php application/config/db.php

config-test:
	cp application/web/index.test.php application/web/index.php

config-docker:
	cp application/web/index.dev.php application/web/index.php
	cp application/config/params.local.php application/config/params.php
	cp application/config/docker.db.php application/config/db.php

composer-install:
	rm application/composer.lock && cd application && composer install

composer-update:
	cd application && composer update

cache:
	rm -rf application/runtime/cache/ && mkdir application/runtime/cache && chmod -R 0777 application/runtime/cache

create-cache-folder:
	mkdir application/runtime/cache/

chmod-cache:
	chmod 777 -R application/runtime/cache/

assets:
	[ ! -d "application/web/assets" ] && mkdir application/web/assets

promo:
	cd application && php yii promotion/group-notify

elastic-index:
	cd application && php yii elastic/index

elastic:
	docker run -p 9200:9200 -p 9300:9300 -e "discovery.type=single-node" docker.elastic.co/elasticsearch/elasticsearch:7.13.3

docker-build:
	docker-compose build

docker-up:
	docker-compose up -d

docker: config-docker docker-build docker-up

migrate:
	cd application && php yii migrate --interactive=0
	cd application && php yii migrate --migrationPath=@app/modules/user/install/migrations --interactive=0
	cd application && php yii migrate --migrationPath=@app/modules/geo/install/migrations --interactive=0
	cd application && php yii migrate --migrationPath=@app/modules/order/install/migrations --interactive=0
	cd application && php yii migrate --migrationPath=@app/modules/delivery/install/migrations --interactive=0
	cd application && php yii migrate --migrationPath=@app/modules/payment/install/migrations --interactive=0
	cd application && php yii migrate --migrationPath=@app/modules/promocode/install/migrations --interactive=0
	cd application && php yii migrate --migrationPath=@app/modules/catalog/install/migrations --interactive=0
	cd application && php yii migrate --migrationPath=@app/modules/vendors/install/migrations --interactive=0
	cd application && php yii migrate --migrationPath=@app/modules/logger/install/migrations --interactive=0
	cd application && php yii migrate --migrationPath=@app/modules/basket/install/migrations --interactive=0
	cd application && php yii migrate --migrationPath=@app/modules/promotion/install/migrations --interactive=0
	cd application && php yii migrate --migrationPath=@app/modules/media/install/migrations --interactive=0
	cd application && php yii migrate --migrationPath=@app/modules/cdek/install/migrations --interactive=0
	cd application && php yii migrate --migrationPath=@app/modules/news/install/migrations --interactive=0
	cd application && php yii migrate --migrationPath=@app/modules/support/install/migrations --interactive=0
	cd application && php yii migrate --migrationPath=@app/modules/stock/install/migrations --interactive=0
	cd application && php yii migrate --migrationPath=@app/modules/todo/install/migrations --interactive=0
	cd application && php yii migrate --migrationPath=@app/modules/vacancy/install/migrations --interactive=0
	cd application && php yii migrate --migrationPath=@app/modules/content/install/migrations --interactive=0
	cd application && php yii migrate --migrationPath=@app/modules/subscribe/install/migrations --interactive=0
	cd application && php yii migrate --migrationPath=@app/modules/bonus/install/migrations --interactive=0
	cd application && php yii migrate --migrationPath=@app/modules/short_link/install/migrations --interactive=0
	cd application && php yii migrate --migrationPath=@app/modules/pets/install/migrations --interactive=0
	cd application && php yii migrate --migrationPath=@app/modules/site/install/migrations --interactive=0
	cd application && php yii migrate --migrationPath=@app/modules/menu/install/migrations --interactive=0
	cd application && php yii migrate --migrationPath=@app/modules/acquiring/install/migrations --interactive=0
	cd application && php yii migrate --migrationPath=@app/modules/reviews/install/migrations --interactive=0
	cd application && php yii migrate --migrationPath=@app/modules/mailer/install/migrations --interactive=0
	cd application && php yii migrate --migrationPath=@app/modules/search/install/migrations --interactive=0
	cd application && php yii migrate --migrationPath=@app/modules/marketplace/install/migrations --interactive=0

deploy-local: pull config-dev cache migrate assets
deploy: pull config-prod migrate cache assets
deploy-test: pull config-test migrate assets
deploy-docker: pull config-docker migrate assets

