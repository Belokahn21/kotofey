<?php

namespace app\modules\pets\models\entity;

use Yii;

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
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'pets';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['user_id', 'name', 'animal_id'], 'required'],
            [['user_id', 'animal_id', 'created_at', 'updated_at'], 'integer'],
            [['name', 'birthday'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => 'User ID',
            'name' => 'Name',
            'animal_id' => 'Animal ID',
            'birthday' => 'Birthday',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }
}
