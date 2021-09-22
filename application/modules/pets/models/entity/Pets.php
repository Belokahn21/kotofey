<?php

namespace app\modules\pets\models\entity;

use mohorev\file\UploadBehavior;
use Yii;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "pets".
 *
 * @property int $id
 * @property int $user_id
 * @property int $status_id
 * @property string $name
 * @property string $avatar
 * @property string $sex_id
 * @property int $animal_id
 * @property string|null $birthday
 * @property int|null $created_at
 * @property int|null $updated_at
 */
class Pets extends \yii\db\ActiveRecord
{
    const SEX_MALE = 1;
    const SEX_FEMALE = 2;

    const STATUS_OFF = 0;
    const STATUS_ON = 1;

    public function behaviors()
    {
        return [
            TimestampBehavior::className(),
            [
                'class' => UploadBehavior::class,
                'attribute' => 'avatar',
                'scenarios' => ['default'],
                'path' => '@webroot/upload/',
                'url' => '@web/upload/',
            ],
        ];
    }

    public function getSexes()
    {
        return [
            self::SEX_MALE => 'Мальчик',
            self::SEX_FEMALE => 'Девочка',
        ];
    }

    public function rules()
    {
        return [
//            [['user_id'], 'default', 'value' => self::STATUS_ON],

            [['user_id'], 'default', 'value' => Yii::$app->user->identity->id],
            [['status_id'], 'default', 'value' => self::STATUS_OFF],

            [['user_id', 'name', 'animal_id', 'birthday'], 'required', 'message' => '{attribute} нужно указать'],

            [['user_id', 'animal_id', 'created_at', 'updated_at', 'sex_id'], 'integer'],

            [['name', 'birthday'], 'string', 'max' => 255],

            [['avatar'], 'file', 'skipOnEmpty' => true, 'extensions' => \Yii::$app->params['files']['extensions']],
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'status_id' => 'ID статуса',
            'user_id' => 'ID владельца',
            'name' => 'Имя',
            'animal_id' => 'Какое животное',
            'birthday' => 'День рождения',
            'avatar' => 'Фото питомца',
            'sex_id' => 'Пол питомца',
            'created_at' => 'Дата создания',
            'updated_at' => 'Дата обновления',
        ];
    }

    public function hasOwner()
    {
        return Yii::$app->user->id === $this->user_id;
    }

    public function afterValidate()
    {
        parent::afterValidate();

        $this->birthday = date('Y-m-d', strtotime($this->birthday));
    }
}
