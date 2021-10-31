<?php

use yii\helpers\ArrayHelper;
use app\modules\catalog\models\entity\ProductToBreed;
use app\modules\catalog\models\helpers\ProductToBreadHelper;

/* @var $model \app\modules\catalog\models\entity\Product
 * @var $form \yii\widgets\ActiveForm
 * @var $animals \app\modules\pets\models\entity\Animal[]
 * @var $breeds \app\modules\pets\models\entity\Breed[]
 * @var $this \yii\web\View
 */

?>
<ul class="list-breeds">
    <?php foreach ((new \app\modules\pets\models\entity\Breed())->getSizes() as $key => $value): ?>
        <li class="list-breeds-item js-load-breed-sizes" data-key="<?= $key; ?>"><?= $value; ?></li>
    <?php endforeach; ?>
</ul>

<?php $ptb = new ProductToBreed(); ?>
<?php $ptb_counter = 0;
$grouped_items = ProductToBreadHelper::getGroupedItems();
$model_id = $model->id;
$ptb_models = Yii::$app->cache->getOrSet('value_ptb_model-' . $model_id, function () use ($model_id) {
    return ProductToBreed::find()->where(['product_id' => $model_id])->all();
}) ?>
<?php if ($ptb_models): ?>
    <?php foreach ($ptb_models as $ptb_counter => $ptb_model): ?>
        <div class="row">
            <div class="col-sm-6">
                <?= $form->field($ptb_model, '[' . $ptb_counter . ']animal_id')->dropDownList(ArrayHelper::map($animals, 'id', 'name'), ['prompt' => 'Указать животное']); ?>
            </div>
            <div class="col-sm-6">
                <?= $form->field($ptb_model, '[' . $ptb_counter . ']breed_id')->widget(\kartik\select2\Select2::classname(), [
                    'data' => $grouped_items,
                ]); ?>
            </div>
        </div>
    <?php endforeach; ?>
<?php else: ?>
    <div class="row">
        <div class="col-sm-6">
            <?= $form->field($ptb, '[' . $ptb_counter . ']animal_id')->dropDownList(ArrayHelper::map($animals, 'id', 'name'), ['prompt' => 'Указать животное']); ?>
        </div>
        <div class="col-sm-6">
            <?= $form->field($ptb, '[' . $ptb_counter . ']breed_id')->widget(\kartik\select2\Select2::classname(), [
                'data' => $grouped_items,
            ]); ?>
        </div>
    </div>
<?php endif; ?>


<div class="row" style="display: none;" id="ptb-new-line">
    <div class="col-sm-6">
        <?= $form->field($ptb, '[#counter#]animal_id')->dropDownList(ArrayHelper::map($animals, 'id', 'name'), ['prompt' => 'Указать животное']); ?>
    </div>
    <div class="col-sm-6">
        <?= $form->field($ptb, '[#counter#]breed_id')->dropDownList($grouped_items, ['prompt' => 'Указать породу']); ?>
    </div>
</div>

<div class="js-add-new-line-area "></div>
<div class="js-add-new-line-item add-new-line-button" data-target="#ptb-new-line" data-counter="<?= $ptb_counter; ?>">+</div>

