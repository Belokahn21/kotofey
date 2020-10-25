<?php

namespace app\modules\pets\models\entity;

use Yii;

/**
 * This is the model class for table "pets".
 *
 * @property int $id
 * @property int $user_id
 * @property string $name
 * @property string|null $birthday
 * @property int|null $created_at
 * @property int|null $updated_at
 */
class Pets extends \yii\db\ActiveRecord
{
    public static function tableName()
    {
        return 'pets';
    }

    public function rules()
    {
        return [
            [['user_id', 'name'], 'required'],
            [['user_id', 'created_at', 'updated_at'], 'integer'],
            [['name', 'birthday'], 'string', 'max' => 255],
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => 'Владелец',
            'name' => 'Имя питомца',
            'birthday' => 'День рождения',
            'created_at' => 'Дата создания',
            'updated_at' => 'Дата обновления',
        ];
    }
}
