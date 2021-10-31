<?php

use yii\helpers\Url;
use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use app\modules\site\models\tools\Currency;
use app\modules\order\widgets\map\MapWidget;
use app\modules\site\models\tools\PriceTool;
use \app\modules\user\models\helpers\UserHelper;
use app\modules\order\models\helpers\OrderHelper;
use app\modules\search\models\entity\SearchQuery;
use app\models\tool\parser\providers\SibagroTrade;
use app\modules\catalog\models\helpers\ProductHelper;
use app\modules\order\models\entity\OrderMailHistory;
use app\modules\acquiring\models\entity\AcquiringOrder;
use app\modules\catalog\models\helpers\PropertiesHelper;
use app\modules\order\widgets\BuyerInfo\BuyerInfoWidget;
use app\modules\acquiring\models\entity\AcquiringOrderCheck;
use app\modules\catalog\models\entity\ProductTransferHistory;
use app\modules\order\widgets\CustomerInput\CustomerInputWidget;
use app\modules\order\widgets\FastManagerMessage\FastManagerMessage;
use app\modules\delivery\widgets\ProfileTracking\ProfileTrackingWidget;

/* @var $model \app\modules\marketplace\models\entity\Marketplace
 * @var $form \yii\widgets\ActiveForm
 */


?>
<nav>
    <div class="nav nav-tabs" id="backendForms" role="tablist">
        <a class="nav-item nav-link" id="nav-generals-edit-tab" data-toggle="tab" href="#nav-generals-edit" role="tab" aria-controls="nav-generals-edit" aria-selected="false">Основное</a>
    </div>
</nav>


<div class="tab-content" id="backendFormsContent">
    <div class="tab-pane fade show active" id="nav-generals-edit" role="tabpanel" aria-labelledby="nav-generals-edit-tab">
        <div class="row">
            <div class="col-sm-3">
                <?= $form->field($model, 'is_active')->checkbox(); ?>
            </div>
            <div class="col-sm-3">
                <?= $form->field($model, 'sort')->textInput(['value' => 500]); ?>
            </div>
            <div class="col-sm-3">
                <?= $form->field($model, 'name'); ?>
            </div>
            <div class="col-sm-3">
                <?= $form->field($model, 'type_export_id')->dropDownList($model->getTypeExports(), ['prompt' => 'Выгрузка товаров']); ?>
            </div>
        </div>
    </div>
</div>