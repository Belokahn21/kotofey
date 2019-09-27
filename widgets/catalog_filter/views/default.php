<?php

use app\models\entity\InformersValues;
use app\models\forms\CatalogFilter;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\widgets\Pjax;

/* @var $filterModel CatalogFilter */
/* @var $listCompany InformersValues[] */
/* @var $listType InformersValues[] */

?>
<div class="filter">
    <?php // Pjax::begin(); ?>

    <?php $form = ActiveForm::begin(['options' => ['data-pjax' => true]]); ?>
    <div style="display: flex; flex-direction: row;">
        <?php echo $form->field($filterModel, 'price_from'); ?>
        <?php echo $form->field($filterModel, 'price_to'); ?>
    </div>
    <div style="display: flex; flex-direction: row;">
        <?php echo $form->field($filterModel, 'weight_from'); ?>
        <?php echo $form->field($filterModel, 'weight_to'); ?>
    </div>
    <?php echo $form->field($filterModel, 'company')->dropDownList(ArrayHelper::map($listCompany, 'id', 'value'), [
        'prompt' => 'Производитель',
        'onchange' => '$.post("/ajax/loadtype/", {company:$(this).val()}, function(data){
                console.log($("select#id_list_type").html(data));
            },"HTML");'
    ]); ?>
    <?php echo $form->field($filterModel, 'type')->dropDownList(ArrayHelper::map($listType, 'id', 'value'),
        ['prompt' => 'Тип корма', 'id' => 'id_list_type']); ?>

    <?= Html::submitButton('Фильтр', ['class' => 'btn-main']); ?>
    <?php ActiveForm::end() ?>

    <?php // Pjax::end(); ?>
</div>
