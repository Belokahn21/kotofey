<?

namespace app\models\search;

use app\models\entity\Delivery;
use yii\base\Model;
use yii\data\ActiveDataProvider;

class DeliverySearchForm extends Delivery
{
    public static function tableName()
    {
        return "delivery";
    }

    public function rules()
    {
        return [
            [['name'], 'string'],
        ];
    }

    public function scenarios()
    {
        return Model::scenarios();
    }
}