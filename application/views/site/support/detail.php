<?php

use app\models\tool\seo\Title;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $ticket \app\models\entity\support\Tickets */

$this->title = Title::showTitle($ticket->title); ?>
<?= Html::a("&laquo; Назад", '/support/' . $ticket->category_id . '/', ['class' => 'btn-main']) ?>
<section class="support-ticket-detail">
    <div class="left-col">
        <div class="support-ticket-detail__list-messages">
<?php /* @var $message \app\models\entity\support\SupportMessage */ ?>
<?php foreach ($messages as $message): ?>
                <div class="support-ticket-detail__list-messages__item <?= ($message->user_id == Yii::$app->user->identity->id) ? "owner" : "user"; ?>">
                    <h6 class="support-ticket-detail__list-messages__item-title"><?= $message->user->email; ?></h6>
                    <p><?= $message->text; ?></p>
                </div>
                <div class="clearfix"></div>
<?php endforeach; ?>
        </div>
        <div class="clearfix"></div>
        <div class="support-ticket-detail__form">
<?php $form = ActiveForm::begin(); ?>
            <?= $form->field($model, 'text')->textarea(); ?>
            <?= Html::submitButton('Отправить', ['class' => 'btn-main']); ?>
<?php ActiveForm::end(); ?>
        </div>
        <div class="clearfix"></div>
    </div>
    <div class="right-col">
        <table class="support-ticket-detail-info">
            <tr class="support-ticket-detail-info__opened">
                <td colspan="2">Открыт</td>
            </tr>
            <tr>
                <td>Тема обращения</td>
                <td><?= $ticket->title; ?></td>
            </tr>
            <tr>
                <td>Дата создания</td>
                <td><?= date("d.m.Y", $ticket->created_at); ?></td>
            </tr>
            <tr>
                <td>Статус</td>
                <td><?= ($ticket->status_id == 0) ? "Создан" : $ticket->status->name; ?></td>
            </tr>
            <tr>
                <td>Раздел</td>
                <td><?= $ticket->category->name; ?></td>
            </tr>
            <tr>
                <td colspan="2"><?= $ticket->text; ?></td>
            </tr>
        </table>
    </div>
    <div class="clearfix"></div>
</section>
