<?
/**
 * Developer: Konstantin Vasin by PhpStorm
 * Company: Altasib
 * Time: 19:41
 */

namespace app\models\entity;


use yii\db\ActiveRecord;

class OrderStatus extends ActiveRecord
{
    public static function tableName()
    {
        return "status_order";
    }

    public function rules()
    {
        return [
            ['name', 'string'],
            ['name', 'required', 'message' => '{attribute} должно быть заполнено'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'name' => "Название"
        ];
    }

    public function createStatus()
    {
        if ($this->load(\Yii::$app->request->post())) {
            if ($this->validate()) {
                return $this->save();
            }
        }
    }
}