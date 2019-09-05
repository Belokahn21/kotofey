<?
/**
 * Developer: Konstantin Vasin by PhpStorm
 * Company: Altasib
 * Time: 12:47
 */

namespace app\models\forms;


use yii\base\Model;

class NotifyAboutErorrForm extends Model
{
    public $url;
    public $created_at;

    public function rules()
    {
        return [
            ['url', 'required'],
            ['url', 'string'],
            ['created_at', 'default', 'value' => time()],
        ];
    }

    public function sendNotify()
    {
    }
}