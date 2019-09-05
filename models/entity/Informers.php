<?

namespace app\models\entity;


use yii\behaviors\SluggableBehavior;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;

class Informers extends ActiveRecord
{
    public function behaviors()
    {
        return [
            TimestampBehavior::className(),
            [
                'class' => SluggableBehavior::className(),
                'attribute' => 'name',
                'ensureUnique' => true,
            ],
        ];
    }

    public function rules()
    {
        return [
            [['name'], 'required', 'message' => 'Поле {attribute} обязательно'],

            [['description'], 'string']
        ];
    }

    public function attributeLabels()
    {
        return [
            'name' => 'Название',
            'sort' => 'Сортировка',
            'slug' => 'Символьный код',
            'description' => 'Описание',
            'id' => 'ID',
        ];
    }
}