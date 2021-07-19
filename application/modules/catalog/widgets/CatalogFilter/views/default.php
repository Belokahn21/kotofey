<?php

use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $values \app\modules\catalog\models\entity\PropertiesProductValues[] */
/* @var $filterModel \app\modules\catalog\models\form\CatalogFilter */

$resultArray = [];
?>

<?php foreach ($values as $value): ?>
    <?php $resultArray[$value->property->id]['property'] = $value->property; ?>
    <?php $resultArray[$value->property->id]['values'][$value->value] = $value; ?>
<?php endforeach; ?>


<?php $form = ActiveForm::begin([
    'id' => 'filter-form-id',
    'method' => 'get',
    'options' => [
        'class' => 'filter-catalog'
    ],
    'fieldConfig' => [
        'options' => [
            'tag' => false,
        ],
    ]
]); ?>
<div class="filter-catalog__title"><span>Подобрать товар</span><span class="filter-catalog__arrow"><img src="/upload/images/arrow-left-black.svg"></span></div>
<div class="filter-catalog-container">
    <div class="filter-catalog__item">
        <label class="filter-catalog__label" for="js-filter-from">Наличие</label>
        <?= $form->field($filterModel, 'available')->checkbox(['value' => $filterModel->available ?: 'Y'])->label(false); ?>
    </div>
    <div class="filter-catalog__item">
        <label class="filter-catalog__label" for="js-filter-from">Цена</label>
        <div class="filter-catalog__input-group">
            <?= $form->field($filterModel, 'price_from')->textInput(['id' => 'js-filter-from', 'class' => 'filter-catalog__input', 'placeholder' => '100', 'value' => $filterModel->price_from])->label(false); ?>
            <?= $form->field($filterModel, 'price_to')->textInput(['id' => 'js-filter-to', 'class' => 'filter-catalog__input', 'placeholder' => '1000', 'value' => $filterModel->price_to])->label(false); ?>
        </div>
    </div>
    <div class="filter-catalog__item">
        <input class="filter-catalog__range" type="range">
    </div>

    <?php foreach ($resultArray as $item): ?>

        <?php $uniqKey = substr(md5($item['property']->name), 0, 5); ?>

        <div class="filter-catalog__item">

            <div class="filter-catalog__switch">
                <label class="filter-catalog__label" for="js-filter-from"><?= $item['property']->name; ?></label>
                <a class="filter-catalog__action" data-toggle="collapse" href="#collapseCatalog-<?= $uniqKey; ?>" role="button" aria-expanded="false" aria-controls="collapseCatalog-<?= $uniqKey; ?>">Показать</a>
            </div>

            <?= $form->field($filterModel, 'params[' . $item['property']->id . '][]')->checkboxList(ArrayHelper::map($item['values'], 'value', 'name'), [
                'id' => 'collapseCatalog-' . $uniqKey,
                'class' => 'filter-catalog-checkboxes collapse',
                'item' => function ($index, $label, $name, $checked, $value) {
                    $isNeedBreak = (strlen($label) > 25 ? "break" : "");
                    $uniq = substr(md5(rand()), 0, 5);

                    $checked = ($checked ? 'checked="checked"' : "");

                    return <<<LIST
<div class="filter-catalog-checkboxes__item $isNeedBreak">
    <input type="checkbox" $checked value="$value" name="$name" id="filter-chb-$uniq">
    <label for="filter-chb-$uniq"><i class="fas fa-paw" aria-hidden="true"></i>$label</label>
</div>
LIST;
                }
            ])->label(false); ?>
        </div>

    <?php endforeach; ?>
    <div class="filter-catalog__button-group">
        <?= Html::submitButton('Показать', ['class' => 'filter-catalog__submit']); ?>
        <button class="filter-catalog__reset" type="reset"><span class="filter-catalog__reset-icon"><?= Html::img('/upload/images/reset.png') ?></span><?= Html::tag('span', 'Сбросить'); ?></button>
    </div>
</div>
<?php ActiveForm::end(); ?>
<div class="stick-filter js-stick-filter"><span><i class="fas fa-filter"></i></span></div>

