<?php

namespace app\modules\catalog\widgets\VisitedProducts;


use app\modules\catalog\models\entity\Product;
use app\modules\catalog\models\helpers\ProductHelper;
use app\modules\site\models\tools\Debug;
use yii\base\Widget;

class VisitedProductsWidget extends Widget
{
    public $view = 'default';
    public $limit = 5;

    public function run()
    {
        $visitedIDs = ProductHelper::getAllVisitedItems();
        $params = [];
        foreach ($visitedIDs as $i => $recipeId) $params[':id_' . $i] = $recipeId;

        $products = Product::find()
            ->where(['in', 'id', $visitedIDs])
            ->orderBy([new \yii\db\Expression('FIELD (id, ' . implode(',', array_reverse(array_keys($params))) . ')')])
            ->addParams($params)
            ->limit($this->limit)
            ->all();

        return $this->render($this->view, [
            'products' => $products
        ]);
    }
}