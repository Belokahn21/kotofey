<?

namespace app\models\search;

use app\models\entity\InformersValues;
use app\models\rbac\AuthItem;
use yii\base\Model;
use yii\data\ActiveDataProvider;

class InformersValuesSearchForm extends InformersValues
{

    public static function tableName()
    {
        return "informers_values";
    }

    public function rules()
    {
        return [
            [['informer_id', 'sort'], 'integer'],

            [['active'], 'boolean'],

            [['name', 'description'], 'string'],
        ];
    }

    public function scenarios()
    {
        return Model::scenarios();
    }


    public function search($params)
    {
        $query = self::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }

        $query->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'description', $this->description])
            ->andFilterWhere(['like', 'sort', $this->sort])
            ->andFilterWhere(['like', '$this->active', $this->active])
            ->andFilterWhere(['like', 'informer_id', $this->informer_id]);

        return $dataProvider;
    }

}