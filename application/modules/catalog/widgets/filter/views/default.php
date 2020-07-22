<?php

use app\modules\catalog\models\entity\InformersValues;
use app\models\forms\CatalogFilter;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\widgets\Pjax;

/* @var $filterModel CatalogFilter
 * @var $informers \app\modules\catalog\models\entity\InformersValues[]
 */

?>
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
    <div class="filter-catalog__title"><span>Подобрать товар</span><span class="filter-catalog__arrow is-active"><img src="/upload/images/arrow-left-black.svg"></span></div>
    <div class="filter-catalog-container is-active">
        <div class="filter-catalog__item"><label class="filter-catalog__label" for="js-filter-from">Цена</label>
            <div class="filter-catalog__input-group"><input class="filter-catalog__input" id="js-filter-from" placeholder="100" type="text"><input class="filter-catalog__input" id="js-filter-to" placeholder="999" type="text"></div>
        </div>
        <div class="filter-catalog__item"><input class="filter-catalog__range" type="range"></div>
        <?php foreach ($informers as $informer): ?>
            <?php
            $values = InformersValues::find()->where(['informer_id' => $informer->id, 'active' => true])->orderBy(['name' => SORT_ASC]);
            if ($productPropertiesValues) {
                $values->andWhere(['id' => ArrayHelper::getColumn($productPropertiesValues, 'value')]);
            }
            $values = $values->all();
            ?>
            <?php if ($values): ?>
                <div class="filter-catalog__item"><label class="filter-catalog__label" for="js-filter-from"><?= $informer->name; ?></label>
                    <?= $form->field($filterModel, 'informer[' . $informer->id . '][]')->checkboxList(ArrayHelper::map($values, 'id', 'name'), [
                        'id' => 'id_list_company',
                        'class' => 'filter-catalog-checkboxes',
                        'item' => function ($index, $label, $name, $checked, $value) {
                            $isNeedBreak = (strlen($label) > 25 ? "break" : "");

                            return <<<LIST
<div class="filter-catalog-checkboxes__item $isNeedBreak">
    <input type="checkbox" value="$value" name="$name">$label
</div>
LIST;
                        }
                    ])->label(false); ?>
                </div>

            <?php endif; ?>
        <?php endforeach; ?>
    </div>
    <div class="filter-catalog__button-group">
        <button class="filter-catalog__submit" type="submit">Показать</button>
        <button class="filter-catalog__reset" type="reset"><span class="filter-catalog__reset-icon"><img src="/upload/images/reset.png"></span><span>Сбросить</span></button>
    </div>
<?php ActiveForm::end(); ?>