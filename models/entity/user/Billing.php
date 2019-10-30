<?
/**
 * Developer: Konstantin Vasin by PhpStorm
 * Company: Altasib
 * Time: 16:51
 */

namespace app\models\entity\user;

use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;

/**
 * Billing model
 *
 * @property integer $id
 * @property integer $user_id
 * @property string $city
 * @property string $street
 * @property string $home
 * @property string $house
 * @property integer $phone
 * @property integer $created_at
 * @property integer $updated_at
 *
 */
class Billing extends ActiveRecord
{
    public static function tableName()
    {
        return "user_billing";
    }

    public function behaviors()
    {
        return [
            TimestampBehavior::className()
        ];
    }

    public function rules()
    {
        return [
            [['city', 'street', 'home', 'house'], 'string'],
            [['user_id'], 'integer'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'user_id' => 'ID пользователя',
            'city' => 'Город',
            'street' => 'Улица',
            'home' => 'Дом',
            'house' => 'Квартира',
        ];
    }

    public static function findByUser($userId)
    {
        return static::findOne(['user_id' => $userId]);
    }
}