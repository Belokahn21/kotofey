<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;

/* @var \app\modules\vendors\models\entity\Vendor[] $vendors */

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
        </div>
    </div>
</div>

<?= Html::submitButton('Запустить', ['class' => 'btn-main']); ?>
<?php ActiveForm::end(); ?>
