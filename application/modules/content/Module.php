<?php

namespace app\modules\content;

use yii\helpers\Url;

/**
 * content module definition class
 */
class Module extends \app\modules\site\MainModule
{
    public $controllerNamespace = 'app\modules\content\controllers';
    public $name = 'Контент';

    public function init()
    {
        parent::init();
    }


    public function menuIndex()
    {
        return [
            ['name' => 'Слайдеры', 'url' => Url::to(['/admin/content/slider-backend/index'])],
            ['name' => 'Изображения слайдера', 'url' => Url::to(['/admin/content/slider-images-backend/index'])],
        ];
    }

    public function getName()
    {
        return $this->name;
    }

}
