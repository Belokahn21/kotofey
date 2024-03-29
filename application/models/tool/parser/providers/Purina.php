<?php

namespace app\models\tool\parser\providers;


use app\modules\catalog\models\entity\Product;
use app\models\tool\parser\CatalogInfo;

class Purina implements ProviderInterface
{
    public function info($url)
    {
        if ($curl = curl_init()) {

            $name = null;
            $price = null;
            $desciption = null;
            $weight = null;

//            $url = 'https://shop.purina.ru/catalogsearch/result/?q=' . $parts[0];

            curl_setopt($curl, CURLOPT_URL, $url);
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($curl, CURLOPT_FOLLOWLOCATION, true);
            $html = curl_exec($curl);
            curl_close($curl);

            $dom = new \DOMDocument();
            $dom->loadHTML($html, LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD | LIBXML_NOERROR | LIBXML_NOWARNING);
            $xpath = new \DOMXPath($dom);

//            $price = ceil($parts[2]);
            $name = $xpath->query('//h1[@class="page-title hidden-xs hidden-sm js-name"]')->item(0)->nodeValue;
            $desciption = $xpath->query('//div[@class="short-descr"]')->item(0)->nodeValue;
//            $code = $xpath->query('//div[@class="sku"]/span')->item(0)->nodeValue;

            $nameParts = explode(', ', $name);

            $weight = $nameParts[count($nameParts) - 1];
            $weight = str_replace(',', '.', $weight);
            $weight = str_replace('кг', '', $weight);
            $weight = str_replace(' ', '', $weight);


            $product = new CatalogInfo();
            $product->name = $name;
//            $product->purchase = $price;
//            $product->price = $product->purchase + ceil(($product->purchase * (15 / 100)));
            $product->count = 0;
            $product->description = $desciption;
            $product->vitrine = 1;
            $product->status_id = Product::STATUS_ACTIVE;
//            $product->barcode = $code;
            $product->vendor_id = 1;
//            $product->weight = $weight;
//            $product->country = 51;
//            $product->model = 6;

            return $product;
        }
    }
}