<?php

namespace app\modules\promotion\controllers;

use app\modules\content\models\entity\SlidersImages;
use app\modules\promotion\models\entity\Promotion;
use app\modules\promotion\models\search\PromotionSearch;
use yii\web\Controller;

class PromotionBackendController extends Controller
{
    public $layout = '@app/views/layouts/admin';

    public function actionIndex()
    {
        $model = new Promotion();
        $sliderImagesModel = new SlidersImages();
        $searchModel = new PromotionSearch();
        $dataProvider = $searchModel->search(\Yii::$app->request->get());
        return $this->render('index', [
            'model' => $model,
            'sliderImagesModel' => $sliderImagesModel,
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }
}
