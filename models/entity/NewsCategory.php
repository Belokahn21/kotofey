<?
/**
 * Developer: Konstantin Vasin by PhpStorm
 * Company: Altasib
 * Time: 11:10
 */

namespace app\models\entity;


use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;

/**
 * PagesCategory model
 *
 * @property integer $id
 * @property string $name
 * @property integer $sort
 * @property integer $parent
 * @property integer $created_at
 * @property integer $updated_at
 */
class NewsCategory extends ActiveRecord
{
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

            ['name', 'string'],

            ['parent', 'default', 'value' => 0],

            ['sort', 'default', 'value' => 500],

            [['parent'], 'integer'],
        ];
    }

    public static function tableName()
    {
        return "pages_category";
    }

    public function attributeLabels()
    {
        return [
            'name' => 'Название',
            'sort' => 'Сортировка',
            'parent' => 'Родительский раздел',
            'created_at' => 'Дата создания',
        ];
    }

}