<?php

namespace app\modules\order\models\entity;

use Yii;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "customer".
 *
 * @property int|null $phone
 * @property int|null $is_active
 * @property int|null $sort
 * @property string|null $name
 * @property string $description
 * @property int|null $created_at
 * @property int|null $updated_at
 * @property int|null $customer_id
 */
class Customer extends \yii\db\ActiveRecord
{
    public function behaviors()
    {
        return [
            TimestampBehavior::className(),
        ];
    }

    public function rules()
    {
        return [
            [['phone'], 'required'],

            [['sort'], 'default', 'value' => 500],

            [['is_active'], 'boolean'],
            [['is_active'], 'default', 'value' => true],

            [['phone', 'sort', 'created_at', 'updated_at', 'customer_id'], 'integer'],

            [['name'], 'string', 'max' => 255],
            [['description'], 'string'],

            ['phone', 'unique', 'targetClass' => Customer::className(), 'message' => 'Этот телефон уже добавлен.'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'phone' => 'Телефон',
            'is_active' => 'Активность',
            'sort' => 'Сортировка',
            'name' => 'Имя/Название',
            'description' => 'Описание',
            'customer_id' => 'Статус клиента',
            'created_at' => 'Дата создания',
            'updated_at' => 'Дата обновления',
        ];
    }

    public function extraFields()
    {
        return [
            'cross' => function ($model) {
                $out = [];

                $values = CustomerPropertiesValues::find()->where(['customer_id' => $model->phone])->all();

                foreach ($values as $value) {
                    $out[$value->property->cross] = $value->value;
                }

                return $out;
            }
        ];
    }
}
