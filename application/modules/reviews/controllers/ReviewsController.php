<?php


namespace app\modules\reviews\controllers;

use app\modules\catalog\models\entity\Product;
use Yii;
use yii\web\Controller;
use app\widgets\notification\Alert;
use app\modules\reviews\models\entity\Reviews;

class ReviewsController extends Controller
{
    public function actionCreate()
    {
        $model = new Reviews();

        if (Yii::$app->request->isPost) {
            if ($model->load(Yii::$app->request->post())) {
                if ($model->validate() && $model->save()) {
                    Yii::$app->cache->delete('reviews_product_' . $model->product_id);
                    Alert::setSuccessNotify('Ваш отзыв успешно добавлен.');
                }
            }
        }

        $product = Product::findOne($model->product_id);

        return $this->redirect(['/catalog/product/view', 'id' => $product->slug]);
    }
}