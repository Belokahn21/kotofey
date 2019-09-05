<?
/**
 * Developer: Konstantin Vasin by PhpStorm
 * Company: Altasib
 * Time: 15:55
 */

namespace app\models\tool\delivery\kladr;

use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;

/**
 * Regions model
 *
 * @property integer $id
 * @property string $name
 * @property integer $kod_region
 * @property integer $mail_index
 * @property integer $okato
 * @property integer $tax_code
 * @property integer $code_kladr
 * @property integer $created_at
 * @property integer $updated_at
 */
class Regions extends ActiveRecord
{

    public static function tableName()
    {
        return "kladr_regions";
    }

    public function rules()
    {
        return [
            ['name', 'required', 'message' => 'Поле {attribute} должно быть заполнено'],
            [['code_kladr'], 'integer'],
        ];
    }

    public function behaviors()
    {
        return [
            TimestampBehavior::className()
        ];
    }
}