<?php
/**
 * Developer: Konstantin Vasin by PhpStorm
 * Company: Altasib
 * Time: 13:14
 */

namespace app\models\entity\configurator;


use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;

class Accessory extends ActiveRecord
{
    public static function tableName()
    {
        return "cfg_accessory";
    }

    public function behaviors()
    {
        return [
            TimestampBehavior::className()
        ];
    }
}