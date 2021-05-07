<?php

namespace app\modules\catalog;

use app\modules\mailer\models\entity\MailEvents;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;

/**
 *
 * @property-read string[] $paramsLabel
 */
class Module extends \yii\base\Module
{
    public $controllerNamespace = 'app\modules\catalog\controllers';
    public $admission_event_id;
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


    public function getParams()
    {
        return [
            'admission_event_id' => ArrayHelper::map(MailEvents::find()->all(), 'id', 'name'),
        ];
    }

    public function getParamsLabel()
    {
        return [
            'admission_event_id' => 'Почтовое событие для пользователя (Поступление товара)',
        ];
    }
}
