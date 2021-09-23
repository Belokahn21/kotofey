<?php

use app\modules\seo\models\tools\Title;
use yii\widgets\ActiveForm;
use yii\helpers\Html;
use yii\helpers\Url;
use app\modules\site\widgets\AdminMenu\AdminMenuWidget;

/* @var $model \app\modules\order\models\entity\OrderStatus
 * @var $this \yii\web\View
 */

$this->title = Title::show("Статус заказа: " . $model->name); ?>

<?= AdminMenuWidget::widget([
    'title' => '>Статус заказа: ' . $model->name,
    'links' => [
        ['title' => 'Назад', 'url' => Url::to(['index'])],
    ]
]); ?>

<?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>
<?= $this->render('_form', [
    'model' => $model,
    'form' => $form
]) ?>
<?= Html::submitButton('Обновить', ['class' => 'btn-main']); ?>
<?php ActiveForm::end(); ?>
