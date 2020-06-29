<?php

namespace app\widgets\product_reviews;


use app\modules\catalog\models\entity\Product;
use app\models\entity\ProductReviews;
use app\models\tool\Debug;
use app\widgets\notification\Alert;
use yii\base\Widget;

/**
 * ProductReviewsWidget model
 *
 * @property Product $product
 */
class ProductReviewsWidget extends Widget
{
	public $product;

	public function run()
	{
		if (!$this->product instanceof Product) {
			return false;
		}
		$reviews = ProductReviews::find()->where(['product_id' => $this->product->id])->all();
		$model = new ProductReviews();
		if (\Yii::$app->request->isPost && \Yii::$app->request->post($model->formName())) {
			$model->product_id = $this->product->id;
			if ($model->load(\Yii::$app->request->post())) {
				if ($model->validate()) {
					if ($model->save()) {
						Alert::setSuccessNotify('Отзыв успешно добавлен');
						\Yii::$app->controller->refresh();
					}
				}
			}
		}
		return $this->render('default', [
			'reviews' => $reviews,
			'model' => $model,
		]);
	}
}