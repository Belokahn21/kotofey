<?

namespace app\models\entity;


use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;

class Selling extends ActiveRecord
{
    public function behaviors()
    {
        return [
            TimestampBehavior::className()
        ];
    }

    public function attributeLabels()
    {
        return [
            'summ'=>'Сумма'
        ];
    }
}