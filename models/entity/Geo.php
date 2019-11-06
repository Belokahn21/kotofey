<?php

namespace app\models\entity;

use Yii;
use yii\behaviors\SluggableBehavior;
use yii\behaviors\TimestampBehavior;
use yii\data\ActiveDataProvider;

/**
 * This is the model class for table "geo".
 *
 * @property int $id
 * @property string $name
 * @property string $slug
 * @property int $sort
 * @property int $active
 * @property int $type_id link:geo_type
 * @property int $created_at
 * @property int $updated_at
 */
class Geo extends \yii\db\ActiveRecord
{
	/**
	 * {@inheritdoc}
	 */
	public static function tableName()
	{
		return 'geo';
	}

	public function behaviors()
	{
		return [
			TimestampBehavior::class,
			[
				'class' => SluggableBehavior::className(),
				'attribute' => 'name',
				'ensureUnique' => true,
			],
		];
	}

	/**
	 * {@inheritdoc}
	 */
	public function rules()
	{
		return [
			[['name'], 'required'],
			[['sort', 'active', 'type_id', 'created_at', 'updated_at'], 'integer'],
			[['name', 'slug'], 'string', 'max' => 255],
		];
	}

	/**
	 * {@inheritdoc}
	 */
	public function attributeLabels()
	{
		return [
			'id' => 'ID',
			'name' => 'Название',
			'slug' => 'Симольный код',
			'sort' => 'Сортировка',
			'active' => 'Активность',
			'type_id' => 'Тип объекта',
			'created_at' => 'Дата создания',
			'updated_at' => 'Дата обновления',
		];
	}

	public function search($params)
	{
		$query = static::find();

		$dataProvider = new ActiveDataProvider([
			'query' => $query,
		]);

		if (!($this->load($params) && $this->validate())) {
			return $dataProvider;
		}

		$query->andFilterWhere(['like', 'name', $this->name]);

		return $dataProvider;
	}
}
