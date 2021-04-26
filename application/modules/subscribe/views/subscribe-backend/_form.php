<?php

use yii\helpers\ArrayHelper;
use yii\helpers\Json;
use app\modules\media\models\entity\Media;
use app\modules\stock\models\entity\Stocks;
use app\modules\vendors\models\entity\Vendor;
use app\modules\catalog\models\entity\Product;
use app\modules\catalog\models\entity\ProductOrder;
use app\modules\cdn\widgets\CdnInput\CdnInputWidget;
use app\modules\catalog\models\entity\PropertyGroup;
use app\modules\catalog\models\helpers\ProductHelper;
use app\modules\catalog\models\entity\ProductCategory;
use app\modules\site\models\helpers\ProductMarkupHelper;
use app\modules\catalog\models\entity\PropertiesVariants;
use app\modules\catalog\models\entity\TypeProductProperties;
use app\modules\catalog\models\entity\PropertiesProductValues;
use app\modules\media\widgets\InputUploadWidget\InputUploadWidget;

/* @var $model \app\modules\subscribe\models\entity\Subscribes
 * @var $form \yii\widgets\ActiveForm
 */

?>
<?php //= FillFromVendorWidget::widget(); ?>
<nav>
    <div class="nav nav-tabs" id="backendForms" role="tablist">
        <a class="nav-item nav-link active" id="nav-home-tab" data-toggle="tab" href="#nav-home" role="tab" aria-controls="nav-home" aria-selected="true">Основное</a>
    </div>
</nav>
<div class="tab-content" id="backendFormsContent">
    <div class="tab-pane fade show active" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab">
        <div class="row">
            <div class="col-sm-6">
                <div class="form-element">
                    <?= $form->field($model, 'status_id')->dropDownList($model->getStatusList(), ['prompt' => 'Статус товара'])->label(false); ?>
                </div>
                <div class="form-element">
                    <?= $form->field($model, 'name')->textInput(['placeholder' => 'Название'])->label(false); ?>
                </div>
                <div class="form-element">
                    <?= $form->field($model, 'slug')->textInput(['placeholder' => 'Символьный код'])->label(false); ?>
                </div>
                <div class="form-element">
                    <?= $form->field($model, 'description')->textarea(['placeholder' => 'Описание'])->label(false); ?>
                </div>

                <div class="form-element">
                    <?= $form->field($model, 'category_id')->dropDownList(ArrayHelper::map((new ProductCategory())->categoryTree(), 'id', 'name'), ['prompt' => 'Раздел товара'])->label(false); ?>
                </div>

                <div class="form-element">
                    <?= $form->field($model, 'vendor_id')->dropDownList(ArrayHelper::map(Vendor::find()->all(), 'id', 'name'), ['prompt' => 'Поставщик'])->label(false); ?>
                </div>

                <div class="row">
                    <div class="col-sm-2">
                        <div class="form-element">
                            <?= $form->field($model, 'discount_price')->textInput(['placeholder' => 'Цена со скидкой'])->label(false); ?>
                        </div>
                    </div>
                    <div class="col-sm-2">
                        <div class="form-element">
                            <?= $form->field($model, 'base_price')->textInput(['placeholder' => 'Базовая цена'])->label(false); ?>
                        </div>
                    </div>
                    <div class="col-sm-2">
                        <div class="form-element">
                            <?= $form->field($model, 'purchase')->textInput(['id' => 'id-purchase', 'placeholder' => 'Закупочная цена'])->label(false); ?>
                        </div>
                    </div>

                    <div class="col-sm-3 set-price-container">
                        <div class="form-element">
                            <?= $form->field($model, 'price')->textInput(['id' => 'id-price', 'placeholder' => 'Цена продажи'])->label(false); ?>
                        </div>

                        <div class="set-price">
                            <input class="set-price__input" placeholder="<?= ProductMarkupHelper::getProductMarkupFromCookie() ?>" value="<?= ProductMarkupHelper::getProductMarkupFromCookie(); ?>">
                            <a href="javascript:void(0);" class="set-price__action">
                                <img src="/upload/images/percentage.png">
                            </a>
                        </div>
                    </div>

                    <div class="col-sm-3">
                        <div class="form-element">
                            <?= $form->field($model, 'count')->textInput(['placeholder' => 'Количество'])->label(false); ?>
                        </div>
                    </div>
                </div>

                <div class="form-element">
                    <?= $form->field($model, 'has_store')->checkbox()->label(false); ?>
                </div>
            </div>
            <div class="col-sm-6">

                <div class="form-element">
                    <?= $form->field($model, 'code')->textInput(['placeholder' => 'Внешний код'])->label(false); ?>
                </div>
                <div class="form-element">
                    <?= $form->field($model, 'barcode')->textInput(['placeholder' => 'Штрих-код'])->label(false); ?>
                </div>
                <div class="form-element">
                    <?= $form->field($model, 'vitrine')->radioList(["Нет", "Да"]); ?>
                </div>
                <div class="form-element">
                    <?= $form->field($model, 'is_ali')->radioList(["Нет", "Да"]); ?>
                </div>
                <div class="form-element">
                    <?= $form->field($model, 'stock_id')->dropDownList(ArrayHelper::map(Stocks::find()->all(), 'id', 'name')) ?>
                </div>
                <div class="form-element">
                    <?= $form->field($model, 'threeDCode')->textarea(['rows' => 5]) ?>
                </div>
            </div>
        </div>

    </div>
</div>