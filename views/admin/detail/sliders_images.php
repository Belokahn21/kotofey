<?php

use app\models\tool\seo\Title;
use yii\widgets\ActiveForm;
use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use app\models\entity\Sliders;
use yii\helpers\Url;

/* @var \app\models\entity\SlidersImages $model */
/* @var \yii\web\View $this */

$this->title = Title::showTitle($model->text); ?>
<section>
    <h1 class="title"><?php echo $model->text; ?></h1>
    <?= Html::a("Назад", Url::to(['admin/sliderimages']), ['class' => 'btn-back']) ?>
    <div class="clearfix"></div>
    <div class="product-form">
<?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>
        <div class="tabs-container">
            <ul class="tabs">
                <li class="tab-link current" data-tab="tab-1">Основное</li>
            </ul>

            <div id="tab-1" class="tab-content current">
                <?php echo $form->field($model, 'slider_id')->dropDownList(ArrayHelper::map(Sliders::find()->all(), 'id', 'name'), ['prompt' => 'Слайдер']); ?>
                <?php echo $form->field($model, 'text')->textInput() ?>
                <?php echo $form->field($model, 'description')->textInput() ?>
                <?php echo $form->field($model, 'link')->textInput() ?>
                <?php echo $form->field($model, 'image')->fileInput(); ?>
            </div>
        </div>
        <?php echo Html::submitButton('Обновить', ['class' => 'btn-main']); ?>
<?php ActiveForm::end(); ?>
    </div>
</section>
