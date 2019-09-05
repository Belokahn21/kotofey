<?

use app\models\tool\seo\Title;
use app\models\entity\support\SupportCategory;
use app\models\entity\support\Tickets;
use yii\widgets\ActiveForm;
use yii\helpers\Html;
use yii\helpers\ArrayHelper;

$this->title = Title::showTitle("Техническая поддержка"); ?>
<h1>Техническая поддержка</h1>
<? if ($categories): ?>
    <div class="support">
        <div class="support-tickets-wrap">
            <? if (!$tickets): ?>
            <div class="support-ticket__form-wrap">
                <div class="support-ticket__form">
                    <h2>Новое обращение</h2>
                    <? $form = ActiveForm::begin(); ?>
                    <?= $form->field($model, 'title'); ?>
                    <?= $form->field($model, 'category_id')->dropDownList(ArrayHelper::map(SupportCategory::find()->all(), 'id', 'name'), ['prompt' => 'Раздел']) ?>
                    <?= $form->field($model, 'text')->textarea(); ?>
                    <?= Html::submitButton('Отправить', ['class' => 'btn-main']); ?>
                    <? ActiveForm::end(); ?>
                </div>
            </div>
            <? endif; ?>
            <? /* @var $ticket Tickets */ ?>
            <? foreach ($tickets as $ticket): ?>
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
            <? endforeach; ?>

        </div>
        <div class="support-categories__list-wrap">
            <ul class="support-categories__list">

                <? /* @var $supportCategory SupportCategory */ ?>
                <? foreach ($categories as $supportCategory): ?>
                    <? $count = $supportCategory->countTickets(); ?>
                    <li class="support-categories__list_element">
                        <a href="<?= $supportCategory->detail; ?>"><?= $supportCategory->name; ?> <?=(($count > 0) ? '('.$count.')': '');?></a>
                    </li>
                <? endforeach; ?>

            </ul>
        </div>
    </div>
<? else: ?>
    Разделов технической поддержки нет!
<? endif; ?>
