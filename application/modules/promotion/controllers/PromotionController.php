<?php


namespace app\modules\promotion\controllers;


use app\modules\promotion\models\entity\Promotion;
use app\modules\promotion\models\entity\PromotionProductMechanics;
use app\modules\promotion\models\helpers\PromotionHelper;
use yii\web\Controller;
use yii\web\HttpException;

class PromotionController extends Controller
{
    public function actionIndex()
    {
        $models = PromotionHelper::getActualPromotions();


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