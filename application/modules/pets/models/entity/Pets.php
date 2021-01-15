<?php

namespace app\modules\pets\models\entity;

use Yii;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "pets".
 *
 * @property int $id
 * @property int $user_id
 * @property string $name
 * @property int $animal_id
 * @property string|null $birthday
 * @property int|null $created_at
 * @property int|null $updated_at
 */
class Pets extends \yii\db\ActiveRecord
{
    public function behaviors()
    {
        return [
            TimestampBehavior::className()
        ];
    }

    public function rules()
    {
        return [
            [['user_id', 'name', 'animal_id'], 'required'],
            [['user_id', 'animal_id', 'created_at', 'updated_at'], 'integer'],
            [['name', 'birthday'], 'string', 'max' => 255],
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => 'ID владельца',
            'name' => 'Имя',
            'animal_id' => 'ID Вида животного',
            'birthday' => 'День рождения',
            'created_at' => 'Дата создания',
            'updated_at' => 'Дата обновления',
        ];
    }
}
