<?php

use yii\widgets\ActiveForm;
use app\modules\catalog\models\helpers\ProductHelper;
use app\modules\catalog\models\entity\ProductCategory;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;
use yii\helpers\Html;

/* @var $model \app\modules\catalog\models\entity\Product
 * @var $categories ProductCategory[]
 * @var $vendors \app\modules\vendors\models\entity\Vendor[]
 * @var $stocks \app\modules\stock\models\entity\Stocks[]
 */
?>
<li class="admin-panel-list__item link"><a data-toggle="modal" data-target="#adminEditProductModal" href="#">Редактировать</a></li>

<div class="modal fade" id="adminEditProductModal" tabindex="-1" role="dialog" aria-labelledby="adminEditProductModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <?php $form = ActiveForm::begin([
            'method' => 'POST',
            'action' => Url::to(['/admin/catalog/product-backend/update/', 'id' => $model->id])
        ]); ?>
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="adminEditProductModalLabel">Редактировать товар</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="accordion" id="accordionExample">
                    <div class="card">
                        <div class="card-header" id="headingOne">
                            <h5 class="mb-0">
                                <button class="btn btn-link" type="button" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                    Основное
                                </button>
                            </h5>
                        </div>

                        <div id="collapseOne" class="collapse show" aria-labelledby="headingOne" data-parent="#accordionExample">
                            <div class="card-body">
                                <?= $form->field($model, 'name'); ?>
                                <?= $form->field($model, 'description')->textarea(); ?>
                                <?= $form->field($model, 'feed')->textarea(); ?>
                                <div class="row">
                                    <div class="col-sm-4">
                                        <?= $form->field($model, 'status_id')->dropDownList($model->getStatusList(), ['prompt' => 'Статус товара']); ?>
                                    </div>
                                    <div class="col-sm-4">
                                        <?= $form->field($model, 'category_id')->dropDownList(ArrayHelper::map((new ProductCategory())->categoryTree(), 'id', 'name'), ['prompt' => 'Раздел товара']); ?>
                                    </div>
                                    <div class="col-sm-4">
                                        <?= $form->field($model, 'vendor_id')->dropDownList(ArrayHelper::map($vendors, 'id', 'name'), ['prompt' => 'Поставщик']); ?>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-3">
                                        <?= $form->field($model, 'discount_price'); ?>
                                    </div>
                                    <div class="col-sm-3">
                                        <?= $form->field($model, 'count'); ?></div>
                                    <div class="col-sm-3">
                                        <?= $form->field($model, 'purchase'); ?></div>
                                    <div class="col-sm-3">
                                        <?= $form->field($model, 'price'); ?>

                                    </div>
                                </div>
                                <?= $form->field($model, 'code'); ?>
                                <?= $form->field($model, 'vitrine')->radioList(['Нет', 'Да']); ?>
                                <?= $form->field($model, 'stock_id')->dropDownList(ArrayHelper::map($stocks, 'id', 'name')); ?>
                            </div>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-header" id="headingTwo">
                            <h5 class="mb-0">
                                <button class="btn btn-link collapsed" type="button" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                                    Картинки
                                </button>
                            </h5>
                        </div>
                        <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionExample">
                            <div class="card-body">
                                <?php if ($model->image): ?>
                                    <img width="150" alt="<?= $model->name; ?>" title="<?= $model->name; ?>" src="<?= ProductHelper::getImageUrl($model) ?>">
                                <?php endif; ?>
                                <?= $form->field($model, 'image')->fileInput(); ?>
                            </div>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-header" id="headingThree">
                            <h5 class="mb-0">
                                <button class="btn btn-link collapsed" type="button" data-toggle="collapse" data-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                                    Свойства
                                </button>
                            </h5>
                        </div>
                        <div id="collapseThree" class="collapse" aria-labelledby="headingThree" data-parent="#accordionExample">
                            <div class="card-body">
                                Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus terry richardson ad squid. 3 wolf moon officia aute, non cupidatat skateboard dolor brunch. Food truck quinoa nesciunt laborum eiusmod. Brunch 3 wolf moon tempor, sunt aliqua put a bird on it squid single-origin coffee nulla assumenda shoreditch et. Nihil anim keffiyeh helvetica, craft beer labore wes anderson cred nesciunt sapiente ea proident. Ad vegan excepteur butcher vice lomo. Leggings occaecat craft beer farm-to-table, raw denim aesthetic synth nesciunt you probably haven't heard of them accusamus labore sustainable VHS.
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <?= Html::a('Открыть в панели администратора', Url::to(['/admin/catalog/product-backend/update/', 'id' => $model->id])); ?>
                <?= Html::button('Закрыть', ['class' => 'btn btn-secondary', 'data-dismiss' => 'modal']); ?>
                <?= Html::submitButton('Сохранить', ['class' => 'btn btn-primary']); ?>
            </div>
        </div>
        <?php ActiveForm::end() ?>
    </div>
</div>