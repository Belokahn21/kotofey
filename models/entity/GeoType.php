<?php

namespace app\models\entity;

use Yii;

/**
 * This is the model class for table "geo_type".
 *
 * @property int $id
 * @property string $name
 * @property string $slug
 * @property int $active
 * @property int $sort
 * @property int $created_at
 * @property int $updated_at
 */
class GeoType extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'geo_type';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['active', 'sort', 'created_at', 'updated_at'], 'integer'],
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
            'slug' => 'Символьный код',
            'active' => 'Активность',
            'sort' => 'Сортировка',
			'created_at' => 'Дата создания',
			'updated_at' => 'Дата обновления',
        ];
    }
}
