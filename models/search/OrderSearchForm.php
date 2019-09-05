<?

namespace app\models\search;

use app\models\entity\Order;
use app\models\entity\Product;
use app\models\rbac\AuthItem;
use yii\base\Model;
use yii\data\ActiveDataProvider;

class OrderSearchForm extends Order
{

    public function rules()
    {
        return [
            [['delivery', 'payment'], 'string'],
            [['paid', 'user'], 'integer'],
        ];
    }

    public function scenarios()
    {
        return Model::scenarios();
    }

    public function search($params)
    {
        $query = Order::find()->orderBy(['created_at' => SORT_DESC]);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }

        $query->andFilterWhere(['like', 'delivery', $this->delivery])
            ->andFilterWhere(['like', 'paid', $this->paid])
            ->andFilterWhere(['like', 'user', $this->user])
            ->andFilterWhere(['like', 'payment', $this->payment]);

        return $dataProvider;
    }
}