<?php

namespace app\modules\order\models\entity;

use Yii;

/**
 * This is the model class for table "customer".
 *
 * @property int $id
 * @property int|null $is_active
 * @property int|null $sort
 * @property int|null $phone
 * @property string|null $name
 * @property int|null $created_at
 * @property int|null $updated_at
 */
class Customer extends \yii\db\ActiveRecord
{
    public function rules()
    {
        return [
            [['is_active', 'sort', 'phone', 'created_at', 'updated_at'], 'integer'],
            [['name'], 'string', 'max' => 255],
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'is_active' => 'Активность',
            'sort' => 'Сортировка',
            'phone' => 'Телефон',
            'name' => 'Название',
            'created_at' => 'Дата создания',
            'updated_at' => 'Дата обновления',
        ];
    }
}
