<?
/**
 * Developer: Konstantin Vasin by PhpStorm
 * Company: Altasib
 * Time: 18:22
 */

namespace app\models\entity;


use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;

class ProductReviews extends ActiveRecord
{
    public static function tableName()
    {
        return "product_reviews";
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
            [['text', 'product'], 'required', 'message' => '{attribute} поле должно быть заполнено'],
            [['text'], 'string'],

            [['product', 'user_id'], 'integer'],

            [['user_id'], 'default', 'value' => \Yii::$app->user->identity->id],
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

    public function canCreateReview($product)
    {
        if ($product instanceof Product) {
            $result = \Yii::$app->db->createCommand("
            select * from `orders`,`order_items`
            where `orders`.`user`='" . \Yii::$app->user->identity->id . "'
            and `orders`.`paid`='1'
            and `order_items`.`orderId`=`orders`.`id`
            and `order_items`.`productId`='" . $product->id . "'
            ")->queryAll();

            return (empty($result)) ? false : true;
        }
    }

    public function needPay($product)
    {
        if ($product instanceof Product) {
            $sql = "
            select * from `orders`,`order_items`,`product_reviews`
            where `orders`.`user`='" . \Yii::$app->user->identity->id . "'
            and `order_items`.`orderId`=`orders`.`id`
            and `product_reviews`.`paid`='1'
            and `order_items`.`productId`=`product_reviews`.`product`
            and `order_items`.`productId`='" . $product->id . "'
            ";

            $result = \Yii::$app->db->createCommand($sql)->queryAll();

            return empty($result) ? true : false;
        }
    }

}