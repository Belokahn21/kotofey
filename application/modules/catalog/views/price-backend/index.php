<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;

/* @var \app\modules\vendors\models\entity\Vendor[] $vendors */
/* @var $model \app\modules\catalog\models\form\PriceUpdateForm */
/* @var $complete_ids \app\modules\catalog\models\entity\Product[] */
/* @var $empty_ids array */
/* @var $error_elements array */

$this->title = \app\modules\seo\models\tools\Title::show('Обновить прайс лист');
?>

<?php $form = ActiveForm::begin([
    'options' => ['enctype' => 'multipart/form-data']
]); ?>
<nav>
    <div class="nav nav-tabs" id="backendForms" role="tablist">
        <a class="nav-item nav-link active" id="nav-home-tab" data-toggle="tab" href="#nav-home" role="tab" aria-controls="nav-home" aria-selected="true">Основное</a>
    </div>
</nav>
<div class="tab-content" id="backendFormsContent">
    <div class="tab-pane fade show active" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab">
        <div class="row">
            <div class="col-3">
                <?= $form->field($model, 'file')->fileInput(); ?>
            </div>
            <div class="col-3">
                <?= $form->field($model, 'vendor_id')->dropDownList(ArrayHelper::map($vendors, 'id', 'name'), ['prompt' => 'Указать поставщика']); ?>
            </div>
            <div class="col-3">
                <?= $form->field($model, 'delimiter')->textInput(['value' => ';']); ?>
            </div>
            <div class="col-3"></div>
        </div>
    </div>
</div>


<?php if ($empty_ids): ?>
    <?php foreach ($empty_ids as $empty_id): ?>
        <div>
            Не найден товар с кодом: <?= $empty_id; ?>
        </div>
    <?php endforeach; ?>
<?php endif; ?>

<?php if ($complete_ids): ?>
    <?php foreach ($complete_ids as $complete_element): ?>
        <div style="border-bottom: 1px solid grey;">
            <span>
                <span class="green">Обновлен</span>
                <span><?= $complete_element->name; ?></span>
            </span>

            <span><?= Html::a('Перейти', \yii\helpers\Url::to(['product-backend/update', 'id' => $complete_element->id])); ?></span>
        </div>
    <?php endforeach; ?>
<?php endif; ?>
<?= Html::submitButton('Запустить', ['class' => 'btn-main']); ?>
<?php ActiveForm::end(); ?>
