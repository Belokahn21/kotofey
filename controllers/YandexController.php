<?php

namespace app\controllers;


use app\models\entity\Product;
use yii\web\Controller;

class YandexController extends Controller
{
    public function actionExport()
    {
        \Yii::$app->response->format = \yii\web\Response::FORMAT_XML;

        $dom = new \DOMDocument("1.0", "UTF-8");
        $yml_catalog = $dom->createElement('yml_catalog');
        $shop = $dom->createElement('shop');
        $offers = $dom->createElement('offers');

        $shop->appendChild($dom->createElement('name', 'Зоомагазин Котофей'));
        $shop->appendChild($dom->createElement('company', 'ИП Васин К.В.'));
        $shop->appendChild($dom->createElement('url', sprintf('https://%s/', $_SERVER['SERVER_NAME'])));

        $currencies = $dom->createElement('currencies');

        $currency = $dom->createElement('currency');
        $currency->setAttribute('id', 'RUB');
        $currency->setAttribute('rate', '1');

        $currencies->appendChild($currency);
        $shop->appendChild($currencies);

        $shop->appendChild($dom->createElement('url', sprintf('https://%s/', $_SERVER['SERVER_NAME'])));

        $dom->appendChild($yml_catalog);

        $yml_catalog->setAttribute('date', date("Y-m-d H:i"));
        $yml_catalog->appendChild($shop);

        $shop->appendChild($offers);

        /* @var $product Product */
        foreach (Product::find()->all() as $product) {

            $offer = $dom->createElement('offer');
            $offer->setAttribute('id', $product->id);

//            $name = $dom->createElement('name', htmlspecialchars($product->display));
//            $offer->appendChild($name);

            $currencyId = $dom->createElement('currencyId', "RUB");
            $offer->appendChild($currencyId);

//            $url = $dom->createElement('vendor', sprintf("https://%s%s", $_SERVER['SERVER_NAME'], $product->detail));
//            $offer->appendChild($url);

            $price = $dom->createElement('price', $product->price);
            $offer->appendChild($price);

//            $picture = $dom->createElement('picture', sprintf("https://%s/upload/%s", $_SERVER['SERVER_NAME'], $product->image));
//            $offer->appendChild($picture);

//            $categoryId = $dom->createElement('categoryId', $product->category_id);
//            $offer->appendChild($categoryId);

//            if (!empty($product->description)) {
//
//                $description = $dom->createElement('description', htmlspecialchars($product->description));
//                $offer->appendChild($description);
//
//            }

            $delivery = $dom->createElement('delivery', "true");
            $offer->appendChild($delivery);

//            $pickup = $dom->createElement('pickup', "true");
//            $offer->appendChild($pickup);

            $offers->appendChild($offer);
        }
        echo $dom->saveXML();
//        $dom->save(\Yii::getAlias('@app') . "/web/export/yml.yml");
    }
}