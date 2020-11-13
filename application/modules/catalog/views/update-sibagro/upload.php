<?php

use yii\widgets\ActiveForm;
use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use app\modules\vendors\models\entity\Vendor;
use app\modules\media\models\entity\Media;

/* @var $items \app\modules\catalog\models\entity\virtual\SibagroElement[]
 * @var $this \yii\web\View
 * @var $productModelList \app\modules\catalog\models\form\ProductFromSibagoForm[]
 */

$this->title = 'Обновить прайсы по HTML';
?>
<h1>Обновить прайсы по HTML</h1>

<?php $form = ActiveForm::begin(); ?>

<?= $form->field($model, 'file')->fileInput(); ?>
<?= Html::submitButton('Начать', ['class' => 'btn-main ']) ?>

<?php ActiveForm::end(); ?>
<hr/>
<?php if ($items && $productModelList): ?>
    <div class="sync-html-price">
        <?php $form = ActiveForm::begin() ?>
        <?= Html::submitButton('Выполнить', ['class' => 'btn-main']) ?>
        <?php $i = 0; ?>
        <?php foreach ($items as $item): ?>
            <?php $productModel = $productModelList[$i]; ?>

            <div class="sync-html-price__item row">
                <?php $productModel->vendor_id = $item->vendorId; ?>
                <div class="col-2"><?= $form->field($productModel, '[' . $i . ']name')->textInput(['value' => $item->name]); ?></div>
                <div class="col-2"><?= $form->field($productModel, '[' . $i . ']code')->textInput(['value' => $item->code]); ?></div>
                <div class="col-2"><?= $form->field($productModel, '[' . $i . ']vendor_id')->dropDownList(ArrayHelper::map(Vendor::find()->all(), 'id', 'name')); ?></div>
                <div class="col-2"><?= $form->field($productModel, '[' . $i . ']purchase')->textInput(['value' => $item->price]); ?></div>
                <div class="col-1"><?= $form->field($productModel, '[' . $i . ']price')->textInput(['value' => $item->price + round($item->price * 0.3)]); ?></div>
                <div class="col-2"><?= $form->field($productModel, '[' . $i . ']methodSave')->dropDownList([
                        Media::LOCATION_SERVER => Media::LOCATION_SERVER,
                        Media::LOCATION_CDN => Media::LOCATION_CDN
                    ], ['value' => Media::LOCATION_CDN]); ?></div>
                <?php if ($item->imagePath): ?>
                    <?= $form->field($productModel, '[' . $i . ']lazyImageUrl')->hiddenInput(['value' => $item->imagePath])->label(false); ?>
                <?php endif; ?>
                <?= $form->field($productModel, '[' . $i . ']count')->hiddenInput(['value' => 0])->label(false); ?>
                <?= $form->field($productModel, '[' . $i . ']vitrine')->hiddenInput(['value' => 1])->label(false); ?>
                <?php if ($product = \app\modules\catalog\models\entity\Product::findOneByCode($item->code)) $product->name . ' Уже существует'; ?>
                <?php $i++; ?>
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