<?php
/* @var $this \yii\web\View */

use yii\helpers\Url;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\modules\seo\models\tools\Title;
use app\modules\site\widgets\AdminMenu\AdminMenuWidget;

$this->title = Title::show('Добавить товар на маркетплейс.');
?>
<?= AdminMenuWidget::widget([
    'title' => 'Добавить товар на маркетплейс',
    'links' => [
        ['title' => 'Список маркетплейсов', 'url' => Url::to(['index'])],
    ]
]); ?>
<?php $form = ActiveForm::begin(); ?>
<div class="row">
    <div class="col-sm-12">
        <?= $form->field($model, 'product_id'); ?>
    </div>
</div>
<?= Html::submitButton('Добавить', ['class' => 'btn-main']) ?>
<?php ActiveForm::end(); ?>
