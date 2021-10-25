<?php

use yii\helpers\Url;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\modules\seo\models\tools\Title;
use app\modules\site\widgets\AdminMenu\AdminMenuWidget;

/* @var $model \app\modules\order\models\entity\Order */

$this->title = Title::show("Маркетплейс: " . $model->name);
?>
<?= AdminMenuWidget::widget([
    'title' => 'Маркетплейс: ' . $model->name,
    'links' => [
        ['title' => 'Назад', 'url' => Url::to(['index'])],
        ['title' => 'Удалить', 'url' => Url::to(['delete', 'id' => $model->id])],
    ]
]); ?>

    <div class="info-panel-container">
        <div class="info-panel-data">Создан: <?= date('d.m.Y', $model->created_at) ?></div>
        <div class="info-panel-data">Обновлен: <?= date('d.m.Y', $model->updated_at) ?></div>
    </div>

<?php $form = ActiveForm::begin() ?>
<?= $this->render('_form', [
    'model' => $model,
    'form' => $form,
]); ?>
<?= Html::submitButton('Обновить', ['class' => 'btn-main']) ?>
<?php ActiveForm::end() ?>