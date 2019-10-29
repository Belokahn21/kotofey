<?

namespace app\models\search;

use app\models\entity\Product;
use yii\base\Model;
use yii\data\ActiveDataProvider;

class ProductSearchForm extends Product
{

    public static function tableName()
    {
        return "product";
    }

    public function rules()
    {
        return [
            [['id'], 'integer'],
            [['name', 'code'], 'string'],
        ];
    }

    public function scenarios()
    {
        return Model::scenarios();
    }

    public function search($params)
    {
        $query = Product::find()->orderBy(['created_at' => SORT_DESC]);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 10,
            ],
        ]);

        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }

        $query->andFilterWhere(['like', 'id', $this->id])
            ->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'code', $this->code]);

        return $dataProvider;
    }
}