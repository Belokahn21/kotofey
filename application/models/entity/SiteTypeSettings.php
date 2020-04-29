<?php
/**
 * Developer: Konstantin Vasin by PhpStorm
 * Company: Altasib
 * Time: 12:45
 */

namespace app\models\entity;


use yii\db\ActiveRecord;

/**
 * SiteTypeSettings model
 *
 * @property integer $id
 * @property string $name
 * @property string $code
 */
class SiteTypeSettings extends ActiveRecord
{
    public static function tableName()
    {
        return "site_type_settings";
    }

    public function rules()
    {
        return [
            [['code','name'], 'required'],

            [['code','name'], 'string']
        ];
    }
}