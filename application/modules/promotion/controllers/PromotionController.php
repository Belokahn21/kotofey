<?php


namespace app\modules\promotion\controllers;


use app\modules\promotion\models\entity\Promotion;
use app\modules\promotion\models\entity\PromotionProductMechanics;
use yii\web\Controller;
use yii\web\HttpException;

class PromotionController extends Controller
{
    public function actionIndex()
    {
        $unix_now = time();
        $models = Promotion::find()->where(['is_active' => true])->andWhere([
            'or',
            'start_at = :default and end_at = :default',
            'start_at is null and end_at is null',
            'start_at < :now and end_at > :now'
        ])
            ->addParams([
                ":now" => $unix_now,
                ":default" => 0,
            ])->all();
        return $this->render('index', [
            'models' => $models
        ]);
    }

    public function actionView($id)
    {
        if (!$model = Promotion::findOneBySlug($id)) throw new HttpException(404, 'Элемент не найден');

        $products = PromotionProductMechanics::find()->where(['promotion_id' => $model->id])->all();

        return $this->render('view', [
            'model' => $model,
            'products' => $products
        ]);
    }
}