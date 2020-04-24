<?php

use app\models\entity\Favorite;
use yii\widgets\ActiveForm;
use yii\helpers\Html;
use app\models\entity\UserSex;
use yii\helpers\ArrayHelper;
use app\models\tool\seo\Title;
use app\models\tool\Price;
use app\modules\order\models\entity\Order;
use app\models\tool\Currency;
use app\models\helpers\OrderHelper;
use yii\helpers\Url;

/* @var \app\models\entity\User $profile */
/* @var $orders Order[] */
/* @var $support_categories \app\models\entity\support\SupportCategory[] */

$this->title = Title::showTitle("Личный кабинет");
$this->params['breadcrumbs'][] = ['label' => 'Личный кабинет', 'url' => '/profile/'];
?>
<h1>Добро пожаловать, <?= (!empty($profile->name) ? $profile->name : $profile->email); ?></h1>
<div class="profile">
    <ul class="profile-menu">
        <li class="profile-menu__item">
            <h2 class="profile-menu__item__title active-title">Профиль <i class="fas fa-user-cog" data-toggle="modal" data-target="#exampleModal"></i></h2>
            <ul class="profile-nav">
                <li class="profile-nav__item"><a href="<?= Url::to(['site/referal']); ?>" class="profile-nav__link">Реферальная программа</a></li>
                <li class="profile-nav__item"><a href="<?= Url::to(['site/billing']); ?>" class="profile-nav__link">Адреса доставки</a></li>
                <li class="profile-nav__item"><a href="<?= Url::to(['site/order']); ?>" class="profile-nav__link">Ваши заказы (<?= Order::find()->where(['user_id' => Yii::$app->user->id])->count() ?>)</a></li>
                <li class="profile-nav__item"><a href="javascript:void(0);" class="profile-nav__link" data-toggle="modal" data-target="#exampleModal">Редактировать профиль</a></li>
            </ul>
            <a class="profile-exit btn-main" href="/logout/">Выйти из профиля</a>
        </li>
        <li class="profile-menu__item">
            <h2 class="profile-menu__item__title">Заказы <i class="fas fa-shopping-bag"></i></h2>
            <div class="profile-order">
                <?php if ($orders): ?>
                    <?php foreach ($orders as $order): ?>
                        <a href="/order/<?= $order->id; ?>/">
                            <ul class="slide-order-info">
                                <li class="slide-order-info__item">
                                    ID: <?= $order->id; ?>
                                </li>
                                <li class="slide-order-info__item">
                                    <?= OrderHelper::getStatus($order); ?>
                                </li>
                                <li class="slide-order-info__item">
                                    Дата: <?= date('d.m.Y', $order->created_at) ?>
                                </li>
                                <li class="slide-order-info__item">
                                    Сумма: <?= Price::format(OrderHelper::orderSummary($order->id)); ?> <?= Currency::getInstance()->show(); ?>
                                </li>
                                <li class="slide-order-info__item">
                                    <?= (($order->is_paid == 1) ? 'Оплачен' : 'Не оплачен'); ?>
                                </li>
                            </ul>
                        </a>
                    <?php endforeach; ?>
                <?php else: ?>
                    <div>Вы ничего не покупали</div>
                <?php endif; ?>
            </div>
        </li>
        <li class="profile-menu__item">
            <h2 class="profile-menu__item__title">Сообщения <i class="fas fa-envelope"></i></h2>
        </li>
        <li class="profile-menu__item">
            <h2 class="profile-menu__item__title">Поддержка <i class="far fa-question-circle"></i></h2>
            <div class="support-categories">
                <?php if ($support_categories): ?>
                    <ul class="support-categories-list">
                        <?php foreach ($support_categories as $category): ?>
                            <li class="support-categories-list_item" title="title">
                                <a href="<?= $category->detail; ?>">
                                    <?= $category->html; ?>
                                </a>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                <?php endif; ?>
            </div>
        </li>
        <li class="profile-menu__item">
            <h2 class="profile-menu__item__title">Избранное <i class="fas fa-heart"></i></h2>
            <div class="list-favorite-wrap">
                <ul class="list-favorite">
                    <?php foreach (Favorite::findAll() as $product): ?>
                        <li class="favorite-item">
                            <div class="favorite-item__image-wrap">
                                <?php if (!empty($product->image) and is_file(Yii::getAlias('@webroot/upload/') . $product->image)): ?>
                                    <img src="/upload/<?= $product->image; ?>" class="favorite-item__image">
                                <?php else: ?>
                                    <img src="/upload/images/not-image.png" class="favorite-item__image">
                                <?php endif; ?>
                            </div>
                            <div class="favorite-item__link">
                                <a class="favorite-item__link-a" href="<?= $product->detail; ?>"><?= $product->name; ?></a>
                            </div>
                        </li>
                    <?php endforeach; ?>
                </ul>
            </div>
        </li>
        <li class="profile-menu__item">
            <h2 class="profile-menu__item__title">Бонусы за покупку <i class="fas fa-coins"></i></h2>
            <div class="profile-menu__discount">
                <div class='profile-menu__discount-container'><span class="span"></span>
                    <span class=text>
                        <?php if ($profile->discount): ?>
                            <?= $profile->discount->count; ?>
                        <?php else: ?>
                            0
                        <?php endif; ?>
                        </span>
                </div>
            </div>
        </li>
    </ul>
</div>
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Редактировать профиль</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <?php $form = ActiveForm::begin() ?>
                <div class="profile-edit-modal-wrap">
                    <ul class="nav nav-tabs" id="myTab" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active" id="home-tab" data-toggle="tab" href="#home" role="tab" aria-controls="home" aria-selected="true">Основное</a>
                        </li>
                    </ul>
                    <div class="tab-content" id="myTabContent">
                        <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">

                            <div class="profile-edit-modal-element">
                                <?= $form->field($profile, 'first_name'); ?>
                            </div>
                            <div class="profile-edit-modal-element">
                                <?= $form->field($profile, 'name'); ?>
                            </div>
                            <div class="profile-edit-modal-element">
                                <?= $form->field($profile, 'last_name'); ?>
                            </div>
                            <div class="profile-edit-modal-element">
                                <?= $form->field($profile, 'birthday'); ?>
                            </div>
                            <div class="profile-edit-modal-element">
                                <?= $form->field($profile, 'sex')->dropDownList(ArrayHelper::map(UserSex::find()->all(), 'id', 'name'), ['prompt' => 'Выбрать пол']); ?>
                            </div>
                            <div class="profile-edit-modal-element avatar-file">
                                <div class="profile-edit-modal-avatar-wrap">
                                    <?= Html::img('/upload/' . $profile->avatar); ?>
                                </div>
                                <?= $form->field($profile, 'avatar')->fileInput() ?>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <?= Html::button('Отмена', ['class' => 'btn btn-cancel', 'data-dismiss' => 'modal']); ?>
                <?= Html::submitButton('Обновить', ['class' => 'btn btn-main']); ?>
            </div>
            <?php ActiveForm::end() ?>
        </div>
    </div>
</div>