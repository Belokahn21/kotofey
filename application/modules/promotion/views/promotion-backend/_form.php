<?php
/* @var $form \yii\widgets\ActiveForm
 * @var $model \app\modules\promotion\models\entity\Promotion
 * @var $sliderImagesModel \app\modules\content\models\entity\SlidersImages
 * @var $subModel \app\modules\promotion\models\forms\PromotionProductMechanicsForm[]
 */

use yii\helpers\Url;
use  yii\helpers\Html;
use yii\helpers\ArrayHelper;
use app\modules\order\models\entity\Order;
use app\modules\order\models\entity\OrdersItems;
use app\modules\promotion\models\helpers\PromotionHelper;
use app\modules\media\widgets\MediaBrowser\MediaBrowserWidget;
use app\modules\promotion\models\forms\PromotionProductMechanicsForm;
use app\modules\order\widgets\FindProductsWidgets\FindProducstWidgets;
use app\modules\promotion\models\entity\PromotionProductMechanics;

?>

<nav>
    <div class="nav nav-tabs" id="backendForms" role="tablist">
        <a class="nav-item nav-link active" id="nav-home-tab" data-toggle="tab" href="#nav-home" role="tab" aria-controls="nav-home" aria-selected="true">Основное</a>
        <a class="nav-item nav-link" id="nav-items-tab" data-toggle="tab" href="#nav-items" role="tab" aria-controls="nav-items" aria-selected="true">Товары</a>
        <?php if (!$model->isNewRecord): ?>
            <a class="nav-item nav-link" id="nav-members-mail-tab" data-toggle="tab" href="#nav-members-mail" role="tab" aria-controls="nav-members-mail" aria-selected="true">Участники</a>
        <?php endif; ?>
    </div>
</nav>
<div class="tab-content" id="backendFormsContent">
    <div class="tab-pane fade show active" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab">
        <div class="form-element">
            <?= $form->field($model, 'is_active')->checkbox(); ?>
        </div>
        <div class="form-element">
            <?= $form->field($model, 'name') ?>
        </div>
        <div class="form-element">
            <?= $form->field($model, 'sort') ?>
        </div>
        <div class="form-element">
            <?php if ($model->media_id): ?>
                <img src="<?= PromotionHelper::getImageUrl($model) ?>" width="150" title="<?= $model->name; ?>" alt="<?= $model->name; ?>">
            <?php endif; ?>
            <?php
            $media_params = [];
            if ($model->media_id) {
                $media_params = [
                    'values' => [$model->media_id]
                ];
            }
            echo $form->field($model, 'media_id')->widget(MediaBrowserWidget::className(), $media_params);
            ?>
        </div>
        <div class="row">
            <div class="form-element col-sm-6">
                <?= $form->field($model, 'start_at')->textInput(['class' => 'form-control js-datepicker']); ?>
            </div>
            <div class="form-element col-sm-6">
                <?= $form->field($model, 'end_at')->textInput(['class' => 'form-control js-datepicker']); ?>
            </div>
        </div>
    </div>
    <div class="tab-pane fade" id="nav-items" role="tabpanel" aria-labelledby="nav-items-tab">
        <?php $subIter = 0; ?>
        <?php if (is_array($subModel) && count($subModel) > 0): ?>
            <?php foreach ($subModel as $iter => $item): ?>
                <div class="row">
                    <div class="col-sm-3">
                        <?= $form->field($item, '[' . $iter . ']promotion_mechanic_id')->dropDownList($item->getMechanics(), ['onchange' => 'showRelatedFileds(this, ' . $iter . ');', 'prompt' => 'Выбрать механику']); ?>
                    </div>
                    <div class="<?= $item->promotion_mechanic_id ? '' : 'hidden'; ?> row col-sm-9" id="inputs-mechanic-<?= PromotionProductMechanicsForm::MECH_PRODUCT_DISCOUNT ?>-<?= $iter; ?>">
                        <div class="col-sm-3">
                            <?= $form->field($item, '[' . $iter . ']product_id')->widget(FindProducstWidgets::className()); ?>
                        </div>
                        <div class="col-sm-3">
                            <?= $form->field($item, '[' . $iter . ']discountRule')->dropDownList($item->getDiscountRules(), ['prompt' => 'Правило цены']); ?>
                        </div>
                        <div class="col-sm-3">
                            <?= $form->field($item, '[' . $iter . ']amount')->textInput(); ?>
                        </div>
                    </div>
                </div>
                <?php $subIter = $iter; ?>
            <?php endforeach; ?>
        <?php endif; ?>

        <?php if (!$model->isNewRecord): ?>
            <?php $md = new PromotionProductMechanicsForm(); ?>
            <?php for ($i = $subIter + 1; $i < $subIter + 1 + 3; $i++): ?>
                <div class="row">
                    <div class="col-sm-3">
                        <?= $form->field($md, '[' . $i . ']promotion_mechanic_id')->dropDownList($md->getMechanics(), ['onchange' => 'showRelatedFileds(this, ' . $i . ');', 'prompt' => 'Выбрать механику']); ?>
                    </div>
                    <div class="hidden row col-sm-9" id="inputs-mechanic-<?= PromotionProductMechanicsForm::MECH_PRODUCT_DISCOUNT ?>-<?= $i; ?>">
                        <div class="col-sm-3">
                            <?= $form->field($md, '[' . $i . ']product_id')->widget(FindProducstWidgets::className()); ?>
                        </div>
                        <div class="col-sm-3">
                            <?= $form->field($md, '[' . $i . ']discountRule')->dropDownList($md->getDiscountRules(), ['prompt' => 'Правило цены']); ?>
                        </div>
                        <div class="col-sm-3">
                            <?= $form->field($md, '[' . $i . ']amount')->textInput(); ?>
                        </div>
                    </div>
                </div>
            <?php endfor; ?>
        <?php endif; ?>

    </div>
    <?php if (!$model->isNewRecord): ?>
        <div class="tab-pane fade" id="nav-members-mail" role="tabpanel" aria-labelledby="nav-members-mail-tab">
            <?php
            //todo уточнить период акций
            //todo вывести последние 5 заказов
            //todo показать цену товара со скдикой, без скидки

            $list_product_id = PromotionProductMechanics::find()->where(['promotion_id' => $model->id])->select(['product_id'])->all();
            $list_product_id = ArrayHelper::getColumn($list_product_id, 'product_id');

            $order_items = OrdersItems::find()->where(['product_id' => $list_product_id])->select(['order_id'])->groupBy(['order_id'])->all();
            $orders = Order::find()->where(['id' => ArrayHelper::getColumn($order_items, 'order_id')])->all();

            foreach ($orders as $order) {
                $link = Html::a($order->email, Url::to(['/admin/order/order-backend/update', 'id' => $order->id]));
                echo Html::tag('div', $link);
            }

            ?>
        </div>
    <?php endif; ?>
</div>

<!--<div class="promotion-form-react"></div>-->

<script type="text/javascript">
    function showRelatedFileds(e, iter) {
        let groupEl = document.querySelector('#inputs-mechanic-' + e.value + '-' + iter);
        if (groupEl) groupEl.classList.remove('hidden');
    }
</script>