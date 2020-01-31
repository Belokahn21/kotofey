<?php
/**
 * Developer: Konstantin Vasin by PhpStorm
 * Company: Altasib
 * Time: 0:51
 */

namespace app\models\entity\support;


use yii\behaviors\TimestampBehavior;
use yii\data\ActiveDataProvider;
use yii\db\ActiveRecord;

/**
 * Tickets model
 *
 * @property integer $id
 * @property integer $user_id
 * @property integer $category_id
 * @property integer $status_id
 * @property boolean $is_close
 * @property string $title
 * @property string $text
 * @property integer $created_at
 * @property integer $updated_at
 *
 * @property SupportCategory $category
 * @property string $detail
 */
class Tickets extends ActiveRecord
{
    public static function tableName()
    {
        return "support_ticket";
    }

    public function behaviors()
    {
        return [
            TimestampBehavior::className(),
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => 'ID автора',
            'category_id' => 'Категория',
            'status_id' => 'Статус',
            'title' => 'Тема обращения',
            'text' => 'Текст обращения',
        ];
    }

    public function rules()
    {
        return [
            [['title', 'text'], 'required', 'message' => 'Поле {attribute} должно быть заполнено'],

            [['title', 'text'], 'string'],

            ['user_id', 'default', 'value' => \Yii::$app->user->identity->id],

            ['is_close', 'default', 'value' => 0],

            ['status_id', 'default', 'value' => 0],

            [['user_id', 'category_id'], 'integer'],


        ];
    }

    public function getCategory()
    {
        return SupportCategory::findOne($this->category_id);
    }

    public function getDetail()
    {
        return sprintf("/support/%s/%s/", $this->category_id, $this->id);
    }
}