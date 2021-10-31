<?php

use yii\helpers\Url;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\modules\seo\models\tools\Title;
use app\modules\site\widgets\AdminMenu\AdminMenuWidget;

/* @var $this yii\web\View
 * @var $model app\modules\delivery\models\entity\Delivery
 */

$this->title = Title::show($model->name);
?>
<?= AdminMenuWidget::widget([
    'title' => 'Маркетплейс: ' . $model->name,
    'links' => [
        ['title' => 'Назад', 'url' => Url::to(['index'])],
        ['title' => 'Обновление остатков', 'url' => Url::to(['template', 'id' => 'stock'])],
        ['title' => 'Добавление товара', 'url' => Url::to(['template', 'new'])],
    ]
]); ?>
<?php $form = ActiveForm::begin([
    'options' => ['enctype' => 'multipart/form-data']
]); ?>
<?= $this->render('_form', [
    'model' => $model,
    'form' => $form,
]) ?>
<?= Html::submitButton('Обновить', ['class' => 'btn-main']) ?>
<?php ActiveForm::end(); ?>
