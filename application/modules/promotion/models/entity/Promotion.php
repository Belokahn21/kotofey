<?php

namespace app\modules\promotion\models\entity;

use app\modules\content\models\behaviors\DateToIntBehaviors;
use Yii;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "promotion".
 *
 * @property int $id
 * @property string $name
 * @property int $is_active
 * @property int $start_at
 * @property int $end_at
 * @property int $created_at
 * @property int $updated_at
 */
class Promotion extends \yii\db\ActiveRecord
{
    public $save;
    public function behaviors()
    {
        return [
            TimestampBehavior::className(),
            DateToIntBehaviors::className()
        ];
    }

    public function rules()
    {
        return [
            [['name'], 'required'],
            [['is_active'], 'integer'],
            [['save'], 'boolean'],
            [['name', 'start_at', 'end_at'], 'string', 'max' => 255],
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Название акции',
            'is_active' => 'Активность',
            'start_at' => 'Начало акции',
            'end_at' => 'Конец акции',
            'created_at' => 'Дата создания',
            'updated_at' => 'Дата обновления',
        ];
    }
}
