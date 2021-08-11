<?php

namespace app\modules\pets\models\entity;

use Yii;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "breed".
 *
 * @property int $id
 * @property int|null $is_active
 * @property string $name
 * @property int|null $sort
 * @property int|null $animal_id
 * @property int|null $created_at
 * @property int|null $updated_at
 *
 * @property Animal $animal
 */
class Breed extends \yii\db\ActiveRecord
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
            [['is_active'], 'default', 'value' => 1],

            [['sort'], 'default', 'value' => 500],

            [['is_active', 'sort', 'animal_id', 'created_at', 'updated_at'], 'integer'],

            [['name'], 'required'],
            [['name'], 'unique'],

            [['name'], 'string', 'max' => 255],
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'is_active' => 'Активность',
            'name' => 'Название',
            'sort' => 'Сортировка',
            'animal_id' => 'Тип животного',
            'created_at' => 'Дата создания',
            'updated_at' => 'Дата обновления',
        ];
    }

    public function getAnimal()
    {
        return $this->hasOne(Animal::className(), ['id' => 'animal_id']);
    }
}
