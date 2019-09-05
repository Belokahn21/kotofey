<?
/**
 * Developer: Konstantin Vasin by PhpStorm
 * Company: Altasib
 * Time: 14:22
 */

namespace app\models\entity;


use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;

class SiteReviews extends ActiveRecord
{
    public static function tableName()
    {
        return "site_reviews";
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
            ['text', 'required', 'message' => 'Пожалуйста заполните {attribute} '],
            ['text', 'string'],

            ['user_id', 'default', 'value' => \Yii::$app->user->identity->id]
        ];
    }

    public function attributeLabels()
    {
        return [
            'text' => "Ваш отзыв"
        ];
    }

    public function getUser()
    {
        return User::findOne($this->user_id);
    }

    public function create()
    {
        if ($this->load(\Yii::$app->request->post())) {
            if ($this->validate()) {
                return $this->save();
            }
        }

        return false;
    }
}