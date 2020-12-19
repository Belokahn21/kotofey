<?php

namespace app\modules\catalog;

use yii\helpers\Url;

class Module extends \yii\base\Module
{
    public $controllerNamespace = 'app\modules\catalog\controllers';
    private $name = 'Каталог';

    public function init()
    {
        parent::init();
        // custom initialization code goes here
    }

    public function menuIndex()
    {
        return [
            ['name' => 'Товары', 'url' => Url::to(['/admin/catalog/product-backend/index']),],
            ['name' => 'Предложения', 'url' => Url::to(['/admin/catalog/offers-backend/index']),],
            ['name' => 'Разделы', 'url' => Url::to(['/admin/catalog/product-category-backend/index']),],
            ['name' => 'Свойства', 'url' => Url::to(['/admin/catalog/product-properties-backend/index'])],
//            ['name' => 'Справочники', 'url' => Url::to(['/admin/catalog/product-informer-backend/index'])],
            ['name' => 'Варианты свойств', 'url' => Url::to(['/admin/catalog/product-properties-variants-backend/index'])],
            ['name' => 'Значения справочников', 'url' => Url::to(['/admin/catalog/product-informer-value-backend/index'])],
        ];
    }

    public function getName()
    {
        return $this->name;
    }
}
