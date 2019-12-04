<?php
/**
 * Developer: Konstantin Vasin by PhpStorm
 * Company: Altasib
 * Time: 0:12
 */

namespace app\models\entity\support;

use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;

/**
 * SupportCategory model
 *
 * @property integer $id
 * @property string $name
 * @property integer $sort
 * @property string $html
 * @property string $description
 * @property integer $created_at
 * @property integer $updated_at
 *
 * @property string $detail
 */
class SupportCategory extends ActiveRecord
{
    public static function tableName()
    {
        return "support_category";
    }

    public function rules()
    {
        return [
            [['name'], 'required', 'message' => 'Поле {attribute} должно быть заполнено'],
            [['sort'], 'integer'],
            [['description', 'name', 'html'], 'string'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'name' => 'Название',
            'description' => 'Описание',
            'sort' => 'Сортировка',
            'html' => 'HTML вид',
        ];
    }

    public function behaviors()
    {
        return [
            TimestampBehavior::className()
        ];
    }

    public function countTickets()
    {
        return Tickets::find()->where(['category_id' => $this->id])->andWhere(['user_id' => \Yii::$app->user->identity->id])->count();
    }

    public function getDetail()
    {
        return sprintf("/support/%s/", $this->id);
    }
}