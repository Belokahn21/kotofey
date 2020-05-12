<?php

namespace app\commands;

use app\models\entity\Product;
use app\models\entity\ProductPropertiesValues;
use app\models\entity\ProductSync;
use app\models\entity\Promo;
use app\models\entity\User;
use app\models\entity\UsersReferal;
use app\models\tool\Debug;
use yii\console\Controller;
use yii\helpers\ArrayHelper;

class ConsoleController extends Controller
{
    const VENDOR_ID_SIBAGRO_TRADE = 4;

    public function actionName()
    {
        // royal
        $product_values = ProductPropertiesValues::find()->where(['property_id' => 1, 'value' => 60])->all();
        $products = Product::find()->where(['id' => ArrayHelper::getColumn($product_values, 'product_id')]);

        foreach ($products->all() as $product) {
            $product->scenario = Product::SCENARIO_UPDATE_PRODUCT;
            $product->name = str_replace('Брит', 'Brit Premium', $product->name);
            if ($product->validate()) {
                if (!$product->update()) {
                    Debug::p($product->getErrors());
                } else {
                    echo $product->name . PHP_EOL;
                }
            } else {
                Debug::p($product->getErrors());
            }
        }
    }

    public function actionSeo()
    {
        // royal
        $product_values = ProductPropertiesValues::find()->where(['property_id' => 1, 'value' => 57])->all();
        $products = Product::find()->where(['id' => ArrayHelper::getColumn($product_values, 'product_id')]);

        foreach ($products->all() as $product) {
            $product->scenario = Product::SCENARIO_UPDATE_PRODUCT;
            $product->feed .= 'Pi pi bent';
            if ($product->validate()) {
                if (!$product->update()) {
                    Debug::p($product->getErrors());
                }
            } else {
                Debug::p($product->getErrors());
            }
        }
    }

    public function actionActive()
    {
        $product_values = ProductPropertiesValues::find()->where(['property_id' => 1, 'value' => 6])->all();
        $products = Product::find()->where(['id' => ArrayHelper::getColumn($product_values, 'product_id')])->all();

        foreach ($products as $product) {
            $product->scenario = Product::SCENARIO_UPDATE_PRODUCT;
            $product->active = 0;
            if ($product->validate()) {
                if ($product->update()) {
                    echo "adsadasd" . PHP_EOL;
                }
            }
        }
    }

