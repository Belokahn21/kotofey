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
            ['name' => 'Разделы', 'url' => Url::to(['/admin/catalog/product-category-backend/index']),],
            ['name' => 'Свойства', 'url' => Url::to(['/admin/catalog/product-properties-backend/index'])],
            ['name' => 'Варианты свойств', 'url' => Url::to(['/admin/catalog/product-properties-variants-backend/index'])],
            ['name' => 'Группы свойств', 'url' => Url::to(['/admin/catalog/product-properties-group-backend/index'])],
            ['name' => 'Движение товара', 'url' => Url::to(['/admin/catalog/transfer-backend/index'])],
            ['name' => 'Уведомление о поступлении', 'url' => Url::to(['/admin/catalog/admission-backend/index'])],
        ];
    }

    public function getName()
    {
        return $this->name;
    }
}
