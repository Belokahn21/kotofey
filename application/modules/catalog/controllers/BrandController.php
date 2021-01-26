<?php

namespace app\modules\catalog\controllers;


use app\modules\catalog\models\entity\PropertiesVariants;
use yii\web\Controller;
use yii\web\HttpException;

class BrandController extends Controller
{
    public $modelClass = 'app\modules\catalog\models\entity\PropertiesVariants';
    public $property_id = 1;

    /**
     * @var $models PropertiesVariants[]
     */
    public function actionIndex()
    {
        $models = $this->modelClass::find()->where(['property_id' => $this->property_id])->all();

        return $this->render('index', [
            'models' => $models
        ]);
    }

    /**
     * @var $model PropertiesVariants
     */
    public function actionView($id)
    {
        if (!$model = $this->modelClass::findOne(['slug' => $id, 'property_id' => $this->property_id])) throw new HttpException(404, 'Страица не найдена');
        $view = 'view';

        if ($model->view) $view = $model->view;

        return $this->render($view, [
            'model' => $model
        ]);
    }
}