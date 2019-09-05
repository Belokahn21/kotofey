<?

namespace app\models\entity;


use yii\behaviors\SluggableBehavior;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;

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
}