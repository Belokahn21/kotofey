<?php

use yii\helpers\Url;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use app\modules\site\models\tools\Debug;
use app\modules\catalog\models\helpers\PriceListHelper;
use app\modules\catalog\models\entity\PropertiesVariants;

/* @var \app\modules\vendors\models\entity\Vendor[] $vendors
 * @var $model \app\modules\catalog\models\form\PriceUpdateForm
 * @var $complete_ids \app\modules\catalog\models\entity\Product[]
 * @var $empty_ids array
 * @var $error_elements \app\modules\catalog\models\entity\Product[]
 * @var $not_found \app\modules\catalog\models\entity\Product[]
 */

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
            <div class="col-3">
                <?= $form->field($model, 'delimiter')->textInput(['value' => ';']); ?>
            </div>
            <div class="col-3">
                <div class="row">
                    <div class="col-12">
                        <?= $form->field($model, 'default_markup')->textInput(); ?>
                    </div>
                    <div class="col-12">
                        <?= $form->field($model, 'force_markup')->checkbox(); ?>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-3">
                <?= $form->field($model, 'type_price')->dropDownList($model->getTypePrice(), ['prompt' => 'Указать типа цены в прайсе']); ?>
            </div>
            <div class="col-3">
                <?= $form->field($model, 'related_key_filter')->dropDownList(PriceListHelper::getModelKeys(), ['prompt' => 'Свойство ключевое']); ?>
            </div>
            <div class="col-3">
                <?= $form->field($model, 'maker_id')->dropDownList(ArrayHelper::map(PropertiesVariants::find()->where(['property_id' => 1])->all(), 'id', 'name'), ['prompt' => 'Производитель']); ?>
            </div>
            <div class="col-3">
                <div class="row">
                    <div class="col-sm-6">
                        <?= $form->field($model, 'price_col_id')->textInput(); ?>
                    </div>
                    <div class="col-sm-6">
                        <?= $form->field($model, 'ident_key_col_id')->textInput(); ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<?= Html::submitButton('Запустить', ['class' => 'btn-main']); ?>
<?php ActiveForm::end(); ?>

<div class="row">
    <div class="col-sm-3">
        <?php if ($empty_ids): ?>
            <?php foreach ($empty_ids as $empty_id): ?>
                <div>
                    Не найден товар с кодом: <?= $empty_id; ?>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>
    <div class="col-sm-3">
        <?php if ($complete_ids): ?>
            <div class="price-list">
                <?php foreach ($complete_ids as $complete_element): ?>
                    <div class="price-list-item">
                        <div>
                            <span class="green">Обновлен</span>
                            <span><?= $complete_element->name; ?></span>
                        </div>

                        <div><?= Html::a('Перейти', Url::to(['product-backend/update', 'id' => $complete_element->id]), ['target' => '_blank']); ?></div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>
    <div class="col-sm-3">
        <?php if ($error_elements): ?>
            <?php foreach ($error_elements as $product): ?>
                <div style="display: flex; flex-direction: row; align-items: center;">
                    <div class="red">Ошибка</div>
                    <div><?= $product->name; ?></div>
                    <div><?= Debug::modelErrors($product); ?></div>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>
    <div class="col-sm-3">
        <?php if ($not_found): ?>

            <div class="price-list">
                <?php foreach ($not_found as $product): ?>
                    <div class="price-list-item">
                        <div class="red">Наша позиция не найдена в прайсе листе</div>
                        <div>(<?= $product->code; ?>)<?= Html::a($product->name,Url::to(['product-backend/update', 'id' => $product->id]), ['target' => '_blank']); ?></div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>
</div>






