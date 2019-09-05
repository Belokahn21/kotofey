<?

use app\models\entity\Informers;
use app\models\entity\TypeProductProperties;
use app\models\tool\seo\Title;
use yii\helpers\ArrayHelper;
use yii\widgets\ActiveForm;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\GridView;

$this->title = Title::showTitle("Свойства товаров"); ?>
<section>
    <?= Html::a("Назад", '/admin/properties/', ['class' => 'btn-back']) ?>
    <h1 class="title">Свойство: <?= $model->name; ?></h1>
    <? $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>
    <div class="tabs-container">
        <ul class="tabs">
            <li class="tab-link current" data-tab="tab-1">Основное</li>
        </ul>

        <div id="tab-1" class="tab-content current">
            <?= $form->field($model, 'active')->radioList(['Нет', 'Да']) ?>
            <?= $form->field($model, 'need_show')->radioList(['Нет', 'Да']) ?>
            <?= $form->field($model, 'name') ?>
            <?= $form->field($model, 'sort')->textInput() ?>

            <? if ($_GET['type']) {
                $model->type = $_GET['type'];
            } ?>

            <?= $form->field($model, 'type')->dropDownList((new TypeProductProperties())->listType(), ['prompt' => "Тип свойства", 'id'=>'select-type-prop']) ?>
            <? if ($model->type == "1"): ?>
                <?= $form->field($model, 'informer_id')->dropDownList(ArrayHelper::map(Informers::find()->all(), 'id', 'name'), ['prompt'=>'Справочник']) ?>
            <? endif; ?>
        </div>

    </div>
    <?= Html::submitButton('Обновить'); ?>
    <? ActiveForm::end(); ?>
</section>