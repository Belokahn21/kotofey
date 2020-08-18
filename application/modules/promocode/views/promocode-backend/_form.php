<?php

use app\modules\catalog\models\entity\ProductOrder;
use app\modules\site_settings\models\entity\SiteSettings;
use app\modules\stock\models\entity\Stocks;
use yii\helpers\ArrayHelper;
use app\modules\catalog\models\entity\Category;
use app\modules\catalog\models\entity\InformersValues;
use app\modules\catalog\models\entity\ProductPropertiesValues;
use yii\helpers\Json;
use app\modules\vendors\models\entity\Vendor;
use app\modules\settings\models\helpers\MarkupHelpers;

/* @var $model \app\modules\catalog\models\entity\Product */
/* @var $modelDelivery \app\modules\catalog\models\entity\ProductOrder */
/* @var $properties \app\modules\catalog\models\entity\ProductProperties[] */

?>
<nav>
    <div class="nav nav-tabs" id="nav-tab" role="tablist">
        <a class="nav-item nav-link active" id="nav-home-tab" data-toggle="tab" href="#nav-home" role="tab" aria-controls="nav-home" aria-selected="true">Основное</a>
    </div>
</nav>
<div class="tab-content" id="nav-tab-content-form">
    <div class="tab-pane fade show active" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab">
        <div class="form-element">
			<?= $form->field($model, 'code')->textInput(['placeholder' => 'Промокод'])->label(false); ?>
        </div>
        <div class="form-element">
			<?= $form->field($model, 'discount')->textInput(['placeholder' => 'Скидка (-%)'])->label(false); ?>
        </div>
        <div class="form-element">
			<?= $form->field($model, 'count')->textInput(['placeholder' => 'Количество'])->label(false); ?>
        </div>
    </div>
</div>