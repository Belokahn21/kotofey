rebuild:
	rm -rf tmp/browser_ext/catalog/dist && cd tmp/browser_ext/catalog && npm run-script build

push:
	git add . && git commit -m "update" && git push