<?php

namespace app\models\tool\parser\providers;


use app\models\tool\Debug;
use app\models\tool\parser\page\Page;
use app\models\tool\parser\page\SimplePage;

class Purina extends Provider
{
    public function info($url)
    {
        $page = new SimplePage();
        $html = $page->content($url);

        $dom = new \DOMDocument();
        $dom->loadHTML($html, LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD | LIBXML_NOERROR | LIBXML_NOWARNING);

        $xpath = new \DOMXPath($dom);

        Debug::p($xpath);
        exit();
        $price = $xpath->query('//div[@class="lead"]')->item(0)->nodeValue;

//		Debug::printFile($html);

//		$price = explode(' ', $price);
//		if (is_array($price)) {
//			preg_match('/(\d+)р./', $price[1], $price);
//			$price = $price[1];
//		}
//
//		$weight = $dom->getElementsByTagName('strong')->item(2)->nodeValue;
//		$weight = explode(" ", $weight);
//
//		switch ($weight[1]) {
//			case "гр.":
//				$weight = $weight[0] / 1000;
//				break;
//			default:
//				$weight = $weight[0];
//				break;
//		}
//
//
//		$product = new CatalogInfo();
//		$product->name = $dom->getElementsByTagName('h2')->item(0)->nodeValue;
//		$product->purchase = $price;
//		$product->price = $product->purchase + ceil(($product->purchase * (SiteSettings::findByCode('saleup')->value / 100)));
//		$product->count = 1;
//		$product->description = $xpath->query('//div[@class="desc"]')->item(0)->nodeValue;
//		$product->vitrine = 1;
//		$product->active = 1;
//		$product->code = $dom->getElementsByTagName('strong')->item(1)->nodeValue;
//		$product->weight = $weight;


        return $product;
    }
}