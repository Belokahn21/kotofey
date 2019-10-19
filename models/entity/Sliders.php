<?

namespace app\models\entity;


use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;

class Sliders extends ActiveRecord
{
    public function behaviors()
    {
        return [
            TimestampBehavior::className()
        ];
    }

    public function rules()
    {
        return [];
    }

    public function attributeLabels()
    {
        return [
            'name' => 'Название',
            'link' => 'Ссылка',
            'active' => 'Активность',
            'sort' => 'Сортировка',
        ];
    }
}