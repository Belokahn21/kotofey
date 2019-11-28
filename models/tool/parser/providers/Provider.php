<?php

namespace app\models\tool\parser\providers;


use app\models\tool\Debug;
use app\models\tool\parser\CatalogInfo;

class Provider implements ProviderInterface
{
	public function info($url)
	{
		$page = file_get_contents($url);

		$dom = new \DOMDocument();
		$dom->loadHTML($page, LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD | LIBXML_NOERROR | LIBXML_NOWARNING);

		$xpath = new \DOMXPath($dom);
		$price = $xpath->query('//div[@class="lead"]')->item(0)->nodeValue;

		Debug::p(html_entity_decode($price));

		$product = new CatalogInfo();
		$product->name = $dom->getElementsByTagName('h2')->item(0)->nodeValue;
//		$product->purchase = $dom->пуе
		$product->price = $dom->getElementsByTagName('h2')->item(0)->nodeValue;


		return $product;
	}
}