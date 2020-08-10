<?php

/* @var $this \yii\web\View
 * @var $model \app\modules\user\models\entity\User
 * @var $orders \app\modules\order\models\entity\Order[]
 * @var $sexList \app\modules\user\models\entity\UserSex[]
 */

use yii\helpers\Url;
use app\models\tool\Price;
use app\models\tool\seo\Title;
use app\models\tool\Currency;
use app\modules\order\models\helpers\OrderHelper;
use app\widgets\Breadcrumbs;

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
    <a href="<?= Url::to(['/user/profile/logout']) ?>">Выйти</a>
    <div class="page__group-row">
        <div class="page__left w-25">
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
            </div>
        </div>
        <div class="page__right w-75">
            <div class="tab-content">
                <div class="tab-pane fade show active" id="home">
                    <h2 class="page__title">Настройки пользователя</h2>
                    <form class="site-form profile-form">
                        <div class="page__left">
                            <div class="site-form__item">
                                <label class="site-form__label" for="site-form-email">Адрес вашей электронной
                                    почты</label>
                                <input class="site-form__input" id="site-form-email" type="text"
                                       placeholder="Адрес вашей электронной почты">
                            </div>
                            <div class="site-form__item">
                                <label class="site-form__label" for="site-form-password">Новый пароль</label>
                                <input class="site-form__input" id="site-form-password" type="password"
                                       placeholder="Пароль">
                            </div>
                        </div>
                        <div class="page__right">
                            <div class="site-form__item">
                                <label class="site-form__label" for="site-form-avatar">Аватарка</label>
                                <input class="site-form__input" id="site-form-avatar" type="file">
                            </div>
                        </div>
                    </form>
                </div>
                <div class="tab-pane fade" id="profile">
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
                                        <a class="profile-orders__link" href="#">Подробнее</a>
                                    </div>
                                </div>
							<?php endforeach; ?>
                        </div>
					<?php else: ?>
                        Заказы отсутсвуют, нужно срочно это исправить!!!
					<?php endif; ?>
                </div>
                <div class="tab-pane fade" id="favorite">
                    <div class="profile-favorite-list">
                        <div class="profile-favorite-list__item">
                            <div class="profile-favorite-list__image"><img src="./assets/images/product.png"></div>
                            <div class="profile-favorite-list__info">
                                <div class="profile-favorite-list__title">Royal Canin Maxi Puppy 12кг, корм для щенков крупной породы</div>
                                <div class="profile-favorite-list__group-row">
                                    <div class="profile-favorite-list__article">KKOLEQ</div>
                                    <div class="profile-favorite-list__price">1 500 P</div>
                                </div>
                            </div>
                            <div class="profile-favorite-list__action">
                                <div class="profile-favorite-list__remove js-remove-favorite" data-product-id="11"><i class="fas fa-heart-broken"></i></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
