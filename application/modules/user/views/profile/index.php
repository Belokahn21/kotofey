<?php

/* @var $this \yii\web\View
 * @var $model \app\modules\user\models\entity\User
 * @var $billingModel \app\modules\user\models\entity\UserBilling
 * @var $billings \app\modules\user\models\entity\UserBilling[]
 * @var $orders \app\modules\order\models\entity\Order[]
 * @var $sexList \app\modules\user\models\entity\UserSex[]
 * @var $favorite \app\modules\catalog\models\entity\Offers[]
 * @var $history \yii\db\ActiveQuery
 */

use yii\helpers\Url;
use yii\helpers\Html;
use app\modules\site\models\tools\Price;
use yii\widgets\ActiveForm;
use app\widgets\Breadcrumbs;
use yii\helpers\ArrayHelper;
use app\modules\site\models\tools\Currency;
use app\modules\seo\models\tools\Title;
use app\modules\user\models\helpers\UserHelper;
use app\modules\bonus\models\helper\BonusHelper;
use app\modules\favorite\models\entity\Favorite;
use app\modules\order\models\helpers\OrderHelper;
use app\modules\pets\widgets\PetList\PetListWidget;
use app\modules\catalog\models\helpers\OfferHelper;
use app\modules\user\models\helpers\UserBillingHelper;
use app\modules\pets\widgets\AddPetForm\AddPetFormWidget;
use app\modules\catalog\widgets\UserAdmission\UserAdmissionWidget;
use app\modules\bonus\widgets\UserBonusHistory\UserBonusHistoryWidget;

$this->title = Title::show('Личный кабинет');
$this->params['breadcrumbs'][] = ['label' => 'Личный кабинет'];

