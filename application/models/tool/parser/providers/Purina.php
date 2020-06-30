<?php

namespace app\models\tool\parser\providers;


use app\modules\site_settings\models\entity\SiteSettings;
use app\modules\vendors\models\entity\Vendor;
use app\models\tool\Debug;
use app\models\tool\parser\CatalogInfo;
use app\models\tool\parser\page\Page;
use app\models\tool\parser\page\SimplePage;

class Purina extends Provider
{
    public function info($url)
    {
        $parts = explode('	', $url);
        if ($curl = curl_init()) {

            $name = null;
            $price = null;
            $desciption = null;
            $weight = null;

            $url = 'https://shop.purina.ru/catalogsearch/result/?q=' . $parts[0];

            curl_setopt($curl, CURLOPT_URL, $url);
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($curl, CURLOPT_FOLLOWLOCATION, true);
            $html = curl_exec($curl);
            curl_close($curl);

            $dom = new \DOMDocument();
            $dom->loadHTML($html, LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD | LIBXML_NOERROR | LIBXML_NOWARNING);
            $xpath = new \DOMXPath($dom);

            $price = ceil($parts[2]);
            $name = $xpath->query('//h1[@class="page-title hidden-xs hidden-sm js-name"]')->item(0)->nodeValue;
            $desciption = $xpath->query('//div[@class="short-descr"]')->item(0)->nodeValue;
            $code = $parts[0];

            $nameParts = explode(', ', $name);

            $weight = $nameParts[count($nameParts) - 1];
            $weight = str_replace(',', '.', $weight);
            $weight = str_replace('кг', '', $weight);
            $weight = str_replace(' ', '', $weight);


            $product = new CatalogInfo();
            $product->name = $name;
            $product->purchase = $price;
            $product->price = $price;
//            $product->price = $product->purchase + ceil(($product->purchase * (SiteSettings::findByCode('saleup')->value / 100)));
            $product->count = 0;
            $product->description = $desciption;
            $product->vitrine = 1;
            $product->active = 1;
            $product->code = $code;
            $product->vendor_id = 1;
            $product->weight = $weight;
            $product->country = 51;
            $product->model = 6;

            return $product;

        }
    }
}