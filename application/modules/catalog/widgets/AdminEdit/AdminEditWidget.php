<?php

namespace app\modules\catalog\widgets\AdminEdit;


use app\modules\site\models\tools\Debug;
use app\modules\catalog\models\entity\Category;
use app\modules\catalog\models\entity\Product;
use app\modules\stock\models\entity\Stocks;
use app\modules\user\models\entity\User;
use app\modules\vendors\models\entity\Vendor;
use yii\bootstrap\Widget;

class AdminEditWidget extends Widget
{
    public $view = 'default';

    public function run()
    {
        if (!$this->isProductAction() or !$this->hasRoleAccess()) {
            return false;
        }

        if (!$slug = $this->getProductSlug()) {
            return false;
        }

        $model = Product::findOneBySlug($slug);

        if (!$model) {
            return false;
        }

        $vendors = Vendor::find()->all();
        $stocks = Stocks::find()->all();

        return $this->render($this->view, [
            'model' => $model,
            'vendors' => $vendors,
            'stocks' => $stocks,
        ]);
    }

    public function isProductAction()
    {
        return \Yii::$app->controller->getRoute() === "catalog/product/view";
    }

    public function hasRoleAccess()
    {
        return User::isRole('Developer');
    }

    public function getProductSlug()
    {
        if (array_key_exists('id', \Yii::$app->controller->actionParams)) {
            return \Yii::$app->controller->actionParams['id'];
        }

        return false;
    }
}