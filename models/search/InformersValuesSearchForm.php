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
            [['value'], 'string'],
            [['informer_id'], 'string'],
        ];
    }

    public function scenarios()
    {
        return Model::scenarios();
    }
}