<?php

namespace app\models\tool\parser\providers;


use app\models\entity\SiteSettings;
use app\models\tool\Debug;
use app\models\tool\parser\CatalogInfo;
use app\models\tool\parser\page\Page;

class Provider implements ProviderInterface
{
    public function info($url)
    {

        $page = new Page('http://www.sat-altai.ru/', [
            'login' => 'popugau@gmail.com',
            'password' => '123qweR%',
        ]);
        $html = $page->content($url);

        $dom = new \DOMDocument();
        $dom->loadHTML($html, LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD | LIBXML_NOERROR | LIBXML_NOWARNING);

        $xpath = new \DOMXPath($dom);
        $price = $xpath->query('//div[@class="lead"]')->item(0)->nodeValue;

        $price = explode(' ', $price);
        if (is_array($price)) {
            preg_match('/(\d+)р./', $price[1], $price);
            $price = $price[1];
        }

        $product = new CatalogInfo();
        $product->name = $dom->getElementsByTagName('h2')->item(0)->nodeValue;
        $product->purchase = $price;
        $product->price = $product->purchase + ceil(($product->purchase * (SiteSettings::findByCode('saleup')->value / 100)));
        $product->count = 1;
        $product->description = '';


        return $product;
    }
}