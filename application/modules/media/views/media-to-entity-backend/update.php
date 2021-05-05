<?php

use app\modules\catalog\models\helpers\ProductHelper;
use app\modules\seo\models\tools\Title;
use yii\widgets\ActiveForm;
use yii\helpers\Html;

/* @var $this \yii\web\View
 * @var $model \app\modules\catalog\models\entity\Product
 * @var $properties \app\modules\catalog\models\entity\SaveProductProperties[]
 * @var $modelDelivery \app\modules\catalog\models\entity\ProductOrder
 */

$this->title = Title::show('Товары');
?>
    <div class="title-group">
        <h1><?= $model->name; ?></h1>
    </div>
<?php $form = ActiveForm::begin([
    'options' => ['enctype' => 'multipart/form-data']
]); ?>
<?= $this->render('_form', [
    'model' => $model,
    'form' => $form,
]) ?>
<?= Html::submitButton('Обновить', ['class' => 'btn-main']) ?>
<?php ActiveForm::end(); ?>