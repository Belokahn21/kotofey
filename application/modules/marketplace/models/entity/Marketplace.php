<?php

namespace app\modules\marketplace\models\entity;

use Yii;
use yii\behaviors\SluggableBehavior;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "marketplace".
 *
 * @property int $id
 * @property int $type_export_id
 * @property string|null $name
 * @property string|null $slug
 * @property int|null $is_active
 * @property int|null $sort
 * @property int|null $created_at
 * @property int|null $updated_at
 */
class Marketplace extends \yii\db\ActiveRecord
{
    const TYPE_EXPORT_MANUAL = 1;
    const TYPE_EXPORT_MANUAL_AND_STOCK = 2;
    const TYPE_EXPORT_ONLY_STOCK = 3;

    public function rules()
    {
        return [
            [['is_active'], 'boolean'],
            [['is_active'], 'default', 'value' => true],


            [['is_active', 'sort', 'created_at', 'updated_at', 'type_export_id'], 'integer'],
            [['sort'], 'default', 'value' => 500],

            [['name', 'slug'], 'string', 'max' => 255],
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'type_export_id' => 'Режим выгрузки товаров',
            'name' => 'Название',
            'slug' => 'Символьный код',
            'is_active' => 'Активность',
            'sort' => 'Сортировка',
            'created_at' => 'Дата создания',
            'updated_at' => 'Дата обновления',
        ];
    }

    public function behaviors()
    {
        return [
            TimestampBehavior::className(),
            [
                'class' => SluggableBehavior::className(),
                'attribute' => 'name',
                'ensureUnique' => true,
                'immutable' => true
            ],
        ];
    }

    public function getTypeExport()
    {
        return [
            self::TYPE_EXPORT_MANUAL => 'Ручное управление',
            self::TYPE_EXPORT_MANUAL_AND_STOCK => 'Ручное + остатки склада',
            self::TYPE_EXPORT_ONLY_STOCK => 'Остатки склада',
        ];
    }
}
