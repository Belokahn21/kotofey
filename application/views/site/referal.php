<?php

use app\models\tool\seo\Title;
use app\models\helpers\UserReferalHelper;
use app\models\entity\UsersReferal;
use app\models\tool\System;

/* @var $this \yii\web\View */

$this->title = Title::showTitle('Реферальная программа');
$this->params['breadcrumbs'][] = ['label' => 'Личный кабинет', 'url' => '/profile/'];
$this->params['breadcrumbs'][] = ['label' => 'Реферальная программа', 'url' => ['site/referal']];
?>
<h1>Реферальная программа</h1>

<div class="row">
    <div class="col-sm-5 personal-link">
        <label for="referal-input-id" class="personal-link__label">Ваша ссылка</label>
        <div class="personal-link__wrap-link">
            <input id="referal-input-id" class="personal-link__input" type="text" value="<?= System::protocol(); ?>://<?= System::domain(); ?>/?ref=<?= UsersReferal::findOneByUserId(Yii::$app->user->id)->key; ?>">
            <div class="personal-link__copy" onclick="copyClipboard('referal-input-id');">
                <i class="fas fa-copy"></i>
            </div>
        </div>
    </div>
</div>

<div class="row referal-stats">
    <div class="col-sm-4 referal-stats__item">
        <div class="referal-stats__title">Всего получено вознаграждения</div>
        <div class="referal-stats__counter">
            <div><?= ($summary = UserReferalHelper::countSummary(Yii::$app->user->id)) ? $summary : 0; ?></div>
        </div>
    </div>
    <div class="col-sm-4 referal-stats__item">
        <div class="referal-stats__title">Количесто пригласивших</div>
        <div class="referal-stats__counter">
            <div><?= UserReferalHelper::countInvited(Yii::$app->user->id); ?></div>
        </div>
    </div>
    <div class="col-sm-4 referal-stats__item">
        <div class="referal-stats__title">Место в общем рейтинге</div>
        <div class="referal-stats__counter">
            <div>3</div>
        </div>
    </div>
</div>