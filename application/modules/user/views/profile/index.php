<?php

/* @var $this \yii\web\View
 * @var $model \app\modules\user\models\entity\User
 * @var $orders \app\modules\order\models\entity\Order[]
 * @var $sexList \app\modules\user\models\entity\UserSex[]
 * @var $favorite \app\modules\catalog\models\entity\Product[]
 */

use yii\helpers\Url;
use yii\helpers\Html;
use app\models\tool\Price;
use yii\widgets\ActiveForm;
use app\widgets\Breadcrumbs;
use yii\helpers\ArrayHelper;
use app\models\tool\Currency;
use app\models\tool\seo\Title;
use app\modules\user\models\helpers\UserHelper;
use app\modules\favorite\models\entity\Favorite;
use app\modules\order\models\helpers\OrderHelper;
use app\modules\catalog\models\helpers\ProductHelper;

$this->title = Title::showTitle('Личный кабинет');
?>
<div class="page">
    <?php
    $this->params['breadcrumbs'][] = ['label' => 'Личный кабинет', 'url' => Url::to(['/user/profile/index'])];
    ?>
    <?= Breadcrumbs::widget([
        'homeLink' => [
            'label' => 'Главная ',
            'url' => Yii::$app->homeUrl,
            'title' => 'Первая страница сайта зоомагазина Котофей',
        ],
        'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
    ]); ?>
    <h1 class="page__title">Личный кабинет</h1>
    <a class="profile__logout" href="<?= Url::to(['/user/profile/logout']) ?>">Выйти</a>
    <div class="page__group-row">
        <div class="page__left profile-sections-wrap">
            <div class="profile-sections nav nav-tabs" id="proflieTabs" role="tablist"><a
                        class="profile-sections__item active" id="home-tab" data-toggle="tab" href="#home" role="tab"
                        aria-controls="home" aria-selected="true"><i class="fas fa-user"></i>
                    <div class="profile-sections__title">Настройки</div>
                </a>
                <a class="profile-sections__item" id="profile-tab" data-toggle="tab" href="#profile" role="tab"
                   aria-controls="profile" aria-selected="false"><i class="fas fa-hand-holding-usd"></i>
                    <div class="profile-sections__title">Заказы</div>
                </a>
                <a class="profile-sections__item" id="favorite-tab" data-toggle="tab" href="#favorite" role="tab" aria-controls="profile" aria-selected="false"><i class="fas fa-heart"></i>
                    <div class="profile-sections__title">Избранное</div>
                </a>
                <a class="profile-sections__item" id="pet-tab" data-toggle="tab" href="#pet" role="tab" aria-controls="pet" aria-selected="false"><i class="fas fa-paw"></i>
                    <div class="profile-sections__title">Питомец</div>
                </a>
            </div>
        </div>
        <div class="page__right profile-content">
            <div class="tab-content">
                <div class="tab-pane fade show active" id="home">
                    <h2 class="page__title">Настройки пользователя</h2>
                    <?php $form = ActiveForm::begin([
                        'options' => [
                            'class' => 'site-form profile-form'
                        ]
                    ]); ?>
                    <div class="page__left">
                        <div class="site-form__item">
                            <?= Html::label('Адрес вашей электронной почты', 'site-form-email', ['class' => 'site-form__label']) ?>
                            <?= $form->field($model, 'email')->textInput(['id' => 'site-form-email', 'class' => 'site-form__input'])->label(false); ?>
                        </div>
                        <div class="site-form__item">
                            <?= Html::label('Ваш пол', 'site-form-sex', ['class' => 'site-form__label']) ?>
                            <?= $form->field($model, 'sex')->dropDownList(ArrayHelper::map($sexList, 'id', 'name'), ['prompt' => 'Указать пол'])->label(false); ?>
                        </div>
                        <?php /*
                        <div class="site-form__item">
                            <label class="site-form__label" for="site-form-password">Новый пароль</label>
                            <input class="site-form__input" id="site-form-password" type="password" placeholder="Пароль">
                        </div>*/ ?>
                        <?= Html::submitButton('Обновить', ['class' => 'btn-main']); ?>
                    </div>
                    <div class="page__right">
                        <?php if ($model->avatar): ?>
                            <img style="width: 100px; object-fit: contain; margin: 0 auto; display: block;" src="<?= UserHelper::getAvatar($model); ?>" alt="Аватар пользователя <?= $model->name; ?>" title="Аватар пользователя <?= $model->name; ?>">
                        <?php endif; ?>
                        <div class="site-form__item">
                            <?= Html::label('Аватарка', 'site-form-avatar', ['class' => 'site-form__label']) ?>
                            <?= $form->field($model, 'avatar')->fileInput(['id' => 'site-form-avatar', 'class' => 'site-form__input'])->label(false); ?>
                        </div>
                    </div>
                    <?php ActiveForm::end(); ?>
                </div>
                <div class="tab-pane fade" id="profile">
                    <h2 class="page__title">Список покупок</h2>
                    <?php if ($orders): ?>
                        <div class="profile-orders">
                            <div class="profile-orders__row profile-orders__header">
                                <div class="profile-orders__number">№</div>
                                <div class="profile-orders__date">Дата покупки</div>
                                <div class="profile-orders__status">Статус заказа</div>
                                <div class="profile-orders__summary">Сумма заказа</div>
                                <div class="profile-orders__action"></div>
                            </div>
                            <?php foreach ($orders as $order): ?>
                                <div class="profile-orders__row">
                                    <div class="profile-orders__number">#<?= $order->id; ?></div>
                                    <div class="profile-orders__date"><?= date('d.m.Y', $order->created_at) ?></div>
                                    <div class="profile-orders__status"><?= OrderHelper::getStatus($order); ?></div>
                                    <div class="profile-orders__summary"><?= Price::format(OrderHelper::orderSummary($order->id)); ?> <?= Currency::getInstance()->show(); ?></div>
                                    <div class="profile-orders__action">
                                        <?= Html::a('Подробнее', '/profile/order/' . $order->id . '/', ['class' => 'profile-orders__link']); ?>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    <?php else: ?>
                        Заказы отсутсвуют, нужно срочно это исправить!!!
                    <?php endif; ?>
                </div>
                <div class="tab-pane fade" id="favorite">
                    <h2 class="page__title">Список избранных товаров</h2>
                    <?php if ($favorite = Favorite::findAll()): ?>
                        <div class="profile-favorite-list">
                            <?php foreach ($favorite as $item): ?>
                                <div class="profile-favorite-list__item">
                                    <div class="profile-favorite-list__image"><img src="<?= ProductHelper::getImageUrl($item) ?>"></div>
                                    <div class="profile-favorite-list__info">
                                        <div class="profile-favorite-list__title"><?= $item->name; ?></div>
                                        <div class="profile-favorite-list__group-row">
                                            <div class="profile-favorite-list__article"><?= $item->article; ?></div>
                                            <div class="profile-favorite-list__price"><?= Price::format($item->price) ?> <?= Currency::getInstance()->show(); ?></div>
                                        </div>
                                    </div>
                                    <div class="profile-favorite-list__action">
                                        <div class="profile-favorite-list__remove js-delete-favorite" data-product-id="<?= $item->id; ?>">
                                            <i class="fas fa-heart-broken"></i>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="tab-pane fade" id="pet">
                    <h2 class="page__title">Карточка питомца</h2>
                    <p>Мы ещё делаем этот блок. Скоро здесь появится крутой функционал!</p>
                </div>
            </div>
        </div>
    </div>
</div>
