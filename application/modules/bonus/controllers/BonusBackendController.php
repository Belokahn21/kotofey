<?php

namespace app\modules\bonus\controllers;

use app\modules\bonus\models\entity\UserBonus;
use app\modules\bonus\models\entity\UserBonusHistory;
use app\modules\bonus\models\search\UserBonusHistorySearch;
use app\modules\bonus\models\search\UserBonusSearch;
use app\modules\order\models\entity\Order;
use app\modules\site\controllers\MainBackendController;
use app\modules\user\models\entity\User;
use app\widgets\notification\Alert;
use yii\helpers\ArrayHelper;
use yii\web\HttpException;

class BonusBackendController extends MainBackendController
{
    public $modelClass = 'app\modules\bonus\models\entity\UserBonus';

    public function actionIndex()
    {
        $model = new $this->modelClass();
        $searchModel = new UserBonusSearch();
        $dataProvider = $searchModel->search(\Yii::$app->request->get());
        $availablePhones = ArrayHelper::map(User::find()->where(['not in', 'phone', ArrayHelper::getColumn(UserBonus::find()->select(['phone'])->all(), 'phone')])->all(), 'phone', 'phone');

        if (\Yii::$app->request->isPost) {
            if ($model->load(\Yii::$app->request->post())) {
                if ($model->validate() && $model->save()) {
                    Alert::setSuccessNotify('Элемент успешно добавлен');
                    return $this->refresh();
                }
            }
        }

        return $this->render('index', [
            'model' => $model,
            'searchModel' => $searchModel,
            'availablePhones' => $availablePhones,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionUpdate($id)
    {
        if (!$model = $this->modelClass::findOne($id)) throw new HttpException(404, 'Элемент не найден');
        $availablePhones = ArrayHelper::map(User::find()->where(['not in', 'phone', ArrayHelper::getColumn(UserBonus::find()->select(['phone'])->all(), 'phone')])->all(), 'phone', 'phone');

        if (\Yii::$app->request->isPost) {
            if ($model->load(\Yii::$app->request->post())) {
                if ($model->validate() && $model->update()) {
                    Alert::setSuccessNotify('Элемент успешно обновлен');
                    return $this->refresh();
                }
            }
        }

        return $this->render('update', [
            'model' => $model,
            'availablePhones' => $availablePhones,
        ]);
    }

    public function actionDelete($id)
    {
        if (!$model = $this->modelClass::findOne($id)) throw new HttpException(404, 'Элемент не найден');

        if ($model->delete()) Alert::setSuccessNotify('Элемент успешно удалён');

        return $this->redirect(['index']);
    }
}
