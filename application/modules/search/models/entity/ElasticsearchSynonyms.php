<?php

namespace app\modules\search\models\entity;

use Yii;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "elasticsearch_synonyms".
 *
 * @property int $id
 * @property int|null $is_active
 * @property string|null $name
 * @property int|null $created_at
 * @property int|null $updated_at
 */
class ElasticsearchSynonyms extends \yii\db\ActiveRecord
{
    public function behaviors()
    {
        return [
            TimestampBehavior::className(),
        ];
    }

    public function rules()
    {
        return [
            [['is_active'], 'default', 'value' => 1],

            [['is_active', 'created_at', 'updated_at'], 'integer'],

            [['name'], 'string', 'max' => 255],
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'is_active' => 'Активность',
            'name' => 'Наименование',
            'created_at' => 'Дата создания',
            'updated_at' => 'Дата обновления',
        ];
    }
}
