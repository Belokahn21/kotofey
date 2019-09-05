<?

namespace app\models\search;

use app\models\entity\Category;
use app\models\entity\Informers;
use app\models\entity\Product;
use yii\base\Model;
use yii\data\ActiveDataProvider;

class InformersSearchForm extends Informers
{
    public static function tableName()
    {
        return "informers";
    }

    public function rules()
    {
        return [
            [['id'], 'integer'],
            [['name'], 'string'],
        ];
    }

    public function scenarios()
    {
        return Model::scenarios();
    }

    public function search($params)
    {
        $query = Informers::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }

        $query->andFilterWhere(['like', 'id', $this->id])
            ->andFilterWhere(['like', 'name', $this->name]);

        return $dataProvider;
    }
}