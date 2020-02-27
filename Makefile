rebuild:
	rm -rf tmp/browser_ext/catalog/dist && cd tmp/browser_ext/catalog && npm run-script build

commit:
	git add . && git commit -m "update" && git push