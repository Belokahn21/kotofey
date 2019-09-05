<?

use app\models\tool\seo\Title;
use yii\widgets\ActiveForm;
use yii\helpers\Html;

$this->title = Title::showTitle("Разрешения"); ?>
<section>
    <h1 class="title">Разрешения</h1>
    <div class="product-form">
        <? $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>
        <div class="tabs-container">
            <ul class="tabs">
                <li class="tab-link current" data-tab="tab-1">Основное</li>
            </ul>

            <div id="tab-1" class="tab-content current">
                <?= $form->field($model, 'name'); ?>
                <?= $form->field($model, 'description'); ?>
                <?//= $form->field($model, 'parent')->dropDownList(); ?>
                <div class="clearfix"></div>
                <hr/>
            </div>
        </div>
        <?= Html::submitButton('Добавить'); ?>
        <? ActiveForm::end(); ?>
    </div>
</section>
