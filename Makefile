build:
	rm -rf tmp/browser_ext/catalog/dist && cd tmp/browser_ext/catalog && npm run-script build

gulp-build:
	rm -rf markup/build/ && rm -rf application/web/css/ && rm -rf application/web/js/ && cd markup && gulp build

push:
	git add . && git commit -m "update" && git push

console:
	cd application && php yii console/run

pull:
	git pull

init-dev:
	cp application/web/index.dev.php application/web/index.php
	cp application/config/web.dev.php application/config/web.php

init-prod:
	cp application/web/index.prod.php application/web/index.php
	cp application/config/web.prod.php application/config/web.php

composer-install:
	cd application && composer install

composer-update:
	cd application && composer update

migrate:
	cd application && php yii migrate --interactive=0
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

deploy: pull init-dev migrate
deploy-prod: pull init-prod migrate