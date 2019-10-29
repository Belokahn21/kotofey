<?

namespace app\models\entity;


use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;

class Delivery extends ActiveRecord
{
    public function rules()
    {
        return [
            ['name', 'required', 'message' => '{attribute} должно быть заполнено'],

            ['description', 'string'],

            ['active', 'boolean'],
        ];
    }

    public function behaviors()
    {
        return [
            TimestampBehavior::className()
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => "ID",
            'name' => "Нвазвание",
            'description' => "Описаниие",
            'active' => "Активность",
        ];
    }

    public function createDelivery()
    {
        if ($this->load(\Yii::$app->request->post())) {
            if ($this->validate()) {
                return $this->save();
            }
        }
    }
}