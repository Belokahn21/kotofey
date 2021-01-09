<?php
/* @var $form \yii\widgets\ActiveForm
 * @var $model \app\modules\promotion\models\entity\Promotion
 * @var $sliderImagesModel \app\modules\content\models\entity\SlidersImages
 * @var $subModel \app\modules\promotion\models\forms\PromotionProductMechanicsForm[]
 */

use app\modules\promotion\models\forms\PromotionProductMechanicsForm;

?>

<nav>
    <div class="nav nav-tabs" id="backendForms" role="tablist">
        <a class="nav-item nav-link active" id="nav-home-tab" data-toggle="tab" href="#nav-home" role="tab" aria-controls="nav-home" aria-selected="true">Основное</a>
    </div>
</nav>
<div class="tab-content" id="backendFormsContent">
    <div class="tab-pane fade show active" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab">
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

        <!--        --><?php //\app\modules\site\models\tools\Debug::p($subModel); ?>


        <?php foreach ($subModel as $iter => $item): ?>
            <div class="row">
                <div class="col-sm-3">
                    <?= $form->field($item, '[' . $iter . ']promotion_mechanic_id')->dropDownList($item->getMechanics(), ['onchange' => 'showRelatedFileds(this, ' . $iter . ');', 'prompt' => 'Выбрать механику']); ?>
                </div>


                <div class="<?= $item->promotion_mechanic_id ? '' : 'hidden'; ?> row col-sm-9" id="inputs-mechanic-<?= PromotionProductMechanicsForm::MECH_PRODUCT_DISCOUNT ?>-<?= $iter; ?>">
                    <div class="col-sm-3">
                        <?= $form->field($item, '[' . $iter . ']product_id')->textInput() ?>
                    </div>
                    <div class="col-sm-3">
                        <?= $form->field($item, '[' . $iter . ']discountRule')->dropDownList($item->getDiscountRules(), ['prompt' => 'Правило цены']); ?>
                    </div>
                    <div class="col-sm-3">
                        <?= $form->field($item, '[' . $iter . ']amount')->textInput(); ?>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>

<script type="text/javascript">
    function showRelatedFileds(e, iter) {
        let groupEl = document.querySelector('#inputs-mechanic-' + e.value + '-' + iter);
        if (groupEl) groupEl.classList.remove('hidden');
    }
</script>