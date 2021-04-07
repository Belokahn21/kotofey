<?php

namespace app\modules\delivery\models\entity;


use app\modules\delivery\models\helper\DeliveryHelper;
use yii\db\ActiveRecord;
use mohorev\file\UploadBehavior;
use yii\behaviors\TimestampBehavior;

/**
 * Delivery model
 *
 * @property integer $id
 * @property string $name
 * @property string $image
 * @property string $description
 * @property boolean $active
 * @property integer $created_at
 * @property integer $updated_at
 */
class Delivery extends ActiveRecord
{
    const LIMIT_ORDER_SUMM_TO_ACTIVATE = 500;
    const PRICE_DELIVERY = 100;

    public function rules()
    {
        return [
            ['name', 'required', 'message' => '{attribute} должно быть заполнено'],

            ['description', 'string'],

            ['active', 'boolean'],
        ];
    }

    public function fields()
    {
        $oldFields = parent::fields();

        $oldFields['imageUrl'] = function ($model) {
            return DeliveryHelper::getImageUrl($model);
        };

        return $oldFields;
    }

    public function behaviors()
    {
        return [
            TimestampBehavior::className(),
            [
                'class' => UploadBehavior::class,
                'attribute' => 'image',
                'scenarios' => ['default'],
                'path' => '@webroot/upload/',
                'url' => '@web/upload/',
            ],
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => "ID",
            'image' => "Картинка",
            'name' => "Нвазвание",
            'description' => "Описаниие",
            'active' => "Активность",
        ];
    }

    public function getNameF()
    {
        return $this->name . " (" . ($this->active == 1 ? 'Активен' : 'Не активен') . ")";
    }
}