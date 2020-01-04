<?php

namespace app\controllers;

use app\models\entity\Category;
use app\models\tool\Debug;
use Yii;
use app\models\entity\Product;
use yii\web\Controller;

class YandexController extends Controller
{
    public $layout = false;

    public function actionExport()
    {
        $dom = new \DOMDocument("1.0", "UTF-8");
        $yml_catalog = $dom->createElement('yml_catalog');
        $shop = $dom->createElement('shop');
        $offers = $dom->createElement('offers');
        $dom->appendChild($yml_catalog);

        $yml_catalog->setAttribute('date', date("Y-m-d H:i"));

        $shop->appendChild($dom->createElement('name', 'Зоомагазин Котофей'));
        $shop->appendChild($dom->createElement('company', 'ИП Васин К.В.'));
        $shop->appendChild($dom->createElement('email', 'info@kotofey.store'));

        $categoryModel = new Category();
        $categories = $dom->createElement('categories');
        $categoryModel->loadYml($dom, $categories);
        $shop->appendChild($categories);


        $currencies = $dom->createElement('currencies');
        $currency_rub = $dom->createElement('currency');
        $currency_rub->setAttribute('id', 'RUR');
        $currency_rub->setAttribute('rate', '1');
        $currencies->appendChild($currency_rub);
        $shop->appendChild($currencies);

        /* @var $product Product */
        foreach (Product::find()->all() as $product) {

            $offer = $dom->createElement('offer');
            $offer->setAttribute('id', $product->id);

            $name = $dom->createElement('name', htmlspecialchars($product->display));
            $offer->appendChild($name);

            $currencyId = $dom->createElement('currencyId', "RUR");
            $offer->appendChild($currencyId);

            $url = $dom->createElement('url', sprintf("https://kotofey.store/%s", $product->detail));
            $offer->appendChild($url);

            $price = $dom->createElement('price', $product->price);
            $offer->appendChild($price);

            $picture = $dom->createElement('picture', sprintf("https://kotofey.store/%s", $product->image));
            $offer->appendChild($picture);

            $categoryId = $dom->createElement('categoryId', $product->category_id);
            $offer->appendChild($categoryId);

            if (!empty($product->description)) {
                try {
                    $description = $dom->createElement('description', "<![CDATA[" . $product->description . "]]>");
                    $offer->appendChild($description);
                } catch (\ErrorException $exception) {
                }
            }

            $delivery = $dom->createElement('delivery', "true");
            $offer->appendChild($delivery);

            $offers->appendChild($offer);
        }

        $yml_catalog->appendChild($shop);
        $shop->appendChild($offers);

        $content = $dom->saveXML();
//        return iconv('utf-8', 'windows-1251//TRANSLIT//IGNORE', $content);
        return $content;
    }
}