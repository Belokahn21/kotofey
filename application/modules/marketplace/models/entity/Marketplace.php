<?php

namespace app\modules\marketplace\models\entity;

use Yii;
use yii\behaviors\SluggableBehavior;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "marketplace".
 *
 * @property int $id
 * @property int|null $is_active
 * @property int|null $sort
 * @property string $name
 * @property string $slug
 * @property int|null $type_export_id
 * @property int|null $created_at
 * @property int|null $updated_at
 *
 * @property MarketplaceProduct[] $marketplaceProducts
 */
class Marketplace extends \yii\db\ActiveRecord
{
    const TYPE_EXPORT_MANUAL = 1;
    const TYPE_EXPORT_STOCK = 2;
    const TYPE_EXPORT_MANUAL_AND_STOCK = 3;

    public function behaviors()
    {
        return [
            TimestampBehavior::className(),
            [
                'class' => SluggableBehavior::className(),
                'attribute' => 'name',
                'slugAttribute' => 'slug',
                'ensureUnique' => true,
                'immutable' => true
            ],
        ];
    }

    public function rules()
    {
        return [
            [['is_active'], 'boolean'],
            [['is_active'], 'default', 'value' => true],

            [['sort', 'type_export_id', 'created_at', 'updated_at'], 'integer'],
            [['sort'], 'default', 'value' => 500],

            [['name', 'slug'], 'required'],

            [['name', 'slug'], 'string', 'max' => 255],
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'is_active' => 'Активность',
            'sort' => 'Сортровка',
            'name' => 'Название',
            'slug' => 'Символьный код',
            'type_export_id' => 'Тип выгрузки каталога',
            'created_at' => 'Дата создания',
            'updated_at' => 'Дата обновления',
        ];
    }

    /**
     * Gets query for [[MarketplaceProducts]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getMarketplaceProducts()
    {
        return $this->hasMany(MarketplaceProduct::className(), ['marketplace_id' => 'id']);
    }

    public function getTypeExports()
    {
        return [
            self::TYPE_EXPORT_MANUAL => 'Ручное',
            self::TYPE_EXPORT_STOCK => 'Только остатки',
            self::TYPE_EXPORT_MANUAL_AND_STOCK => 'Остатки + ручное',
        ];
    }
}
