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
<button class="show-catalog-filter filter-mobile switcher">Показать фильтр</button>
<div class="filter">
    <?php $form = ActiveForm::begin([
        'options' => [/*'data-pjax' => true*/],
        'id' => 'filter-form-id',
        'method' => 'get'
    ]); ?>
    <div style="display: flex; flex-direction: row;">
        <?php echo $form->field($filterModel, 'price_from'); ?>
        <?php echo $form->field($filterModel, 'price_to'); ?>
    </div>
    <div style="display: flex; flex-direction: row;">
        <?php echo $form->field($filterModel, 'weight_from'); ?>
        <?php echo $form->field($filterModel, 'weight_to'); ?>
    </div>
    <?php echo $form->field($filterModel, 'company')->checkboxList(ArrayHelper::map($listCompany, 'id', 'name'), [
        'prompt' => 'Производитель',
        'id' => 'id_list_company',
        'class' => 'checkbox_list',
    ]); ?>
    <?php echo $form->field($filterModel, 'type')->checkboxList(ArrayHelper::map($listType, 'id', 'name'), [
        'prompt' => 'Тип корма',
        'id' => 'id_list_type',
        'class' => 'checkbox_list',
    ]); ?>
    <?php echo $form->field($filterModel, 'line')->checkboxList(ArrayHelper::map($listLines, 'id', 'name'),
        [
            'prompt' => 'Линейка',
            'id' => 'id_list_line',
            'class' => 'checkbox_list',
        ]); ?>
    <?php echo $form->field($filterModel, 'taste')->checkboxList(ArrayHelper::map($listTaste, 'id', 'name'),
        [
            'prompt' => 'Вкус',
            'id' => 'id_list_taste',
            'class' => 'checkbox_list',
        ]); ?>

    <?= Html::submitButton('Применить', ['class' => 'btn-main show-catalog-filter run']); ?>
    <?php ActiveForm::end() ?>

</div>
