<?

namespace app\widgets\promoCart\models\form;

use yii\base\Model;

class PromoCartForm extends Model
{
    public $code;

    public function rules()
    {
        return [
            ['code', 'string'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'code' => "Ввести промокод"
        ];
    }
}