<?php

namespace app\commands;

use app\modules\site\models\tools\Debug;
use app\modules\catalog\models\entity\InformersValues;
use app\modules\catalog\models\entity\Product;
use app\modules\catalog\models\entity\ProductPropertiesValues;
use app\modules\catalog\models\helpers\ProductPropertiesValuesHelper;
use app\modules\cdek\models\entity\CdekGeo;
use app\modules\content\models\entity\SlidersImages;
use app\modules\media\models\entity\Media;
use app\modules\user\models\entity\User;
use app\modules\vendors\models\entity\Vendor;
use yii\console\Controller;
use yii\helpers\Json;

class ConsoleController extends Controller
{
    public function actionRun($arg = null)
    {
        $users[83] = 'Alex9059295224';
        $users[84] = 'Shanhay';
        $users[85] = '2012292209';
        $users[86] = 'grom2017';
        $users[87] = 'Barnayl13';
        $users[88] = '25071958';
        $users[89] = 'cfa123321';
        $users[90] = 'korverart2012';
        $users[91] = 'ypfr2017';
        $users[92] = '1907';
        $users[93] = '423246';

        foreach ($users as $userId => $pass) {
            $user = User::findOne($userId);
            $user->setPassword($pass);
            $user->scenario = User::SCENARIO_UPDATE;
            $user->phone = (string)$user->phone;
            if ($user->validate() && $user->update()) {
                echo "success update " . $user->email;
                echo PHP_EOL;
            }else{
                Debug::p($user->getErrors());
            }
        }

//        foreach (Product::find()->all() as $product) {
//            $product->scenario = Product::SCENARIO_UPDATE_PRODUCT;
//            $product->discount_price = null;
//
//            if (!$product->validate()) {
//                return false;
//            }
//
//            if ($product->update()) {
//                echo $product->name;
//                echo PHP_EOL;
//            }
//        }


//        $infValues = InformersValues::find()->where(['media_id' => null])->all();
//
//        foreach ($infValues as $item) {
//            $path = \Yii::getAlias("@webroot/upload/$item->image");
//
//            if (is_file($path)) {
//                $cdnResponse = \Yii::$app->CDN->uploadImage($path);
//
//                if (is_array($cdnResponse)) {
//                    $media = new Media();
//                    $media->json_cdn_data = Json::encode($cdnResponse);
//                    $media->location = Media::LOCATION_CDN;
//                    $media->name = $item->image;
//                    $media->type = Media::MEDIA_TYPE_IMAGE;
//
//                    if (!$media->validate()) {
//                        Debug::p($media->getErrors());
//                        return false;
//                    }
//
//                    if (!$media->save()) {
//                        return false;
//                    }
//
//                    $item->media_id = $media->id;
//
//                    if (!$item->validate()) {
//                        Debug::p($item->getErrors());
//                        return false;
//                    }
//
//                    if (!$item->update()) {
//                        Debug::p($item->getErrors());
//                        return false;
//                    }
//                    echo 'ID: ' . $item->id . $item->name . "($path)";
//                    echo PHP_EOL;
//                }
//
//
//            }
//        }
//
//        echo "finish!!!";
//        echo PHP_EOL;

//        $phrases = [
//            'дилли',
//            '16',
//        ];
//
//        $products = Product::find();
//
//        foreach ($phrases as $phrase) {
//            $products->andWhere(['like', 'name', $phrase]);
//        }
//
//        $products = $products->all();
//        foreach ($products as $product) {
////            echo $product->name;
////            echo PHP_EOL;
////            continue;
//
//
//            // ШхВхД
//            if (ProductPropertiesValuesHelper::savePropertyValue($product->id, '16', '71') && ProductPropertiesValuesHelper::savePropertyValue($product->id, '17', '17') && ProductPropertiesValuesHelper::savePropertyValue($product->id, '18', '41')) {
//
//                $product->scenario = Product::SCENARIO_UPDATE_PRODUCT;
//                $product->is_ali = 1;
//
//                if (!$product->validate()) {
//                    return false;
//                }
//
//                if (!$product->update()) {
//                    return false;
//                }
//
//                echo $product->name;
//                echo PHP_EOL;
//            }
//        }


//        \Yii::$app->db->createCommand('TRUNCATE `cdek_geo`')->execute();
//        if (($handle = fopen(\Yii::getAlias('@app/tmp/cdek.csv'), "r")) !== false) {
//            while (($line = fgetcsv($handle, 1000, ";")) !== false) {
//                if (!is_numeric($line[0])) {
//                    continue;
//                }
//
//                $cdek = new CdekGeo();
//
//                if ($line[7]) {
//                    $cdek->postcode = $line[7];
//                }
//                $cdek->city_id = $line[0];
//                $cdek->FullName = $line[1];
//                $cdek->CityName = $line[2];
//                $cdek->FIAS = $line[14];
//                $cdek->KLADR = $line[15];
//
//
//                if (!$cdek->validate()) {
//                    Debug::p($cdek->getErrors());
//                    return false;
//                }
////
//                if (!$cdek->save()) {
//                    Debug::p($cdek->getErrors());
//                    return false;
//                }
//
//                echo $line[1] . " - добавлен";
//                echo PHP_EOL;
//            }
//        }

//        $images = SlidersImages::find()->where(['media_id' => null])->andWhere(['is not', 'image', null])->all();
//
//        foreach ($images as $image) {
//            $path = \Yii::getAlias("@webroot/upload/$image->image");
//
//            if (is_file($path)) {
//                $cdnResponse = \Yii::$app->CDN->uploadImage($path);
//
//                if (is_array($cdnResponse)) {
//                    $media = new Media();
//                    $media->json_cdn_data = Json::encode($cdnResponse);
//                    $media->location = Media::LOCATION_CDN;
//                    $media->name = $image->image;
//                    $media->type = Media::MEDIA_TYPE_IMAGE;
//
//                    if (!$media->validate()) {
//                        Debug::p($media->getErrors());
//                        return false;
//                    }
//
//                    if (!$media->save()) {
//                        return false;
//                    }
//
//                    $image->media_id = $media->id;
//
//                    if (!$image->validate()) {
//                        Debug::p($image->getErrors());
//                        return false;
//                    }
//
//                    if (!$image->update()) {
//                        Debug::p($image->getErrors());
//                        return false;
//                    }
//                    echo 'ID: ' . $image->id . $image->text . "($path)";
//                    echo PHP_EOL;
//                }
//
//
//            }
//        }
//
//        echo "finish!!!";
//        echo PHP_EOL;

//        $products = Product::find()->where(['vendor_id' => Vendor::VENDOR_ID_FORZA])->all();
//        foreach ($products as $product) {
//            $product->scenario = Product::SCENARIO_UPDATE_PRODUCT;
//
//            $product->discount_price = null;
//
//            if ($product->validate()) {
//                if ($product->update()) {
//                    echo $product->code . "=" . $product->name;
//                    echo PHP_EOL;
//                }
//            }
//        }
    }

    public function actionClearCache()
    {
        \Yii::$app->cache->flush();
    }
}
