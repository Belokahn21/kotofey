<?
/**
 * Developer: Konstantin Vasin by PhpStorm
 * Company: Altasib
 * Time: 12:32
 */

namespace app\models\entity;


use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;

class Payment extends ActiveRecord
{
    public function rules()
    {
        return [
            ['name', 'required', 'message' => '{attribute} должно быть заполнено'],

            ['description', 'string']
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
        ];
    }

    public function createPayment()
    {
        if ($this->load(\Yii::$app->request->post())) {
            if ($this->validate()) {
                return $this->save();
            }
        }
    }
}