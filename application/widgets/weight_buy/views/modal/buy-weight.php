<?php

use app\models\helpers\PackProductHelper;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $product_id integer */
?>
<div class="modal fade" id="buy-as-weight" tabindex="-1" role="dialog" aria-labelledby="buy-as-weightLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <?php $form = ActiveForm::begin([
                'options' => [
                    'class' => 'select-weight-form'
                ]
            ]); ?>
            <div class="modal-header">
                <h5 class="modal-title" id="buy-as-weightLabel">Купить на разнавес</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-sm-6 select-weight">
                        <h2>Укажите нужный вес</h2>
                        <?= $form->field($model, 'amount')->label(false)->textInput(['class' => 'select-weight-form__amount']); ?><span> г</span>
                        <?= $form->field($model, 'product_id')->label(false)->hiddenInput(['class' => 'select-weight-form__product-id', 'value' => $product_id]); ?>
                        <?= $form->field($model, 'pack_id')->label(false)->hiddenInput(['class' => 'select-weight-form__pack-id', 'value' => PackProductHelper::getDefaultProductId()]); ?>
                    </div>
                    <div class="col-sm-6 select-packaging">
                        <h2>Выбор упаковки</h2>
                        <ul class="packaging-list">
                            <?php foreach (PackProductHelper::listPack() as $uniq_id => $product): ?>
                                <li class="packaging-list__item" data-price="<?= $product->price; ?>" data-uniq-product="<?= $uniq_id; ?>">
                                    <img class="packaging-list__image" src="/web/upload/images/<?= $product->image; ?>">
                                    <div class="packaging-list__title"><?= $product->name; ?> (+<?= $product->price; ?>)</div>
                                </li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-12 buy-weight__summary">
                        К оплате: <span class="buy-weight__price">0</span> р
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Отменить</button>
                <button type="submit" class="btn btn-main">Добавить в корзину</button>
            </div>
            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>