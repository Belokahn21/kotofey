<?php
/* @var $form \yii\widgets\ActiveForm
 * @var $model \app\modules\promotion\models\entity\Promotion
 * @var $sliderImagesModel \app\modules\content\models\entity\SlidersImages
 * @var $subModel \app\modules\promotion\models\entity\PromotionProductMechanics
 */

use yii\helpers\Html;
use app\modules\promotion\models\entity\PromotionProductMechanics;


?>

<?= $xstring; ?>

<nav>
    <div class="nav nav-tabs" id="backendForms" role="tablist">
        <a class="nav-item nav-link active" id="nav-home-tab" data-toggle="tab" href="#nav-home" role="tab" aria-controls="nav-home" aria-selected="true">Основное</a>
    </div>
</nav>
<div class="tab-content" id="backendFormsContent">
    <div class="tab-pane fade show active" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab">
        <?= $form->field($model, 'save')->checkbox(); ?>
        <div class="form-element">
            <?= $form->field($model, 'name') ?>
        </div>
        <div class="row">
            <div class="form-element col-sm-6">
                <?= $form->field($model, 'start_at')->textInput(['class' => 'form-control js-datepicker']); ?>
            </div>
            <div class="form-element col-sm-6">
                <?= $form->field($model, 'end_at')->textInput(['class' => 'form-control js-datepicker']); ?>
            </div>
        </div>

        <div class="row">


            <div class="col-sm-3">
                <?= $form->field($subModel, 'promotion_mechanic_id')->dropDownList($subModel->getMechanics(), ['onchange' => '$(".btn-main").click();', 'prompt' => 'Выбрать механику']); ?>
            </div>


            <?php if ($subModel->promotion_mechanic_id == PromotionProductMechanics::MECH_PRODUCT_DISCOUNT): ?>
                <div class="col-sm-3">
                    <?= $form->field($subModel, 'product_id')->textInput() ?>
                </div>
                <div class="col-sm-3">
                    <?= $form->field($subModel, 'discountRule')->dropDownList(['Процент', 'Новая цена']); ?>
                </div>
                <div class="col-sm-3">
                    <?= $form->field($subModel, 'amount')->textInput(); ?>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>