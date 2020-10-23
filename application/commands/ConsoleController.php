<?php

namespace app\commands;

use app\models\tool\Debug;
use app\modules\catalog\models\entity\Product;
use app\modules\catalog\models\entity\ProductPropertiesValues;
use app\modules\content\models\entity\SlidersImages;
use app\modules\media\models\entity\Media;
use app\modules\vendors\models\entity\Vendor;
use yii\console\Controller;
use yii\helpers\Json;

class ConsoleController extends Controller
{
    public function actionRun()
    {

        \Yii::$app->db->createCommand('DELETE FROM `kotofey_store`.`migration` WHERE  `version`=\'m201021_163727_create_cdek_geo_table\';')->execute();

//        if (($handle = fopen(\Yii::getAlias('@app/tmp/cdek.csv'), "r")) !== false) {
//            while (($line = fgetcsv($handle, 1000, ";")) !== false) {
//                if (!is_numeric($line[1])) {
//                    continue;
//                }
//
//                $cdek = new geo
//
//                Debug::p($line);
//
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
