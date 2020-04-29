<?php

namespace app\models\entity;


use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;

/**
 * ProductReviews model
 *
 * @property integer $id
 * @property string $text
 * @property string $author
 * @property string $images
 * @property integer $rate
 * @property integer $product_id
 * @property integer $user_id
 * @property integer $created_at
 * @property integer $updated_at
 *
 * @property User $user
 */
class ProductReviews extends ActiveRecord
{
	public static function tableName()
	{
		return "product_reviews";
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
			[['text', 'product_id', 'rate', 'author'], 'required', 'message' => 'Поле {attribute} должно быть заполнено'],
			[['text', 'author'], 'string'],

			[['product_id', 'user_id', 'rate'], 'integer'],

			[['user_id'], 'default', 'value' => \Yii::$app->user->identity->id],
		];
	}

	public function attributeLabels()
	{
		return [
			'text' => "Ваш отзыв",
			'rate' => "Оценка",
			'author' => "Автор",
			'product_id' => "Товар",
			'user_id' => "Пользователь",
		];
	}

	public function getUser()
	{
		return User::findOne($this->user_id);
	}
}