<?php

use app\models\tool\seo\Title;
use yii\widgets\ActiveForm;
use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\Url;
use yii\widgets\Pjax;

/* @var $this \yii\web\View
 * @var $model \app\modules\promotion\models\entity\Promotion
 * @var $sliderImagesModel \app\modules\content\models\entity\SlidersImages
 */

$this->title = Title::showTitle('Акция: ' . $model->name);
?>
    <div class="title-group">
        <h1>Акция: <?= $model->name; ?></h1>
    </div>

<?php Pjax::begin(); ?>


<?php $form = ActiveForm::begin([
    'options' => ['data-pjax' => '']
]) ?>
<?= $this->render('_form', [
    'form' => $form,
    'model' => $model,
    'subModel' => $subModel,
    'xstring' => rand(),
]); ?>
<?= Html::submitButton('Обновить', ['class' => 'btn-main']); ?>
<?php ActiveForm::end() ?>
<?php Pjax::end(); ?>