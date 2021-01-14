build:
	rm -rf tmp/browser_ext/catalog/dist && cd tmp/browser_ext/catalog && npm run-script build

gulp-build:
	rm -rf markup/build/ && rm -rf application/web/css/ && rm -rf application/web/js/ && rm -rf application/web/images/ && cd markup && gulp build

push:
	git add . && git commit -m "update" && git push

console:
	cd application && php yii console/run

pull:
	git pull

init-dev:
	cp application/web/index.dev.php application/web/index.php

init-prod:
	cp application/web/index.prod.php application/web/index.php

init-test:
	cp application/web/index.test.php application/web/index.php

composer-install:
	cd application && composer install

composer-update:
	cd application && composer update

cache:
	rm -rf application/runtime/cache/

create-cache-folder:
	mkdir application/runtime/cache/

chmod-cache:
	chmod 777 -R application/runtime/cache/

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

deploy: pull init-dev cache migrate
deploy-prod: pull init-prod migrate
deploy-test: pull init-test migrate

