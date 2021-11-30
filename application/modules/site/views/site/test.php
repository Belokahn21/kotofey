<div class="set-weight-react" data-product-id="74"></div>


<?php
foreach (\app\modules\basket\models\entity\Basket::findAll() as $basketItem) {
    echo "<hr>";
    \app\modules\site\models\tools\Debug::p($basketItem->getName());
    \app\modules\site\models\tools\Debug::p(\app\modules\site\models\tools\PriceTool::format($basketItem->getPrice()));
    \app\modules\site\models\tools\Debug::p($basketItem->getWeight());
    echo "<hr>";
}
?>