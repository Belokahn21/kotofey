<?
/**
 * Developer: Konstantin Vasin by PhpStorm
 * Company: Altasib
 * Time: 0:58
 */

namespace app\models\entity;


use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;

class TodoList extends ActiveRecord
{
    public static function tableName()
    {
        return "todo_list";
    }

    public function behaviors()
    {
        return [
            TimestampBehavior::className()
        ];
    }

    public function rules()
    {
        return [
            [['name'], 'required', 'message' => '{attribute} должно быть заполнено'],

            [['description'], 'string'],

            [['close'], 'default', 'value' => false],
        ];
    }

    public function attributeLabels()
    {
        return [
            'name' => "Название",
            'description' => "Описание",
            'close' => "Закрыто",
        ];
    }

    public function create()
    {
        if ($this->load(\Yii::$app->request->post())) {
            if ($this->validate()) {
                return $this->save();
            }
        }
    }
}