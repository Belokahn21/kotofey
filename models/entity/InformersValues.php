<?

namespace app\models\entity;


use yii\behaviors\SluggableBehavior;
use yii\behaviors\TimestampBehavior;
use yii\data\ActiveDataProvider;
use yii\db\ActiveRecord;

/**
 * InformersValues model
 *
 * @property integer $id
 * @property integer $informer_id
 * @property string $value
 * @property string $description
 */
class InformersValues extends ActiveRecord
{
    public function rules()
    {
        return [
            [['informer_id', 'value'], 'required', 'message' => 'Поле {attribute} обязательно'],

            [['informer_id'], 'integer'],

            [['value', 'description'], 'string'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'informer_id' => 'Справочник',
            'value' => 'Значение',
            'description' => 'Описание',
        ];
    }


    public function search($params)
    {
        $query = static::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }

        $query->andFilterWhere(['like', 'value', $this->value])
            ->andFilterWhere(['like', 'informer_id', $this->informer_id]);

        return $dataProvider;
    }
}