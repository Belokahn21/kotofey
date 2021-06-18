<?php

use app\modules\mailer\models\entity\MailTemplates;
use yii\helpers\Html;
use yii\helpers\Url;

/* @var $form \yii\widgets\ActiveForm
 * @var $model \app\modules\mailer\models\entity\MailEvents
 */
?>
<nav>
    <div class="nav nav-tabs" id="nav-tab" role="tablist">
        <a class="nav-item nav-link active" id="nav-home-tab" data-toggle="tab" href="#nav-home" role="tab" aria-controls="nav-home" aria-selected="true">Основное</a>
        <?php if (!$model->isNewRecord): ?>
            <a class="nav-item nav-link" id="nav-mail-tab" data-toggle="tab" href="#nav-mail" role="tab" aria-controls="nav-home" aria-selected="true">Почтовые письма</a>
        <?php endif; ?>
    </div>
</nav>
<div class="tab-content" id="nav-tab-content-form">
    <div class="tab-pane fade show active" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab">
        <?= $form->field($model, 'is_active')->checkbox(); ?>
        <?= $form->field($model, 'name') ?>
        <?= $form->field($model, 'sort') ?>
        <?= $form->field($model, 'code') ?>
    </div>
    <?php if (!$model->isNewRecord): ?>
        <div class="tab-pane fade" id="nav-mail" role="tabpanel" aria-labelledby="nav-mail-tab">
            <?php if ($mails = MailTemplates::find()->where(['event_id' => $model->id])->all()): ?>
                <?php foreach ($mails as $mail): ?>
                    <?= Html::a($mail->name, Url::to(['templates-backend/update', 'id' => $mail->id])); ?>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
    <?php endif; ?>
</div>