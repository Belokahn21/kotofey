<?php

namespace app\modules\catalog\models\form;


use app\modules\catalog\models\entity\Product;
use app\modules\media\models\entity\Media;
use app\modules\site\models\tools\Debug;

class ProductFromSibagoForm extends Product
{
    public $lazyImageUrl;
    public $methodSave;

    public function rules()
    {
        return array_merge(Product::rules(), [
            ['methodSave', 'safe']
        ]);
    }

    public static function tableName()
    {
        return Product::tableName();
    }

    public function beforeSave($insert)
    {
        if (!empty($this->lazyImageUrl) && !empty($this->methodSave)) {
            exit();
            $file = file_get_contents($this->lazyImageUrl);

            $path = parse_url($this->lazyImageUrl, PHP_URL_PATH);
            $extension = pathinfo($path, PATHINFO_EXTENSION);

            $filename = substr(md5(time()), 0, 15);
            $image = $filename . '.' . $extension;

            $pathToTmpImage = \Yii::getAlias("@app/tmp/$image");

            file_put_contents($pathToTmpImage, $file);

            $media = new Media();
            $media->path = $pathToTmpImage;
            $media->name = $image;
            $media->type = $this->methodSave;

            if ($media->validate() && $media->save()) {
                if ($this->methodSave == Media::LOCATION_CDN) {
                    \Yii::$app->CDN->uploadImage($pathToTmpImage);
                    unlink($pathToTmpImage);
                    return true;
                }


                if ($this->methodSave == Media::LOCATION_SERVER) {
                    return move_uploaded_file($pathToTmpImage, \Yii::getAlias("@web/upload/$image"));
                }
            }

        }

        return Product::beforeSave($insert);
    }
}