<?php

namespace app\commands;

use app\models\entity\Product;
use app\models\tool\Debug;
use yii\console\Controller;
use yii\console\ExitCode;

class ConsoleController extends Controller
{

    public function actionImport($type)
    {
        switch ($type) {
            case"rk":
                echo 'run = ' . $type;
                break;
        }
    }

    public function actionIndex()
    {
        $_SERVER['DOCUMENT_ROOT'] = "/home/c/cd91333/shop-kotofey/public_html";
        require_once './simple_html_dom.php';
        $ids = array(12309221,);

        if (($handle = fopen("./web/purina.csv", "r")) !== false) {
            while (($data = fgetcsv($handle, 1000, ",")) !== false) {
                $lineInfo = explode(",", $data[0]);
                $lineInfo = explode(";", $lineInfo[0]);

                if (count($lineInfo) != 4) {
                    continue;
                }

                if (empty($lineInfo[1]) or !is_numeric($lineInfo[1])) {
                    continue;
                }

                $page = \app\models\tool\Cron::post("https://shop.purina.ru/catalogsearch/result/", [
                    'q' => $lineInfo[1]
                ]);

                \app\models\tool\Debug::printFile($page, true);
                $page = file_get_contents($_SERVER['DOCUMENT_ROOT'] . "/web/debug.html");

                $html = str_get_html($page);

                $links = array();
                $productPage = "";
                foreach ($html->find('div.short-descr h3 a') as $a) {
                    $productPage = file_get_html($a->href);
                }


                if (empty($productPage)) {
                    continue;
                }
                $page = str_get_html($productPage);

                $title = $page->find('h1.page-title')[0]->plaintext;
                $arTitle = explode(", ", $title);
                $title = $arTitle[0];

                $desc = $page->find('div.short-descr')[0]->plaintext;
                $desc = trim($desc);
                $desc = htmlspecialchars($desc);

                $sku = $page->find('span.sku.sku__container span')[0]->plaintext;


                $price = (integer)$page->find('div.price span')[0]->plaintext;
                $imageLink = $page->find('.owl-item.active div img')[0]->src;


                $weight = array_pop($arTitle);
                $arWeight = explode(" ", trim($weight));

                switch ($arWeight[1]) {
                    case "кг":
                        $weight = $arWeight[0];
                        break;

                    case "г":
                        $weight = round($arWeight[0] / 1000, 3);
                        break;
                }


//                die($weight);
                if (Product::findOne(['code' => $lineInfo[1]])) {
                    continue;
                }
                $product = new \app\models\entity\Product(['scenario' => Product::SCENARIO_NEW_PRODUCT]);
                $product->name = $title;
                $product->category = 1;
                $product->description = $desc;
                $product->article = $sku;
                $product->count = 1;
                $product->vitrine = 1;
                $product->stock_id = 1;
                $product->code = $lineInfo[1];
                $product->purchase = $lineInfo[3];
                $product->price = $price;

                $product->properties[1] = "6";
                $product->properties[2] = str_replace(",", ".", $weight);


                echo($product->properties[2]);
                $product->createProduct();
                echo "+";

            }
            fclose($handle);
        }

    }
}
