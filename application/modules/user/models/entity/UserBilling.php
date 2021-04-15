<?php

namespace app\modules\user\models\entity;

use Yii;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "user_billing".
 *
 * @property int $id
 * @property string|null $name
 * @property int|null $client
 * @property int|null $is_main
 * @property int|null $phone
 * @property int|null $index
 * @property string|null $region
 * @property string|null $city
 * @property string|null $street
 * @property string|null $home
 * @property string|null $entrance
 * @property string|null $floor_house
 * @property string|null $house
 * @property int|null $created_at
 * @property int|null $updated_at
 */
class UserBilling extends \yii\db\ActiveRecord
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
            [['phone'], 'required'],
            [['client', 'is_main', 'phone', 'index', 'created_at', 'updated_at'], 'integer'],
            [['name', 'city', 'street', 'home', 'house'], 'string', 'max' => 255],
            [['region', 'entrance', 'floor_house'], 'string', 'max' => 128],
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'client' => 'Client',
            'is_main' => 'Is Main',
            'phone' => 'Phone',
            'index' => 'Index',
            'region' => 'Region',
            'city' => 'City',
            'street' => 'Street',
            'home' => 'Home',
            'entrance' => 'Entrance',
            'floor_house' => 'Floor House',
            'house' => 'House',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    public function hasAccess()
    {
        return $this->phone == Yii::$app->user->identity->phone;
    }
}
