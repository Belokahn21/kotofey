<?
/**
 * Developer: Konstantin Vasin by PhpStorm
 * Company: Altasib
 * Time: 18:24
 */

namespace app\widgets\reviews_product;

use app\models\entity\Discount;
use app\models\entity\ProductReviews;
use app\widgets\notification\Notify;

class ReviewsProduct extends \yii\base\Widget
{
    public $product;

    public function run()
    {
        $model = new ProductReviews();
        $reviews = ProductReviews::find()->where(['product' => $this->product->id])->all();


        if (\Yii::$app->request->isPost) {
            if ($model->load(\Yii::$app->request->post())) {
                $model->product = $this->product->id;
                if ($model->validate()) {
                    if ($model->save()) {

                        $reviewId = \Yii::$app->db->lastInsertID;

                        if ($model->needPay($this->product)) {

                            $discount = Discount::findByUserId(\Yii::$app->user->identity->id);
                            $discount->addDiscountForReview();

                            if ($discount->save()) {

                                $productReview = ProductReviews::findOne($reviewId);
                                $productReview->paid = true;
                                $productReview->update();

                            }

                        }
                        Notify::setSuccessNotify("Отзыв успешно оставлен!");
                        \Yii::$app->controller->redirect(\Yii::$app->request->url);
                    }
                }
            }
        }

        return $this->render('default', [
            'model' => $model,
            'reviews' => $reviews,
            'product' => $this->product,
        ]);
    }
}