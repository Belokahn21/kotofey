<?php

namespace app\modules\catalog\models\entity;

use app\modules\media\models\entity\Media;
use Yii;

/**
 * This is the model class for table "properties_variants".
 *
 * @property int $id
 * @property int $property_id
 * @property int $is_active
 * @property int $media_id
 * @property string $name
 * @property string $link
 * @property int $sort
 * @property int|null $created_at
 * @property int|null $updated_at
 *
 * @property Properties $property
 */
class PropertiesVariants extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'properties_variants';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['property_id', 'name'], 'required'],
            [['property_id', 'is_active', 'sort', 'created_at', 'updated_at'], 'integer'],
            [['name'], 'string', 'max' => 128],
            [['property_id'], 'exist', 'skipOnError' => true, 'targetClass' => Properties::className(), 'targetAttribute' => ['property_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'property_id' => 'Property ID',
            'is_active' => 'Is Active',
            'name' => 'Name',
            'sort' => 'Sort',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * Gets query for [[Property]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getProperty()
    {
        return $this->hasOne(Properties::className(), ['id' => 'property_id']);
    }

    public function getMedia()
    {
        return $this->hasOne(Media::className(), ['id' => 'media_id']);
    }
}
