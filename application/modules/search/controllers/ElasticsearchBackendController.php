<?php

namespace app\modules\search\controllers;

use app\modules\catalog\models\entity\Product;
use app\modules\catalog\models\entity\virtual\ProductElastic;
use app\modules\site\controllers\MainBackendController;
use app\modules\user\models\tool\BehaviorsRoleManager;
use app\widgets\notification\Alert;

class ElasticsearchBackendController extends MainBackendController
{
    public function behaviors()
    {
        $parentAccess = parent::behaviors();

        BehaviorsRoleManager::extendRoles($parentAccess['access']['rules'], [
            ['allow' => true, 'actions' => ['re-index',], 'roles' => ['Administrator']]
        ]);

        return $parentAccess;
    }

    public function actionIndex()
    {
        return $this->render('index');
    }

    public function actionReIndex()
    {
        $count_all_success = 0;
        $count_all_products = 0;
        ProductElastic::deleteIndex();
        ProductElastic::createIndex();
        $models = Product::find()->all();
        foreach ($models as $model) {
            $el = new ProductElastic();
            $el->fillAttributes($model);
            $status = $el->insert();
            if ($status) $count_all_success++;
        }

        Alert::setSuccessNotify("Индекс {$count_all_success} из {$count_all_products} элементов успешно пересоздан.");
        return $this->redirect(['index']);
    }
}