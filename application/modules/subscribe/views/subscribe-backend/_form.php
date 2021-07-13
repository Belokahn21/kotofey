<?php

use yii\helpers\ArrayHelper;
use yii\helpers\Json;
use app\modules\media\models\entity\Media;
use app\modules\stock\models\entity\Stocks;
use app\modules\vendors\models\entity\Vendor;
use app\modules\catalog\models\entity\Offers;
use app\modules\catalog\models\entity\ProductOrder;
use app\modules\cdn\widgets\CdnInput\CdnInputWidget;
use app\modules\catalog\models\entity\PropertyGroup;
use app\modules\catalog\models\helpers\ProductHelper;
use app\modules\catalog\models\entity\ProductCategory;
use app\modules\site\models\helpers\ProductMarkupHelper;
use app\modules\catalog\models\entity\PropertiesVariants;
use app\modules\catalog\models\entity\TypeProductProperties;
use app\modules\catalog\models\entity\PropertiesProductValues;
use app\modules\media\widgets\InputUploadWidget\InputUploadWidget;

/* @var $model \app\modules\subscribe\models\entity\Subscribes
 * @var $form \yii\widgets\ActiveForm
 */

?>
<?php //= FillFromVendorWidget::widget(); ?>
<nav>
    <div class="nav nav-tabs" id="backendForms" role="tablist">
        <a class="nav-item nav-link active" id="nav-home-tab" data-toggle="tab" href="#nav-home" role="tab" aria-controls="nav-home" aria-selected="true">Основное</a>
    </div>
</nav>
<div class="tab-content" id="backendFormsContent">
    <div class="tab-pane fade show active" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab">
        <div class="row">
            <div class="col-sm-6">

                <div class="form-element">
                    <?= $form->field($model, 'email')->checkbox(); ?>
                </div>

                <div class="form-element">
                    <?= $form->field($model, 'email')->textInput(['placeholder' => 'E-Mail'])->label(false); ?>
                </div>

            </div>
        </div>

    </div>
</div>