<?php

use app\models\tool\seo\Title;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

$this->title = Title::showTitle("Новое обращение"); ?>
<?= Html::a("&laquo; Назад", '/support/', ['class' => 'btn-main']); ?>
    <h1><?= $category->name; ?></h1>
<section class="support-ticket">
    <div class="support-ticket__form-wrap">
        <div class="support-ticket__form">
            <h2>Создать обращение</h2>
<?php $form = ActiveForm::begin(); ?>
            <?= $form->field($model, 'title'); ?>
            <?= $form->field($model, 'text')->textarea(); ?>
            <?= Html::submitButton('Отправить', ['class' => 'btn-main']); ?>
<?php ActiveForm::end(); ?>
        </div>
    </div>
    <div class="support-ticket__list">
        <h2 class="support-ticket__list-title">Список обращений</h2>
<?php if ($tickets): ?>
<?php /* @var $ticket Tickets */ ?>
<?php foreach ($tickets as $ticket): ?>
                <div class="support-ticket-item">
                    <div class="support-ticket-item__info">
                        <a href="<?=$ticket->detail?>" class="support-ticket-item__info-title-link">
                            <h2>Обращение №<?= $ticket->id; ?></h2>
                        </a>
                        <div class="support-ticket-item__category"><?=$ticket->category->name?></div>
                    </div>
                    <div class="support-ticket-item__section">
                        <a href="<?= $ticket->detail ?>"><?= $ticket->category->html ?></a>
                    </div>
                </div>
<?php endforeach; ?>
<?php else: ?>
            У вас нет обращений
<?php endif; ?>
    </div>
</section>
