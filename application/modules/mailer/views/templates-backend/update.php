<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use app\modules\seo\models\tools\Title;

/* @var $this \yii\web\View
 * @var $model \app\modules\mailer\models\entity\MailTemplates
 * @var $events \app\modules\mailer\models\entity\MailEvents[]
 */

$this->title = Title::show('Почтовый шаблон: ' . $model->name);
?>
    <div class="title-group">
        <h1>Почтовый шаблон: <?= $model->name; ?></h1>
        <?= Html::a('Назад', Url::to(['index']), ['class' => 'btn-main']); ?>
        <?= Html::a('Почтовые события', Url::to(['/admin/mailer/events-backend/index']), ['class' => 'btn-main']); ?>
    </div>
<?php $form = ActiveForm::begin([
    'options' => ['enctype' => 'multipart/form-data']
]); ?>
<?= $this->render('_form', [
    'model' => $model,
    'form' => $form,
    'events' => $events,
]) ?>
<?= Html::submitButton('Обновить', ['class' => 'btn-main']) ?>
<?php ActiveForm::end(); ?>