<?php

use yii\helpers\ArrayHelper;
use app\modules\catalog\models\entity\CompositionType;
use app\modules\catalog\models\entity\CompositionProducts;
use app\modules\catalog\models\helpers\CompositionMetricsHelper;
use app\modules\catalog\models\repository\CompositionProductsRepository;


/* @var $model \app\modules\catalog\models\entity\Product
 * @var $form \yii\widgets\ActiveForm
 * @var $compositions \app\modules\catalog\models\entity\Composition[]
 * @var $this \yii\web\View
 */

?>

    <div>
        <?= \kartik\select2\Select2::widget([
            'name' => '',
            'options' => ['class' => 'js-load-composition', 'placeholder' => 'Выбрать готовый состав ...'],
            'data' => Yii::$app->cache->getOrSet('js-load-composition', function () {
                return ArrayHelper::map(ArrayHelper::getColumn(CompositionProductsRepository::getCompositProducts(), 'product'), 'id', 'name');
            }),
        ]); ?>
    </div>

    <button type="button" class="js-reset-composition btn-main">Очистить состав товара</button>

<?php
$composition_model = new CompositionProducts();
$count = 0;

?>


<?php foreach ($compositions as $type_id => $data): ?>

    <fieldset class="fieldset-props">
        <legend>
            <?php if ($type = ArrayHelper::getValue(@$data[$type_id], 'group')) echo $type->name; ?>
        </legend>

        <?php foreach ($data['compositions'] as $composit): ?>

            <?php $composit_element = null; ?>
            <?php if (!$model->isNewRecord): ?>
                <?php $composit_element = CompositionProducts::findOne(['product_id' => $model->id, 'composition_id' => $composit->id]); ?>
            <?php endif; ?>

            <div class="row">
                <div class="col-4"><?= $composit->name; ?></div>
                <div class="col-4">
                    <div class="hidden">
                        <?= $form->field($composition_model, '[' . $count . ']composition_id')->hiddenInput(['value' => $composit->id, 'class' => 'form-control js-row-composition-id', 'data-composit-id' => $composit->id])->label(false); ?>
                        <?= $form->field($composition_model, '[' . $count . ']product_id')->hiddenInput(['value' => $model->id, 'class' => 'form-control js-row-product-id'])->label(false); ?>
                    </div>
                    <?= $form->field($composition_model, '[' . $count . ']value')->textInput([
                        'value' => $composit_element ? $composit_element->value : null,
                        'placeholder' => $composit->name,
                        'class' => 'js-row-composition form-control',
                        'data-composit-id' => $composit->id,
                    ])->label(false); ?>
                </div>
                <div class="col-4">
                    <?= $form->field($composition_model, '[' . $count . ']metric_id')->dropDownList(CompositionMetricsHelper::getMetrics(), ['prompt' => 'Выбрать весовку',
                        'options' => [$composit_element ? $composit_element->metric_id : null => ["Selected" => true]],
                        'class' => 'js-row-metrik form-control',
                        'data-composit-id' => $composit->id,
                    ])->label(false); ?>
                </div>
            </div>
            <?php $count++; ?>
        <?php endforeach; ?>
    </fieldset>
<?php endforeach; ?>