<?php

namespace app\modules\catalog\models\entity;

use Yii;

/**
 * This is the model class for table "properties".
 *
 * @property int $id
 * @property int $is_active
 * @property int $is_multiple
 * @property int $is_offer_catalog
 * @property int $is_show_site
 * @property string $name
 * @property int $sort
 * @property int|null $type
 * @property int|null $created_at
 * @property int|null $updated_at
 *
 * @property PropertiesVariants[] $propertiesVariants
 */
class Properties extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'properties';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['is_active', 'is_multiple', 'is_offer_catalog', 'is_show_site', 'sort', 'type', 'created_at', 'updated_at'], 'integer'],
            [['name'], 'required'],
            [['name'], 'string', 'max' => 128],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'is_active' => 'Is Active',
            'is_multiple' => 'Is Multiple',
            'is_offer_catalog' => 'Is Offer Catalog',
            'is_show_site' => 'Is Show Site',
            'name' => 'Name',
            'sort' => 'Sort',
            'type' => 'Type',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * Gets query for [[PropertiesVariants]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getPropertiesVariants()
    {
        return $this->hasMany(PropertiesVariants::className(), ['property_id' => 'id']);
    }
}
