<?

use app\models\entity\user\Billing;
use app\models\entity\UserSex;
use app\models\tool\seo\Title;
use app\models\entity\Order;
use yii\bootstrap\Modal;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use app\models\entity\Favorite;
use app\models\entity\support\SupportCategory;
use app\models\tool\Currency;
use app\models\entity\Discount;

/* @var \app\models\entity\User $profile */
/* @var Order $order */

$this->title = Title::showTitle("Личный кабинет");
$this->params['breadcrumbs'][] = ['label' => 'Личный кабинет', 'url' => ['/profile/']];
$this->params['breadcrumbs'][] = ['label' => 'Выйти из профиля', 'url' => ['/logout/']]; ?>

<?
Modal::begin([
	'header' => '<h2>Редактирование профиля</h2>',
	'id' => 'edit-profile',
]);
?>

<? $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>
<div class="edit-profile__image">
    <img src="<?= $profile->avatar; ?>" title="<?= $profile->name; ?>" alt="<?= $profile->name; ?>">
	<?= $form->field($profile, 'avatar')->fileInput(); ?>
</div>
<?= $form->field($profile, 'first_name'); ?>
<?= $form->field($profile, 'name'); ?>
<?= $form->field($profile, 'last_name'); ?>
<?= $form->field($profile, 'birthday'); ?>
<?= $form->field($profile, 'sex')->dropDownList(ArrayHelper::map(UserSex::find()->all(), 'id', 'name'),
	['prompt' => "Выберите пол"]); ?>
<?= Html::submitButton('Обновить', ['class' => 'btn-main']); ?>
<? ActiveForm::end(); ?>

<? Modal::end(); ?>

<div class="page-content">
    <h1>Личный кабинет</h1>
    <div class="profile">
        <ul class="profile-menu">
            <li class="profile-menu__item">
                <h2 class="profile-menu__item__title">Профиль <i class="fas fa-user-cog" data-toggle='modal' data-target='#edit-profile'></i></h2>
                <ul class="user-info">
                    <li class="user-info__item"><?= $profile->first_name ?> <?= $profile->name ?></li>
                    <li class="user-info__item">Дата регистрации: <?= date("d.m.Y", $profile->created_at); ?></li>
                    <li class="user-info__item"><?= $profile->email; ?></li>
                    <li class="user-info__item"><span class="phone_mask"><?= ($profile->phone == 0 ? '' : $profile->phone); ?></span></li>
                </ul>
                <ul class="user-info">
                    <li class="user-info__item">
                        <ul class="profile-billing">
							<?php if ($profile->billing instanceof Billing): ?>
                                <li>Город <?= $profile->billing->city; ?></li>
                                <li>Улица <?= $profile->billing->street; ?></li>
                                <li>Дом <?= $profile->billing->home; ?></li>
                                <li>Квартира <?= $profile->billing->home; ?></li>
							<?php endif; ?>
                        </ul>
                    </li>
                </ul>
                <a class="profile-exit btn-main" href="/logout/">Выйти из профиля</a>
            </li>
            <li class="profile-menu__item">
                <h2 class="profile-menu__item__title">Заказы <i class="fas fa-shopping-bag"></i></h2>
				<? if (Order::find()->where(['user' => Yii::$app->user->identity->id])->count() > 0): ?>
                    <div class="profile-order">
						<? /* @var $order \app\models\entity\Order */ ?>
						<? foreach (Order::find()->where(['user' => Yii::$app->user->identity->id])->all() as $order): ?>
                            <a href="/order/<?= $order->id; ?>/">
                                <ul class="slide-order-info">
                                    <li class="slide-order-info__item">
                                        № заказа <?= $order->id; ?>
                                    </li>
                                    <li class="slide-order-info__item">
                                        <?= $order->getStatus(); ?>
                                    </li>
                                    <li class="slide-order-info__item">
                                        Дата: <?= date("d.m.y", $order->created_at); ?></li>
                                    <li class="slide-order-info__item">
                                        Сумма: <?= $order->getCash(); ?> <?= (new Currency())->show(); ?>
                                    </li>
                                    <li class="slide-order-info__item">
                                        Оплачен: <?= ($order->paid == true) ? '<i class="fas fa-check-circle" style="color: green;"></i>' : '<i class="fas fa-minus-circle" style="color: red;"></i>' ?>
                                    </li>
                                </ul>
                            </a>
						<? endforeach; ?>
                    </div>
				<? endif; ?>
            </li>
            <li class="profile-menu__item">
                <h2 class="profile-menu__item__title">Сообщения <i class="fas fa-envelope"></i></h2>
            </li>
            <li class="profile-menu__item">
                <h2 class="profile-menu__item__title">Поддержка <i class="far fa-question-circle"></i></h2>
                <div class="support-categories">
                    <ul class="support-categories-list">

						<? /* @var $supportCategory \app\models\entity\support\SupportCategory */ ?>
						<? foreach (SupportCategory::find()->all() as $supportCategory): ?>
                            <li class="support-categories-list_item" title="<?= $supportCategory->name; ?>">
                                <a href="<?= $supportCategory->getDetail(); ?>">
									<?= $supportCategory->html ?>
                                </a>
                            </li>
						<? endforeach; ?>

                    </ul>
                </div>
            </li>
            <li class="profile-menu__item">
                <h2 class="profile-menu__item__title">Избранное <i class="fas fa-heart"></i></h2>
				<? if (count((new Favorite())->listProducts()) > 0): ?>
                    <div class="owl-carousel owl-main">

						<? /* @var $product \app\models\entity\Product */ ?>
						<? foreach ((new Favorite())->listProducts() as $product): ?>
                            <div>
                                <i class="fas fa-times remove-favorite" data-id="<?= $product->id; ?>"></i>
                                <img src="<?= $product->image; ?>" class="item-slide">
                            </div>
						<? endforeach; ?>

                    </div>
				<? endif; ?>
            </li>
            <li class="profile-menu__item">
                <h2 class="profile-menu__item__title">Скидка <i class="fas fa-coins"></i></h2>
                <div class="profile-menu__discount">
                    <div class='profile-menu__discount-container'><span class="span"></span>
                        <span class=text>
                            <? if ($profile->discount instanceof Discount): ?>
								<?= $profile->discount->count; ?>%
							<?php else: ?>
                                0%
							<? endif; ?>
                        </span>
                    </div>
                </div>
            </li>
        </ul>
    </div>
</div>