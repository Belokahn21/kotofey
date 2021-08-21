<?php

namespace app\modules\delivery\models\entity;

use app\modules\delivery\models\helper\DeliveryServiceHelper;
use app\modules\media\models\entity\Media;
use Yii;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "delivery_service".
 *
 * @property int $id
 * @property int|null $is_active
 * @property int|null $sort
 * @property string|null $name
 * @property string|null $code
 * @property string|null $description
 * @property int|null $media_id
 * @property int|null $created_at
 * @property int|null $updated_at
 */
class DeliveryService extends \yii\db\ActiveRecord
{

    public function behaviors()
    {
        return [
            TimestampBehavior::className()
        ];
    }

    public function rules()
    {
        return [
            [['is_active', 'sort', 'media_id', 'created_at', 'updated_at'], 'integer'],
            [['name', 'code', 'description'], 'string', 'max' => 255],
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'is_active' => 'Активность',
            'sort' => 'Сортировка',
            'name' => 'Название',
            'code' => 'Символьный код',
            'description' => 'Описание',
            'media_id' => 'Картинка',
            'created_at' => 'Дата создания',
            'updated_at' => 'Дата обновления',
        ];
    }

    public function extraFields()
    {
        return [
            'imageUrl' => function ($model) {
                return DeliveryServiceHelper::getImageUrl($model);
            }
        ];
    }

    public function getMedia()
    {
        return $this->hasOne(Media::className(), ['id' => 'media_id']);
    }
}
