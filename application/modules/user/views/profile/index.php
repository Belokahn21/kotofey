<?php

/* @var $this \yii\web\View
 * @var $model \app\modules\user\models\entity\User
 * @var $orders \app\modules\order\models\entity\Order[]
 * @var $sexList \app\modules\user\models\entity\UserSex[]
 * @var $favorite \app\modules\catalog\models\entity\Product[]
 * @var $history \yii\db\ActiveQuery
 * @var $petModel \app\modules\pets\models\entity\Pets
 * @var $animals \app\modules\pets\models\entity\Animal[]
 */

use yii\helpers\Url;
use yii\helpers\Html;
use app\modules\site\models\tools\Price;
use yii\widgets\ActiveForm;
use app\widgets\Breadcrumbs;
use yii\helpers\ArrayHelper;
use app\modules\site\models\tools\Currency;
use app\models\tool\seo\Title;
use app\modules\pets\models\entity\Animal;
use app\modules\user\models\helpers\UserHelper;
use app\modules\bonus\models\helper\BonusHelper;
use app\modules\favorite\models\entity\Favorite;
use app\modules\order\models\helpers\OrderHelper;
use app\modules\catalog\models\helpers\ProductHelper;

$this->title = Title::show('Личный кабинет');
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
            <div class="profile-sections nav nav-tabs" id="proflieTabs" role="tablist">
                <a class="profile-sections__item active" id="home-tab" data-toggle="tab" href="#home" role="tab" aria-controls="home" aria-selected="true">
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
                    <div class="authModal modal fade" id="newPetModal" tabindex="-1" role="dialog" aria-labelledby="newPetModalLabel" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="site-form">
                                    <div class="modal-header">
                                        <div class="div">
                                            <h5 class="modal-title" id="newPetModalLabel">Карточка нового питомца</h5>
                                        </div>
                                        <?php if (Yii::$app->user->identity->id == 1): ?>
                                            <button class="close" type="button" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                                        <?php endif; ?>
                                    </div>
                                    <div class="modal-body">
                                        <div class="site-form__item">
                                            <div class="select-pet">
                                                <?= $form->field($petModel, 'animal_id')->radioList(ArrayHelper::map($animals, 'id', 'name'), [
                                                    'item' => function ($index, $label, $name, $checked, $value) {
                                                        $animal = Animal::findOne($value);
                                                        return <<<LIST
                                        <div class="select-pet__item">
                                            <input type="radio" name="$name" value="$value" id="select-pet-dog">
                                            <label class="select-pet__icon" for="select-pet-dog"><i class="$animal->icon"></i></label>
                                        </div>
LIST;
                                                    }
                                                ]) ?>
                                            </div>
                                        </div>
                                        <div class="site-form__group-row">
                                            <div class="site-form__side">
                                                <div class="site-form__item">
                                                    <label class="site-form__label" for="site-form-namepet">Кличка питомца</label>
                                                    <input class="site-form__input" id="site-form-namepet" type="text" placeholder="Кличка питомца">
                                                </div>
                                                <div class="site-form__item">
                                                    <label class="site-form__label" for="site-form-birthday">День рождения питомца</label>
                                                    <input class="site-form__input js-datepicker" id="site-form-birthday" type="text" placeholder="День рождения питомца">
                                                </div>
                                                <div class="site-form__item">
                                                    <label class="site-form__label" for="site-form-sex">Пол питомца</label>
                                                    <select class="site-form__select" id="site-form-sex">
                                                        <option>Мальчик</option>
                                                        <option>Девочка</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="site-form__side">
                                                <label class="site-form__label noUpload" for="site-form-pet-avatar"></label>
                                                <div class="site-form__item">
                                                    <input class="site-form__item" type="file" name="avatar" id="site-form-pet-avatar">
                                                </div>
                                                <p class="select-pet__note">Загрузить фото питомца</p>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button class="site-form__button" type="button">Добавить</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="profile__inline-group">
                        <h2 class="page__title">Ваши питомцы</h2>
                        <button class="profile-pet__add" type="button" data-toggle="modal" data-target="#newPetModal">Добавить</button>
                    </div>
                </div>
                <div class="tab-pane fade" id="bonus">
                    <div class="d-flex flex-row align-items-center">
                        <h2 class="page__title">Ваши бонусы</h2>
                        <div class="profile-bonus-count"><?= BonusHelper::getUserBonus(Yii::$app->user->identity->phone); ?></div>
                    </div>
                    <h3>История поступлений бонусов</h3>
                    <div class="bonus-history-table">
                        <div class="bonus-history-table-header">
                            <div class="bonus-history-table__reason">Причина</div>
                            <div class="bonus-history-table__count">Кол-во</div>
                            <div class="bonus-history-table__date">Дата начисления</div>
                            <div class="bonus-history-table__available">Статус</div>
                        </div>
                        <?php foreach ($history->all() as $item): ?>
                            <div class="bonus-history-table-body">
                                <div class="bonus-history-table__reason"><?= $item->reason; ?></div>
                                <div class="bonus-history-table__count"><?= $item->count; ?></div>
                                <div class="bonus-history-table__date"><?= date('d.m.Y', $item->created_at); ?></div>
                                <div class="bonus-history-table__available">
                                    <?= $item->is_active ? Html::tag('i', '', [
                                        'class' => 'green far fa-check-circle'
                                    ]) : Html::tag('i', '', [
                                        'class' => 'red far fa-clock'
                                    ]); ?>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>