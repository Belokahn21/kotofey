<?php

namespace app\modules\catalog\models\form;


use app\modules\catalog\models\entity\Product;
use app\modules\media\models\entity\Media;
use app\modules\site\models\tools\Debug;
use yii\helpers\Json;

class ProductFromSibagoForm extends Product
{
    public $lazyImageUrl;
    public $methodSave;

    const SCENATIO_SIBAGRO_SAVE = 'sibagro';

    public function rules()
    {
        return [
            [['name', 'code', 'lazyImageUrl', 'methodSave'], 'string'],
            [['price', 'discount_price', 'count', 'media_id', 'vitrine', 'vendor_id'], 'integer']
        ];
    }

    public function scenarios()
    {
        return [
            self::SCENATIO_SIBAGRO_SAVE => ['name', 'code', 'lazyImageUrl', 'methodSave', 'price', 'purchase', 'count', 'media_id', 'vitrine', 'vendor_id']
        ];
    }

    public static function tableName()
    {
        return Product::tableName();
    }

    public function beforeSave($insert)
    {
        $product = Product::findOneByCode($this->code);
        if (!empty($this->lazyImageUrl) && !empty($this->methodSave) && empty($product->media_id)) {

            $file = file_get_contents($this->lazyImageUrl);

            $path = parse_url($this->lazyImageUrl, PHP_URL_PATH);
            $extension = pathinfo($path, PATHINFO_EXTENSION);

            $filename = substr(md5(time()), 0, 15);
            $image = $filename . '.' . $extension;

            $pathToTmpImage = \Yii::getAlias("@app/tmp/$image");

            file_put_contents($pathToTmpImage, $file);


            if (strtoupper(substr(PHP_OS, 0, 3)) === 'WIN') {
            } else {
                @chmod($pathToTmpImage, '777');
            }


            if ($this->methodSave == Media::LOCATION_CDN) $cdnData = \Yii::$app->CDN->uploadImage($pathToTmpImage);
            if ($this->methodSave == Media::LOCATION_SERVER) move_uploaded_file($pathToTmpImage, \Yii::getAlias("@web/upload/$image"));

            $media = new Media();
            $media->path = $pathToTmpImage;
            $media->name = $image;
            $media->type = $this->methodSave;
            $media->location = $this->methodSave;
            if ($this->methodSave == Media::LOCATION_CDN) $media->json_cdn_data = Json::encode($cdnData);


            if (!Product::findOneByCode($this->code)) {
                if (!$media->validate() or !$media->save()) {
                    Debug::p($media->getErrors());
                }
            } else {
                if (!$media->validate() or !$media->update()) {
                    Debug::p($media->getErrors());
                }
            }

            $this->media_id = $media->id;
        }

        return Product::beforeSave($insert);
    }
}