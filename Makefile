build:
	rm -rf tmp/browser_ext/catalog/dist && cd tmp/browser_ext/catalog && npm run-script build

gulp-build:
	rm -rf markup/build/ && cd markup && gulp build

push:
	git add . && git commit -m "update" && git push