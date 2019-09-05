<? /**
 * Developer: Konstantin Vasin by PhpStorm
 * Company: Altasib
 * Time: 15:32
 */

namespace app\models\entity;


use yii\behaviors\SluggableBehavior;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;

/**
 * ProductProperties model
 *
 * @property integer $id
 * @property integer $active
 * @property integer $need_show
 * @property integer $sort
 * @property integer $type
 * @property integer $informer_id
 * @property string $name
 * @property string $slug
 * @property integer $created_at
 * @property integer $updated_at
 */
class ProductProperties extends ActiveRecord
{
    public static function tableName()
    {
        return "product_properties";
    }

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
            ['name', 'required', 'message' => 'Поле {attribute} должно быть заполнено'],

            [['active','need_show', 'sort', 'type', 'informer_id'], 'integer'],

            [['active'], 'default', 'value' => 1],

            [['need_show'], 'default', 'value' => 1],

            [['sort'], 'default', 'value' => 500],
        ];
    }

    public function attributeLabels()
    {
        return [
            'name' => 'Название',
            'active' => 'Активность',
            'need_show' => 'Выводить на сайте',
            'sort' => 'Сортировка',
            'type' => 'Тип',
            'informer_id' => 'ID справочника',
        ];
    }
}