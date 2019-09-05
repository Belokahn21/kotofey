<?
/**
 * Developer: Konstantin Vasin by PhpStorm
 * Company: Altasib
 * Time: 13:59
 */

namespace app\models\tool\vk\entity;

use yii\base\Model;

/**
 * VKUser model
 *
 * @property integer $id
 * @property string $first_name
 * @property string $last_name
 * @property boolean $is_closed
 * @property boolean $can_access_closed
 * @property integer $sex
 * @property string $screen_name
 * @property string $bdate
 * @property string $photo_big
 */
class VKUser extends Model
{
    public $id;
    public $sex;
    public $first_name;
    public $last_name;
    public $photo_big;

    public function saveToSession()
    {
        $_SESSION['STORAGE']['vkuser'] = $this;
    }

    public static function deleteFromSession()
    {
        if (isset($_SESSION['STORAGE'])) {
            unset($_SESSION['STORAGE']);
        }
    }

    public function rules()
    {
        return [
            [['first_name', 'last_name', 'photo_big'], 'string'],
            [['id', 'sex'], 'integer'],
        ];
    }
}