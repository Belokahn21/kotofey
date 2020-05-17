build:
	rm -rf tmp/browser_ext/catalog/dist && cd tmp/browser_ext/catalog && npm run-script build

gulp-build:
	rm -rf markup/build/ && cd markup && gulp build

push:
	git add . && git commit -m "update" && git push

init-dev:
	cp application/web/index.dev.php application/web/index.php

init-prod:
	cp application/web/index.prod.php application/web/index.php

migrate:
	cd application && php yii migrate