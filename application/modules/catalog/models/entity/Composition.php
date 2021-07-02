<?php

namespace app\modules\catalog\models\entity;

use Yii;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "composition".
 *
 * @property int $id
 * @property int|null $is_active
 * @property int|null $sort
 * @property string|null $name
 * @property int $composition_type_id
 * @property int|null $created_at
 * @property int|null $updated_at
 */
class Composition extends \yii\db\ActiveRecord
{
    public function rules()
    {
        return [
            [['name', 'composition_type_id'], 'required'],

            [['sort'], 'default', 'value' => 500],

            [['is_active'], 'default', 'value' => 1],

            [['is_active', 'sort', 'created_at', 'updated_at', 'composition_type_id'], 'integer'],

            [['name'], 'string', 'max' => 255],
            ['name', 'unique']
        ];
    }

    public function behaviors()
    {
        return [
            TimestampBehavior::className()
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'is_active' => 'Активность',
            'sort' => 'Сортировка',
            'name' => 'Название',
            'composition_type_id' => 'ID композиции',
            'created_at' => 'Дата создания',
            'updated_at' => 'Дата обновления',
        ];
    }
}
