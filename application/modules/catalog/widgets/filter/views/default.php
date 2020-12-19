<?php

use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use app\models\forms\CatalogFilter;
use app\modules\catalog\models\entity\SaveInformersValues;

/* @var $filterModel CatalogFilter
 * @var $informers \app\modules\catalog\models\entity\SaveInformersValues[]
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
<input type="hidden" name="<?= Yii::$app->request->csrfParam; ?>" value="<?= Yii::$app->request->getCsrfToken(); ?>"/>
<div class="filter-catalog__title"><span>Подобрать товар</span><span class="filter-catalog__arrow"><img src="/upload/images/arrow-left-black.svg"></span></div>
<div class="filter-catalog-container">
    <div class="filter-catalog__item"><label class="filter-catalog__label" for="js-filter-from">Цена</label>
        <div class="filter-catalog__input-group"><input class="filter-catalog__input" id="js-filter-from" placeholder="100" type="text"><input class="filter-catalog__input" id="js-filter-to" placeholder="999" type="text"></div>
    </div>
    <div class="filter-catalog__item"><input class="filter-catalog__range" type="range"></div>
    <?php foreach ($informers as $informer): ?>
        <?php
        $values = SaveInformersValues::find()->where(['informer_id' => $informer->id, 'active' => true])->orderBy(['name' => SORT_ASC]);
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

                        $checked = ($checked ? 'checked="checked"' : "");

                        return <<<LIST
<div class="filter-catalog-checkboxes__item $isNeedBreak">
    <input type="checkbox" $checked value="$value" name="$name">$label
</div>
LIST;
                    }
                ])->label(false); ?>
            </div>

        <?php endif; ?>
    <?php endforeach; ?>
    <div class="filter-catalog__button-group">
        <button class="filter-catalog__submit" type="submit">Показать</button>
        <button class="filter-catalog__reset" type="reset"><span class="filter-catalog__reset-icon"><img src="/upload/images/reset.png"></span><span>Сбросить</span></button>
    </div>
</div>
<?php ActiveForm::end(); ?>
<div class="stick-filter js-stick-filter"><span><i class="fas fa-filter"></i></span></div>
