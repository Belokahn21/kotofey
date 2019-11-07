<?

namespace app\models\search;

use app\models\entity\OrderStatus;
use app\models\entity\Product;
use yii\base\Model;
use yii\data\ActiveDataProvider;

class OrderStatusSearchForm extends OrderStatus
{

    public static function tableName()
    {
        return "status_order";
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