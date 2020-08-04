<?php

namespace app\modules\geo\models\entity;


use app\modules\geo\models\entity\GeoTimezone;
use yii\behaviors\SluggableBehavior;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "geo".
 *
 * @property int $id
 * @property boolean $is_default
 * @property string $name
 * @property string $slug
 * @property int $sort
 * @property int $active
 * @property int $type
 * @property int $time_zone_id
 * @property string $address
 * @property int $start_at
 * @property int $end_at
 * @property int $created_at
 * @property int $updated_at
 *
 * @property GeoTimezone $time_zone
 */
class Geo extends \yii\db\ActiveRecord
{
	const TYPE_OBJECT_CITY = 'city';
	const TYPE_OBJECT_STREET = 'street';
	const TYPE_OBJECT_REGION = 'region';
	const TYPE_OBJECT_COUNTRY = 'country';

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
			[['sort', 'active', 'created_at', 'updated_at', 'time_zone_id', 'start_at', 'end_at'], 'integer'],

			['is_default', 'default', 'value' => null],
			['is_default', 'unique', 'targetClass' => Geo::className(), 'message' => '{attribute} уже назначен'],
			['is_default', 'boolean'],

			[['name', 'slug', 'type', 'address'], 'string', 'max' => 255],
		];
	}

	public function attributeLabels()
	{
		return [
			'id' => 'ID',
			'name' => 'Название',
			'slug' => 'Симольный код',
			'sort' => 'Сортировка',
			'active' => 'Активность',
			'type' => 'Тип объекта',
			'time_zone_id' => 'Временная зона',
			'is_default' => 'Город по умолчанию',
			'created_at' => 'Дата создания',
			'updated_at' => 'Дата обновления',
			'start_at' => 'Время открытия',
			'end_at' => 'Время закрытия',
			'address' => 'Адрес',
		];
	}

	public function getTypes()
	{
		return [
			self::TYPE_OBJECT_COUNTRY => 'Страна',
			self::TYPE_OBJECT_REGION => 'Регион',
			self::TYPE_OBJECT_CITY => 'Город',
			self::TYPE_OBJECT_STREET => 'Улица',
		];
	}

	public function getTimeZone()
	{
		return GeoTimezone::findOne($this->time_zone_id);
	}
}