    public function actionPrice($toggle = false)
    {
        // purina
//		$product_values = ProductPropertiesValues::find()->where(['property_id' => 1, 'value' => 6])->all();

        // hills
//        $product_values = ProductPropertiesValues::find()->where(['property_id' => 1, 'value' => 108])->all();

        // royal
//		$product_values = ProductPropertiesValues::find()->where(['property_id' => 1, 'value' => 1])->all();

        // acana
//		$product_values = ProductPropertiesValues::find()->where(['property_id' => 1, 'value' => 75])->all();

        // mix: royal && hills
        $product_values = ProductPropertiesValues::find()->where(['property_id' => 1, 'value' => [108, 1]])->all();


        $products = Product::find()->where(['id' => ArrayHelper::getColumn($product_values, 'product_id')]);
        $sale = [
//			'1' => '10',
//			'1.5' => '10',
//			'2' => '10',
//			'2.5' => '10',
//			'3' => '10',
//			'4' => '10',
//			'5' => '10',
//			'6' => '10',
//			'7' => '10',
//			'7.5' => '10',
//			'10' => '10',
//			'12' => '10',
//			'15' => '10',
        ];

        /* @var $product Product */
        foreach ($products->all() as $product) {
            $product->scenario = Product::SCENARIO_UPDATE_PRODUCT;

            $product_weight = ProductPropertiesValues::find()->where(['property_id' => 2, 'product_id' => $product->id])->one();

            $percent = 10;
//            if (array_key_exists($product_weight->value, $sale) && $product_weight->value >= 1) {
//                $percent = $sale[$product_weight->value];
//            }
            $product->scenario = Product::SCENARIO_UPDATE_PRODUCT;
            $product->price = ceil($product->purchase + ($product->purchase * ($percent / 100)));
            if ($product->validate()) {
                if ($product->update() !== false) {
                    echo sprintf('id:%s (%s%%) oldPrice: %s newPrice: %s %s', $product->id, $percent, $product->purchase + ($product->purchase * (30 / 100)), $product->price, $product->name) . PHP_EOL;
                }
            }
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

                if (Product::findOne(['code' => $lineInfo[1]])) {
                    continue;
                }
                $product = new \app\models\entity\Product(['scenario' => Product::SCENARIO_NEW_PRODUCT]);
                $product->name = $title;
                $product->category_id = 1;
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

    public function actionReferal()
    {
        $users = User::find()->all();
        foreach ($users as $user) {
            if (!UsersReferal::findOneByUserId($user->id)) {
                $ref = new UsersReferal();
                $ref->createRefreal($user->id);
            }
        }
    }

    public function actionClearReferal()
    {
        foreach (UsersReferal::find()->all() as $referal) {
            $referal->count_reward = 0;
            $referal->has_rewarded = 0;
            $referal->update();
        }
    }

    public function actionHill()
    {

        if (($handle = fopen(\Yii::getAlias('@app') . "/tmp/common_hills.csv", "r")) !== false) {
            while (($data = fgetcsv($handle, 1000, ",")) !== false) {
                $feed = $this->getFeed($data[0]);
                if (empty($feed)) {
                    continue;
                }
                // hills
                $product_values = ProductPropertiesValues::find()->where(['property_id' => 1, 'value' => 108])->all();
                $products = Product::find()->where(['id' => ArrayHelper::getColumn($product_values, 'product_id'), 'code' => $data[1]])->andWhere(['like', 'feed', 'роял'])->all();
                foreach ($products as $product) {
                    $product->scenario = Product::SCENARIO_UPDATE_PRODUCT;
                    $product->feed = null;
                    $product->feed = $feed;

                    if ($product->validate()) {
                        if ($product->update()) {
                            echo "(" . $product->code . ")" . $product->name . "(" . $product->feed . ")" . PHP_EOL;
                        }
                    }
                }
            }
        }
    }

    public function actionPurina()
    {

        $product_values = ProductPropertiesValues::find()->where(['property_id' => 1, 'value' => 6])->all();
        $products = Product::find()->where(['id' => ArrayHelper::getColumn($product_values, 'product_id')])->all();
        foreach ($products as $product) {
            $product->scenario = Product::SCENARIO_UPDATE_PRODUCT;
            if (!empty($product->purchase)) {
                $product->price = $product->purchase;
            }

            if ($product->validate()) {
                if ($product->update()) {
                    echo "(" . $product->code . ")" . $product->name . PHP_EOL;
                }
            }
        }
    }

    public function getFeed($related_key)
    {
        if (($handle = fopen(\Yii::getAlias('@app') . "/tmp/common_hills.csv", "r")) !== false) {
            while (($data = fgetcsv($handle, 1000, ",")) !== false) {
                if ($data[0] == $related_key) {
                    try {
                        return implode([$data[6], $data[8], $data[9], $data[10], $data[11], $data[12], $data[13], $data[14], $data[15], $data[16], $data[17], $data[18], $data[19], $data[20], $data[21], $data[22], $data[23], $data[24]], ' ');
                    } catch (\Exception $exception) {
                    }
                }
            }
        }
        return null;
    }

    public function getFeedSprlCats($related_key)
    {
        if (($handle = fopen(\Yii::getAlias('@app') . "/tmp/common_hills.csv", "r")) !== false) {
            while (($data = fgetcsv($handle, 1000, ",")) !== false) {
                if ($data[0] == $related_key) {
                    try {
                        return implode([$data[6], $data[8], $data[9], $data[10], $data[11], $data[12], $data[13], $data[14], $data[15], $data[16], $data[17], $data[18], $data[19], $data[20], $data[21], $data[22], $data[23], $data[24]], ' ');
                    } catch (\Exception $exception) {
                    }
                }
            }
        }
        return null;
    }

    public function actionMd()
    {
        $products = Product::find()->where(['vendor_id' => 12])->all();
        foreach ($products as $product) {
            $product->scenario = Product::SCENARIO_UPDATE_PRODUCT;
            $product->active = 0;
            if ($product->validate()) {
                if ($product->update()) {

                }
            }
        }


        $product_values = ProductPropertiesValues::find()->where(['property_id' => 1, 'value' => 21])->all();
        $products = Product::find()->where(['id' => ArrayHelper::getColumn($product_values, 'product_id')])->all();
        foreach ($products as $product) {
            $product->scenario = Product::SCENARIO_UPDATE_PRODUCT;
            $product->active = 0;
            if ($product->validate()) {
                if ($product->update()) {

                }
            }
        }


        $product_values = ProductPropertiesValues::find()->where(['property_id' => 1, 'value' => 2])->all();
        $products = Product::find()->where(['id' => ArrayHelper::getColumn($product_values, 'product_id')])->all();
        foreach ($products as $product) {
            $product->scenario = Product::SCENARIO_UPDATE_PRODUCT;
            $product->active = 1;
            if ($product->validate()) {
                if ($product->update()) {

                }
            }
        }
    }

    public function actionPromocode()
    {
        $counter = 0;
        if (($handle = fopen(\Yii::getAlias('@app') . "/tmp/promocodes.txt", "r")) !== false) {
            while (($data = fgetcsv($handle, 1000, "\n")) !== false) {
                $code = $data[0];

                $promo = new Promo();
                $promo->is_active = 1;
                $promo->code = $code;
                $promo->discount = 20;
                $promo->count = 1;

                if ($promo->validate()) {
                    if ($promo->save()) {
                        echo "Код {$code} добавлен" . PHP_EOL;
                    }
                }

            }
        }
    }

    public function actionSyncSibagro()
    {
        $who_not_available = [];
        $products = Product::find()->where(['vendor_id' => self::VENDOR_ID_SIBAGRO_TRADE])->andWhere(['not in', 'id', ArrayHelper::getColumn(ProductSync::find()->all(), 'product_id')])->limit(50)->all();
        foreach ($products as $product) {
            $product->scenario = Product::SCENARIO_UPDATE_PRODUCT;
            if (!$this->isSibagrotrade($product)) {
                continue;
            }

            echo $product->name . PHP_EOL;

            if (!$this->checkExist($product)) {
                $product->active = 0;
                $who_not_available[] = $product->id;
            } else {
                $product->active = 1;
            }

            if ($product->validate()) {
                if ($product->update() !== false) {
                    if ($syncHistory = ProductSync::findOne(['product_id' => $product->id])) {
                        $syncHistory->reUpdate();
                    } else {
                        $syncHistory = new ProductSync();
                        $syncHistory->push($product->id);
                    }
                }
            }
        }

        if (count($who_not_available) > 0) {
            file_put_contents(\Yii::getAlias('@app/tmp/not_available_goods.txt'), implode(';', $who_not_available), LOCK_EX | FILE_APPEND);
        }
    }

    public function isSibagrotrade(Product $product)
    {
        if ($product->vendor_id == self::VENDOR_ID_SIBAGRO_TRADE) {
            return true;
        }

        if (strlen($product->code) == 9 && (substr($product->code, 0, 4)) == '0000') {
            return true;
        }


        return false;
    }

    public function checkExist(Product $product)
    {
        $code = $product->code;
        $opts = array(
            'http' => array(
                'method' => "GET",
                'header' => "Accept-language: en\r\n" .
                    "Cookie: beget=begetok\r\n"
            )
        );

        $context = stream_context_create($opts);
        $url = "http://www.sat-altai.ru/catalog/?c=shop&a=item&number={$code}&category=";
        $file = file_get_contents($url, false, $context);

        return stristr($file, '<span class=sklad>В наличии</span>') !== false;
    }

    public function actionFix()
    {
        \Yii::$app->db->createCommand("INSERT INTO `orders_items` (`id`, `order_id`, `product_id`, `count`, `price`, `created_at`, `updated_at`, `name`, `weight`, `image`) VALUES (NULL, '69', '2123', '1', '1051', '1587525382', '1587525382', 'Сухой корм Hill\'s Science Plan для молодых стерилизованных кошек и кастрированных котов с курицей, 1.5кг', NULL, NULL);")->execute();
    }
}