?>
<div class="page">
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
            <div class="profile-sections nav nav-tabs" id="proflieTabs" role="tablist">


                <a class="profile-sections__item active " id="dashboard-tab" data-toggle="tab" href="#dashboard" role="tab" aria-controls="dashboard" aria-selected="true">
                    <i class="fas fa-shopping-basket"></i>
                    <div class="profile-sections__title">Рабочий стол</div>
                </a>

                <a class="profile-sections__item " id="home-tab" data-toggle="tab" href="#home" role="tab" aria-controls="home" aria-selected="true">
                    <i class="fas fa-user"></i>
                    <div class="profile-sections__title">Настройки</div>
                </a>
                <a class="profile-sections__item" id="profile-tab" data-toggle="tab" href="#profile" role="tab" aria-controls="profile" aria-selected="false">
                    <i class="fas fa-hand-holding-usd"></i>
                    <div class="profile-sections__title">Заказы</div>
                </a>
                <a class="profile-sections__item" id="favorite-tab" data-toggle="tab" href="#favorite" role="tab" aria-controls="profile" aria-selected="false">
                    <i class="fas fa-heart"></i>
                    <div class="profile-sections__title">Избранное</div>
                </a>
                <a class="profile-sections__item" id="pet-tab" data-toggle="tab" href="#pet" role="tab" aria-controls="pet" aria-selected="false">
                    <i class="fas fa-paw"></i>
                    <div class="profile-sections__title">Питомец</div>
                </a>
                <a class="profile-sections__item" id="pet-tab" data-toggle="tab" href="#bonus" role="tab" aria-controls="bonus" aria-selected="false">
                    <i class="fas fa-coins"></i>
                    <div class="profile-sections__title">Бонусы</div>
                </a>
                <a class="profile-sections__item" id="billing-tab" data-toggle="tab" href="#billing" role="tab" aria-controls="billing" aria-selected="false">
                    <i class="fas fa-map-marker-alt"></i>
                    <div class="profile-sections__title">Адреса доставок</div>
                </a>
            </div>
        </div>
        <div class="page__right profile-content">
            <div class="tab-content">
                <div class="tab-pane fade show active" id="dashboard">
                    <h2 class="page__title">Кабинет покупателя</h2>
                    <?= UserAdmissionWidget::widget(); ?>
                </div>
                <div class="tab-pane fade" id="home">
                    <h2 class="page__title">Настройки пользователя</h2>
                    <?php $form = ActiveForm::begin([
                        'options' => [
                            'class' => 'site-form profile-form',
                            'style' => 'padding:0;'
                        ]
                    ]); ?>
                    <div class="page__group-row">
                        <div class="page__left">
                            <div class="site-form__item">
                                <?= Html::label('Адрес вашей электронной почты', 'site-form-email', ['class' => 'site-form__label']) ?>
                                <?= $form->field($model, 'email')->textInput(['id' => 'site-form-email', 'class' => 'site-form__input'])->label(false); ?>
                            </div>
                            <div class="site-form__item">
                                <?= Html::label('Ваш пол', 'site-form-sex', ['class' => 'site-form__label']) ?>
                                <?= $form->field($model, 'sex')->dropDownList(ArrayHelper::map($sexList, 'id', 'name'), ['prompt' => 'Указать пол'])->label(false); ?>
                            </div>
                            <div class="site-form__item">
                                <?= Html::label('Фамилия', 'site-form-first_name', ['class' => 'site-form__label']) ?>
                                <?= $form->field($model, 'first_name')->textInput(['value' => Yii::$app->user->identity->first_name, 'class' => 'site-form__input'])->label(false); ?>
                            </div>
                            <div class="site-form__item">
                                <?= Html::label('Имя', 'site-form-name', ['id' => 'site-form-name', 'class' => 'site-form__label']) ?>
                                <?= $form->field($model, 'sex')->textInput(['id' => 'site-form-name', 'value' => Yii::$app->user->identity->name, 'class' => 'site-form__input'])->label(false); ?>
                            </div>
                            <div class="site-form__item">
                                <?= Html::label('Отчество', 'site-form-surname', ['class' => 'site-form__label']) ?>
                                <?= $form->field($model, 'sex')->textInput(['id' => 'site-form-surname', 'value' => Yii::$app->user->identity->last_name, 'class' => 'site-form__input'])->label(false); ?>
                            </div>
                            <?php /*
                        <div class="site-form__item">
                            <label class="site-form__label" for="site-form-password">Новый пароль</label>
                            <input class="site-form__input" id="site-form-password" type="password" placeholder="Пароль">
                        </div>*/ ?>
                            <?= Html::submitButton('Обновить', ['class' => 'btn-main']); ?>
                        </div>
                        <div class="page__right">
                            <div class="profile-avatar">
                                <label for="site-form-avatar">
                                    <?php if ($model->avatar): ?>
                                        <img class="profile-avatar__image" src="<?= UserHelper::getAvatar($model); ?>" alt="Аватар пользователя <?= $model->name; ?>" title="Аватар пользователя <?= $model->name; ?>">
                                    <?php else: ?>
                                        <img class="profile-avatar__image" src="/upload/images/not-image.png" alt="Аватар пользователя <?= $model->name; ?>" title="Аватар пользователя <?= $model->name; ?>">
                                    <?php endif; ?>
                                </label>
                                <?= $form->field($model, 'avatar')->fileInput(['id' => 'site-form-avatar', 'class' => 'site-form__input'])->label(false); ?>
                            </div>
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
                                    <div class="profile-orders__summary"><?= Price::format(OrderHelper::orderSummary($order)); ?> <?= Currency::getInstance()->show(); ?></div>
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
                                    <div class="profile-favorite-list__image"><img src="<?= OfferHelper::getImageUrl($item) ?>"></div>
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
                    <?= AddPetFormWidget::widget(); ?>
                    <?= PetListWidget::widget(); ?>
                </div>
                <div class="tab-pane fade" id="bonus">
                    <div class="d-flex flex-row align-items-center">
                        <h2 class="page__title">Ваши бонусы</h2>
                        <div class="profile-bonus-count"><?= BonusHelper::getUserBonus(Yii::$app->user->identity->phone); ?></div>
                    </div>
                    <?= UserBonusHistoryWidget::widget(); ?>
                </div>
                <div class="tab-pane fade" id="billing">
                    <div class="profile__inline-group">
                        <h2 class="page__title">Адреса доставок</h2>
                        <button class="profile-pet__add" type="button" data-toggle="modal" data-target="#newBillingForm">Добавить</button>
                    </div>
                    <div class="profile-billing-list">
                        <?php foreach ($billings as $item): ?>
                            <div class="profile-billing-list__item">
                                <div class="profile-billing-list__title">
                                    <div>
                                        <?= UserBillingHelper::getName($item); ?>
                                        <?php if ($item->is_main): ?>
                                            (По умолчанию)
                                        <?php endif; ?>
                                    </div>
                                    <div>
                                        <?= Html::a(Html::tag('i', false, ['class' => 'fas fa-edit']), Url::to(['profile/billing', 'id' => $item->id])) ?>
                                        <?= Html::a(Html::tag('i', false, ['class' => 'fas fa-trash-alt']), Url::to(['profile/billing-delete', 'id' => $item->id])) ?>
                                    </div>
                                </div>
                                <div class="profile-billing-list__data">
                                    <?= UserBillingHelper::getAddress($item); ?>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>


                    <div class="authModal modal fade" id="newBillingForm" tabindex="-1" role="dialog" aria-labelledby="newBillingFormLabel" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <?php $form = ActiveForm::begin(); ?>
                                <div class="site-form">
                                    <div class="modal-header">
                                        <div class="div">
                                            <h5 class="modal-title" id="newBillingFormLabel">Адрес доставки</h5>
                                        </div>
                                        <?php if (Yii::$app->user->identity->id == 1): ?>
                                            <button class="close" type="button" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                                        <?php endif; ?>
                                    </div>
                                    <div class="modal-body">

                                        <div class="site-form__item">
                                            <label class="site-form__label" for="site-form-billing-name">Название</label>
                                            <?= $form->field($billingModel, 'name')->textInput([
                                                'class' => 'site-form__input',
                                                'id' => 'site-form-billing-name',
                                                'placeholder' => 'Название',
                                            ])->label(false); ?>
                                        </div>

                                        <div class="site-form__group-row">
                                            <div class="site-form__item">
                                                <label class="site-form__label" for="site-form-index">Индекс</label>
                                                <?= $form->field($billingModel, 'index')->textInput([
                                                    'class' => 'site-form__input',
                                                    'id' => 'site-form-index',
                                                    'placeholder' => 'Индекс',
                                                ])->label(false); ?>
                                            </div>

                                            <div class="site-form__item">
                                                <label class="site-form__label" for="site-form-region">Регион</label>
                                                <?= $form->field($billingModel, 'region')->textInput([
                                                    'class' => 'site-form__input',
                                                    'id' => 'site-form-region',
                                                    'placeholder' => 'Регион',
                                                ])->label(false); ?>
                                            </div>

                                            <div class="site-form__item">
                                                <label class="site-form__label" for="site-form-city">Город</label>
                                                <?= $form->field($billingModel, 'city')->textInput([
                                                    'class' => 'site-form__input',
                                                    'id' => 'site-form-city',
                                                    'placeholder' => 'Город',
                                                ])->label(false); ?>
                                            </div>


                                            <div class="site-form__item">
                                                <label class="site-form__label" for="site-form-street">Улица</label>
                                                <?= $form->field($billingModel, 'street')->textInput([
                                                    'class' => 'site-form__input',
                                                    'id' => 'site-form-street',
                                                    'placeholder' => 'Улица',
                                                ])->label(false); ?>
                                            </div>
                                        </div>

                                        <div class="site-form__group-row">
                                            <div class="site-form__item">
                                                <label class="site-form__label" for="site-form-home">Номер дома</label>
                                                <?= $form->field($billingModel, 'home')->textInput([
                                                    'class' => 'site-form__input',
                                                    'id' => 'site-form-home',
                                                    'placeholder' => 'Номер дома',
                                                ])->label(false); ?>
                                            </div>

                                            <div class="site-form__item">
                                                <label class="site-form__label" for="site-form-entrance">Подьезд</label>
                                                <?= $form->field($billingModel, 'entrance')->textInput([
                                                    'class' => 'site-form__input',
                                                    'id' => 'site-form-entrance',
                                                    'placeholder' => 'Подьезд',
                                                ])->label(false); ?>
                                            </div>

                                            <div class="site-form__item">
                                                <label class="site-form__label" for="site-form-floor_house">Этаж</label>
                                                <?= $form->field($billingModel, 'floor_house')->textInput([
                                                    'class' => 'site-form__input',
                                                    'id' => 'site-form-floor_house',
                                                    'placeholder' => 'Этаж',
                                                ])->label(false); ?>
                                            </div>

                                            <div class="site-form__item">
                                                <label class="site-form__label" for="site-form-house">Квартира</label>
                                                <?= $form->field($billingModel, 'house')->textInput([
                                                    'class' => 'site-form__input',
                                                    'id' => 'site-form-house',
                                                    'placeholder' => 'Квартира',
                                                ])->label(false); ?>
                                            </div>
                                        </div>

                                        <div class="modal-footer">
                                            <?= Html::submitButton('Добавить', ['class' => 'site-form__button']) ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <?php ActiveForm::end(); ?>
                        </div>
                    </div>


                </div>
            </div>
        </div>
    </div>
</div>