<?php

namespace app\modules\todo\models\entity;

use app\modules\user\models\entity\User;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;

/**
 * TodoList model
 *
 * @property integer $id
 * @property integer $user_id
 * @property integer $name
 * @property integer $description
 * @property boolean $close
 * @property integer $created_at
 * @property integer $updated_at
 *
 * @property User $user
 */
class TodoList extends ActiveRecord
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
            [['user_id'], 'default', 'value' => \Yii::$app->user->id],


            [['name', 'user_id'], 'required', 'message' => '{attribute} должно быть заполнено'],

            [['description'], 'string'],

            [['close'], 'boolean'],
            [['close'], 'default', 'value' => false],
        ];
    }

    public function attributeLabels()
    {
        return [
            'name' => "Название",
            'description' => "Описание",
            'close' => "Закрыто",
            'user_id' => "Пользователь",
        ];
    }

    public function extraFields()
    {
        return ['user'];
    }

    public function getUser()
    {
        return User::findOne($this->user_id);
    }
}