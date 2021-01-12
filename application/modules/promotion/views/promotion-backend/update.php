<?php

use app\models\tool\seo\Title;
use yii\widgets\ActiveForm;
use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\Url;
use yii\widgets\Pjax;

/* @var $this \yii\web\View
 * @var $model \app\modules\promotion\models\entity\Promotion
 * @var $subModel \app\modules\promotion\models\forms\PromotionProductMechanicsForm
 * @var $sliderImagesModel \app\modules\content\models\entity\SlidersImages
 */

$this->title = Title::showTitle('Акция: ' . $model->name);
?>
    <div class="title-group">
        <h1>Акция: <?= $model->name; ?></h1>
        <?= Html::a('Назад', Url::to(['index']), ['class' => 'btn-main']); ?>
    </div>
<?php $form = ActiveForm::begin([
    'options' => ['enctype' => 'multipart/form-data']
]); ?>
<?= $this->render('_form', [
    'form' => $form,
    'model' => $model,
    'subModel' => $subModel,
]); ?>
<?= Html::submitButton('Обновить', ['class' => 'btn-main']); ?>
<?php ActiveForm::end() ?>