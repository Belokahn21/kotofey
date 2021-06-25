<?php

use app\modules\catalog\models\helpers\ProductHelper;
use app\models\tool\parser\providers\SibagroTrade;
use app\modules\vendors\models\entity\Vendor;
use app\modules\seo\models\tools\Title;
use yii\widgets\ActiveForm;
use yii\helpers\Html;

/* @var $this \yii\web\View
 * @var $model \app\modules\catalog\models\entity\Product
 * @var $properties \app\modules\catalog\models\entity\Properties[]
 * @var $modelDelivery \app\modules\catalog\models\entity\ProductOrder
 * @var $stocks \app\modules\stock\models\entity\Stocks[]
 * @var $compositions \app\modules\catalog\models\entity\Composition[]
 */

$this->title = Title::show('Товары');
?>
    <div class="title-group">
        <h1><?= $model->name; ?></h1>
        <?= Html::a('Назад', \yii\helpers\Url::to(['index']), ['class' => 'btn-main']); ?>
        <?= Html::a("Посмотреть на сайте", ProductHelper::getDetailUrl($model), ['target' => '_blank', 'class' => 'btn-main']); ?>
    </div>
<?php $form = ActiveForm::begin([
    'options' => ['enctype' => 'multipart/form-data']
]); ?>
    <div class="product-additional-panel">
        <div class="product-markup">Наценка: <?= ProductHelper::getMarkup($model); ?></div>
        <div class="product-markup green bold">+<?= $model->price - $model->purchase; ?></div>
        <?php if ($model->vendor_id == Vendor::VENDOR_ID_SIBAGRO): ?>
            <div>
                <?= Html::a('Открыть на сайте поставщика ', SibagroTrade::getProductDetailByCode($model->code), ['target' => '_blank']) . Html::a('<i class="far fa-question-circle"></i>', 'javascript:void(0);', ['class' => 'js-check-exist-product', 'data-code' => $model->code, 'data-vendor-id' => $model->vendor_id]); ?>
            </div>
        <?php endif; ?>
    </div>
<?= $this->render('_form', [
    'model' => $model,
    'form' => $form,
    'stocks' => $stocks,
    'properties' => $properties,
    'compositions' => $compositions,
    'modelDelivery' => $modelDelivery,
]) ?>
<?= Html::submitButton('Обновить', ['class' => 'btn-main']) ?>
<?php ActiveForm::end(); ?>