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
/* @var $listLines InformersValues[] */
/* @var $listTaste InformersValues[] */

?>
<div class="filter">

    <?php $form = ActiveForm::begin(['options' => ['data-pjax' => true], 'id' => 'filter-form-id']); ?>
    <div style="display: flex; flex-direction: row;">
        <?php echo $form->field($filterModel, 'price_from'); ?>
        <?php echo $form->field($filterModel, 'price_to'); ?>
    </div>
    <div style="display: flex; flex-direction: row;">
        <?php echo $form->field($filterModel, 'weight_from'); ?>
        <?php echo $form->field($filterModel, 'weight_to'); ?>
    </div>
    <?php echo $form->field($filterModel, 'company')->checkboxList(ArrayHelper::map($listCompany, 'id', 'value'), [
        'prompt' => 'Производитель',
        'id' => 'id_list_company',
    ]); ?>
    <?php echo $form->field($filterModel, 'type')->checkboxList(ArrayHelper::map($listType, 'id', 'value'), [
        'prompt' => 'Тип корма',
        'id' => 'id_list_type',
    ]); ?>
    <?php echo $form->field($filterModel, 'line')->checkboxList(ArrayHelper::map($listLines, 'id', 'value'),
        [
            'prompt' => 'Линейка',
            'id' => 'id_list_line',
        ]); ?>
    <?php echo $form->field($filterModel, 'taste')->checkboxList(ArrayHelper::map($listTaste, 'id', 'value'),
        [
            'prompt' => 'Вкус',
            'id' => 'id_list_taste',
        ]); ?>

    <?= Html::submitButton('Фильтр', ['class' => 'btn-main']); ?>
    <?php ActiveForm::end() ?>

</div>
