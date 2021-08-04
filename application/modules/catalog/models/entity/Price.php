<?php

namespace app\modules\catalog\models\entity;

use Yii;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "price".
 *
 * @property int $id
 * @property string|null $name
 * @property int|null $is_active
 * @property int|null $is_main
 * @property int|null $sort
 * @property int|null $created_at
 * @property int|null $updated_at
 */
class Price extends \yii\db\ActiveRecord
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
            [['is_main'], 'default', 'value' => 0],

            [['is_active'], 'default', 'value' => 1],

            [['sort'], 'default', 'value' => 500],

            [['is_active', 'is_main', 'sort', 'created_at', 'updated_at'], 'integer'],

            [['name'], 'string', 'max' => 255],
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Название',
            'is_active' => 'Активность',
            'is_main' => 'Основаная цена',
            'sort' => 'Сортировка',
            'created_at' => 'Дата создания',
            'updated_at' => 'Дата обновления',
        ];
    }
}
