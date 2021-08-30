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
 * @property string $size
 * @property int|null $sort
 * @property int|null $animal_id
 * @property int|null $created_at
 * @property int|null $updated_at
 *
 * @property Animal $animal
 */
class Breed extends \yii\db\ActiveRecord
{
    const SIZE_MINI = 'mini';
    const SIZE_SMALL = 'small';
    const SIZE_MEDIUM = 'medium';
    const SIZE_LARGE = 'large';

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

            [['name', 'size'], 'string', 'max' => 255],
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'is_active' => 'Активность',
            'name' => 'Название',
            'size' => 'Размер породы',
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

    public function getSizes()
    {
        return [
            self::SIZE_MINI => 'Миниатюрная',
            self::SIZE_SMALL => 'Мелкая',
            self::SIZE_MEDIUM => 'Средняя',
            self::SIZE_LARGE => 'Курпная',
        ];
    }
}
