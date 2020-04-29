<?php

namespace app\models\entity;


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
	public static function tableName()
	{
		return "todo_list";
	}

	public function behaviors()
	{
		return [
			TimestampBehavior::className()
		];
	}

	public function rules()
	{
		return [
			[['name', 'user_id'], 'required', 'message' => '{attribute} должно быть заполнено'],

			[['description'], 'string'],

			[['close'], 'boolean'],
			[['close'], 'default', 'value' => false],

			[['user_id'], 'default', 'value' => \Yii::$app->user->id],
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

	public function create()
	{
		if ($this->load(\Yii::$app->request->post())) {
			if ($this->validate()) {
				return $this->save();
			}
		}

		return false;
	}

	public function edit()
	{
		if ($this->load(\Yii::$app->request->post())) {
			if ($this->validate()) {
				return $this->update();
			}
		}

		return false;
	}

	public function getUser()
	{
		return User::findOne($this->user_id);
	}
}