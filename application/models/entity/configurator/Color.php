<?php
/**
 * Developer: Konstantin Vasin by PhpStorm
 * Company: Altasib
 * Time: 13:14
 */

namespace app\models\entity\configurator;


use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;

class Color extends ActiveRecord
{
    public static function tableName()
    {
        return "cfg_color";
    }

    public function behaviors()
    {
        return [
            TimestampBehavior::className()
        ];
    }
}