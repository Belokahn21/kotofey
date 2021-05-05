<?php

namespace app\modules\media\models\entity;

use Yii;

/**
 * This is the model class for table "media_to_entity".
 *
 * @property int $id
 * @property int|null $media_id
 * @property string|null $owner_object
 * @property int|null $created_at
 * @property int|null $updated_at
 *
 * @property Media $media
 */
class MediaToEntity extends \yii\db\ActiveRecord
{
    public function rules()
    {
        return [
            [['media_id', 'created_at', 'updated_at'], 'integer'],
            [['owner_object'], 'string', 'max' => 255],
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'media_id' => 'Media ID',
            'owner_object' => 'Owner Object',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    public function getMedia()
    {
        return $this->hasOne(Media::className(), ['id' => 'media_id']);
    }
}
