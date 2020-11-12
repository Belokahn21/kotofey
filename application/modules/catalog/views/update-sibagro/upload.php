<?php

use yii\widgets\ActiveForm;
use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use app\modules\vendors\models\entity\Vendor;

/* @var $items \app\modules\catalog\models\entity\virtual\SibagroElement[]
 * @var $this \yii\web\View
 */

$this->title = 'Обновить прайсы по HTML';
?>
<h1>Обновить прайсы по HTML</h1>

<?php $form = ActiveForm::begin(); ?>

<?= $form->field($model, 'file')->fileInput(); ?>
<?= Html::submitButton('Начать', ['class' => 'btn-main ']) ?>

<?php ActiveForm::end(); ?>
<hr/>
<?php if ($items): ?>
    <div class="sync-html-price">
        <?php $form = ActiveForm::begin() ?>
        <?= Html::submitButton('Выполнить', ['class' => 'btn-main']) ?>
        <?php foreach ($items as $item): ?>
            <div class="sync-html-price__item row">
                <?php $productModel->vendor_id = $item->vendorId; ?>
                <div class="col-4"><?= $form->field($productModel, 'name')->textInput(['value' => $item->name]); ?></div>
                <div class="col-3"><?= $form->field($productModel, 'code')->textInput(['value' => $item->code]); ?></div>
                <div class="col-2"><?= $form->field($productModel, 'vendor_id')->dropDownList(ArrayHelper::map(Vendor::find()->all(), 'id', 'name')); ?></div>
                <div class="col-1"><?= $form->field($productModel, 'price')->textInput(['value' => $item->price]); ?></div>
                <div class="col-1"><?= $form->field($productModel, 'price')->textInput(['value' => $item->price + round($item->price * 0.3)]); ?></div>
                <?php if ($item->imagePath): ?>
                    <?= $form->field($productModel, 'lazyImageUrl')->hiddenInput(['value' => $item->imagePath])->label(false); ?>
                <?php endif; ?>
                <?php if ($product = \app\modules\catalog\models\entity\Product::findOneByCode($item->code)) $product->name . ' Уже существует'; ?>
            </div>
        <?php endforeach; ?>
        <?= Html::submitButton('Выполнить', ['class' => 'btn-main']) ?>
        <?php ActiveForm::end() ?>
    </div>
<?php endif; ?>


<style>
    .sync-html-price {
        display: flex;
        flex-direction: column;
    }

    .sync-html-price__item {
        border: 1px solid rgba(0, 0, 0, 0.06);
        padding: 20px;
    }
</style>