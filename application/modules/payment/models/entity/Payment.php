<?php

namespace app\modules\payment\models\entity;


use app\modules\delivery\models\helper\DeliveryHelper;
use app\modules\payment\models\helper\PaymentHelper;
use yii\db\ActiveRecord;
use mohorev\file\UploadBehavior;
use yii\behaviors\TimestampBehavior;

/**
 * Payment model
 *
 * @property integer $id
 * @property string $name
 * @property string $image
 * @property string $description
 * @property boolean $active
 * @property integer $created_at
 * @property integer $updated_at
 */
class Payment extends ActiveRecord
{
    public function rules()
    {
        return [
            ['name', 'required', 'message' => '{attribute} должно быть заполнено'],

            ['description', 'string'],

            ['active', 'boolean'],
        ];
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
            'name' => "Нвазвание",
            'image' => "Картинка",
            'description' => "Описаниие",
            'active' => "Активность",
        ];
    }

    public function fields()
    {
        $oldFields = parent::fields();

        $oldFields['imageUrl'] = function ($model) {
            return PaymentHelper::getImageUrl($model);
        };

        return $oldFields;
    }

    public function getNameF()
    {
        return $this->name . " (" . ($this->active == 1 ? 'Активен' : 'Не активен') . ")";
    }
}