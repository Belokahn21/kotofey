<?php

namespace app\modules\promotion\controllers;

use app\modules\promotion\models\entity\Promotion;
use app\modules\promotion\models\entity\PromotionProductMechanics;
use app\modules\promotion\models\search\PromotionSearch;
use app\modules\site\models\tools\Debug;
use app\widgets\notification\Alert;
use yii\web\Controller;
use yii\web\HttpException;

class PromotionBackendController extends Controller
{
    public $layout = '@app/views/layouts/admin';
    public $modelClass = 'app\modules\promotion\models\entity\Promotion';

    public function actionIndex()
    {
        $model = new $this->modelClass();
        $searchModel = new PromotionSearch();
        $dataProvider = $searchModel->search(\Yii::$app->request->get());
        $subModel = new \app\modules\promotion\models\entity\PromotionProductMechanics();
        $xstring = null;

        if (\Yii::$app->request->isPjax) {
            $model->load(\Yii::$app->request->post());
            $subModel->load(\Yii::$app->request->post());

            if ($model->save) {
                if (!$model->validate() or !$model->save()) {
                    Debug::p($model->getErrors());
                    Alert::setErrorNotify('Ошибка №1');
                    return $this->refresh();
                }

                $subModel->promotion_id = $model->id;
                if (!$subModel->validate() or !$subModel->save()) {
                    Alert::setErrorNotify('Ошибка №2');
                    return $this->refresh();
                }


                Alert::setSuccessNotify('Акция успешно сохранена');
                return $this->refresh();
            }

            $xstring = $model->name;
        }

        return $this->render('index', ['model' => $model,
            'subModel' => $subModel,
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'xstring' => $xstring
        ]);
    }

    public function actionUpdate($id)
    {
        if (!$model = $this->modelClass::findOne($id)) throw new HttpException(404, 'Элемент не найден');

        $subModel = PromotionProductMechanics::findOne(['promotion_id' => $model->id]);

        if (\Yii::$app->request->isPjax) {
            $model->load(\Yii::$app->request->post());
            $subModel->load(\Yii::$app->request->post());


            if ($model->save) {
                if (!$model->validate() or !$model->update()) {
                    Debug::p($model->getErrors());
                    Alert::setErrorNotify('Ошибка №1');
                    return $this->refresh();
                }

                $subModel->promotion_id = $model->id;
                if (!$subModel->validate() or !$subModel->update()) {
                    Alert::setErrorNotify('Ошибка №2');
                    return $this->refresh();
                }


                Alert::setSuccessNotify('Акция успешно сохранена');
                return $this->refresh();
            }
        }

        return $this->render('update', ['model' => $model,
            'subModel' => $subModel,
        ]);
    }

    public function actionDelete($id)
    {
        if (!$model = $this->modelClass::findOne($id)) throw new HttpException(404, 'Элемент не найден');
    }
}
