<?php

use app\modules\marketplace\models\entity\MarketplaceProduct;
use app\modules\marketplace\models\repository\MarketplaceRepository;
use app\modules\marketplace\models\helpers\MarketplaceProductHelper;
use app\modules\marketplace\models\repository\MarketplaceProductRepository;

/* @var $model \app\modules\catalog\models\entity\Product */

$marketplace_model = new MarketplaceProduct();
$marketplaces = MarketplaceRepository::getActiveMarketplaces();
$product_id = $model->id;

$marketplace_values = MarketplaceProductRepository::getAllForProduct($product_id);
?>


<?php foreach ($marketplaces as $count => $marketplace): ?>

    <?php
    $params = ['value' => $marketplace->id];

    if (MarketplaceProductHelper::getValue($marketplace_values, $product_id, $marketplace->id)) {
        $params['checked'] = true;
    }

    ?>

    <div class="row">
        <div class="col-sm-12">
            <?= $form->field($marketplace_model, '[' . $count . ']marketplace_id')->checkbox($params)->label($marketplace->name); ?>
        </div>
    </div>
<?php endforeach; ?>
