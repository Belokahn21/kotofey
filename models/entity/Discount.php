<?
/**
 * Developer: Konstantin Vasin by PhpStorm
 * Company: Altasib
 * Time: 17:53
 */

namespace app\models\entity;


use yii\db\ActiveRecord;

/**
 * Discount model
 *
 * @property integer $id
 * @property integer $user_id
 * @property float $count
 */
class Discount extends ActiveRecord
{
    const MAX_DISCOUNT = 15;    // максимальное количество скидки

    const COUNT_DISCOUNT_FOR_REVIEW = 1.25;
    const COUNT_DISCOUNT_FOR_ORDER = 1.25;

    public function rules()
    {
        return [
            [['count', 'user_id'], 'required', 'message' => '{attribute} поле должно быть заполнено'],
            ['user_id', 'default', 'value' => \Yii::$app->user->identity->id],
        ];
    }

    public function addDiscountForOrder()
    {
        $this->count += self::COUNT_DISCOUNT_FOR_ORDER;

        if (($this->count) > self::MAX_DISCOUNT) {
            $this->count = self::MAX_DISCOUNT;
        }

        return $this->update();
    }

    public function addDiscountForReview()
    {
        $this->count += self::COUNT_DISCOUNT_FOR_REVIEW;

        if (($this->count) > self::MAX_DISCOUNT) {
            $this->count = self::MAX_DISCOUNT;
        }

        return $this->update();
    }

    public static function findByUserId($userId)
    {
        return static::findOne(['user_id' => $userId]);
    }
}