<?php

/* @var $this \yii\web\View */

/* @var $content string */

use app\models\entity\GeoTimezone;
use app\models\entity\Vacancy;
use yii\helpers\Url;
use app\models\entity\News;
use yii\helpers\Html;
use app\models\entity\Product;
use app\modules\order\models\entity\Order;
use app\assets\AdminAsset;
use app\models\entity\support\Tickets;
use app\models\entity\User;
use app\widgets\notification\Alert;
use app\models\entity\Stocks;
use app\modules\order\models\entity\OrderStatus;
use app\models\entity\Delivery;
use app\models\entity\Payment;
use app\models\entity\Promo;
use app\models\entity\VendorGroup;
use app\models\entity\Vendor;
use app\models\entity\Geo;
use app\models\entity\ShortLinks;
use app\models\entity\Category;
use app\models\entity\ProductProperties;
use app\models\entity\Informers;
use app\models\entity\InformersValues;

AdminAsset::register($this);
$this->beginPage();
$user = User::findOne(Yii::$app->user->identity->id);
?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.3/css/all.css" integrity="sha384-UHRtZLI+pbxtHCWp1t77Bi1L4ZtiqrqD80Kn4Z8NTSRyMA2Fd33n5dQ8lWUE00s/" crossorigin="anonymous">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <script src="https://api-maps.yandex.ru/2.1/?apikey=<?= Yii::$app->params['yandex']['geocode']; ?>&lang=ru_RU" type="text/javascript"></script>
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body>
<?php $this->beginBody() ?>
<?= Alert::widget([
    'template' => 'backend'
]); ?>
<aside class="left-sidebar">
    <button class="switch-menu">Меню</button>
    <nav class="dashboard-left-sidebar" data-show="false">
        <div class="dashboard-left-sidebar__content">
            <h4 style="color: white; text-align: center; padding: 0 0 2% 0; margin: 0; border-bottom: 1px grey solid;">Панель управления</h4>
            <div class="current-profile">
                <div class="avatar-wrap">
                    <img class="current-profile__avatar" src="/upload/<?= ((!empty($user->avatar)) ? $user->avatar : "/images/boy.png"); ?>" alt="Аватар пользователя <?= $user->email; ?>" title="Аватар пользователя <?= $user->email; ?>">
                </div>
                <div class="user-email"><?= $user->email; ?></div>
                <div class="user-role"><?= $user->group->name; ?></div>
                <div class="is-online"><i class="fas fa-circle"></i> Online</div>
                <div class="clearfix"></div>
            </div>

            <div class="search-form-wrap">
                <form autocomplete="off" method="post" action="/admin/" class="search-form__form">
                    <input class="search-form__item" type="text" name="word" placeholder="Поиск..." onfocus="this.placeholder = ''" onblur="this.placeholder = 'Поиск...'"/>
                </form>
            </div>

            <div class="panel-menu-wrap">
                <h3 class="panel-menu__title">Навигация</h3>

                <ul class="accordion-menu">
                    <li class="accordion-menu__single"><a href="/"><i class="fas fa-home"></i>Сайт</a></li>
                    <li class="accordion-menu__single"><a href="/admin/"><i class="fa fa-tachometer-alt"></i>Рабочий стол</a></li>
                    <li>
                        <div class="dropdownlink"><i class="fa fa-road" aria-hidden="true"></i> Гео
                            <i class="fa fa-chevron-down" aria-hidden="true"></i>
                        </div>
                        <ul class="submenuItems">
                            <li><a href="<?= Url::to(['/admin/geo']); ?>">Города</a><span class="count"><?= Geo::find()->count() ?></span></li>
                            <li><a href="<?= Url::to(['/admin/timezone']); ?>">Временные зоны</a><span class="count"><?= GeoTimezone::find()->count() ?></span></li>
                        </ul>
                    </li>
                    <li>
                        <div class="dropdownlink"><i class="fas fa-cubes" aria-hidden="true"></i> Склад
                            <i class="fa fa-chevron-down" aria-hidden="true"></i>
                        </div>
                        <ul class="submenuItems">
                            <li><a href="<?= Url::to(['/admin/catalog']); ?>">Товары <span class="count"><?= Product::find()->count() ?></span></a></li>
                            <li><a href="<?= Url::to(['/admin/catalog/product-backend/index']); ?>">Товары <span class="count"><?= Product::find()->count() ?></span></a></li>
                            <li><a href="<?= Url::to(['/admin/category']); ?>">Разделы <span class="count"><?= Category::find()->count() ?></span></a></li>
                            <li><a href="<?= Url::to(['/admin/properties']); ?>">Свойства <span class="count"><?= ProductProperties::find()->count() ?></span></a></li>
                            <li><a href="<?= Url::to(['/admin/informers']); ?>">Справочники <span class="count"><?= Informers::find()->count() ?></span></a></li>
                            <li><a href="<?= Url::to(['/admin/informers-values']); ?>">Значения справочников <span class="count"><?= InformersValues::find()->count() ?></span></a></li>
                        </ul>
                    </li>
                    <li>
                        <div class="dropdownlink"><i class="fas fa-shopping-basket" aria-hidden="true"></i> Магазин
                            <i class="fa fa-chevron-down" aria-hidden="true"></i>
                        </div>
                        <ul class="submenuItems">
                            <li><a href="<?= Url::to(['/admin/order/order-backend/index']); ?>">Заказы</a> <span class="count"><?= Order::find()->count() ?></span></li>
                            <li><a href="<?= Url::to(['/admin/stocks']); ?>">Склады</a> <span class="count"><?= Stocks::find()->count() ?></span></li>
                            <li><a href="<?= Url::to(['/admin/status']); ?>">Статус заказа</a> <span class="count"><?= OrderStatus::find()->count() ?></span></li>
                            <li><a href="<?= Url::to(['/admin/delivery']); ?>">Доставки</a> <span class="count"><?= Delivery::find()->count() ?></span></li>
                            <li><a href="<?= Url::to(['/admin/payment']); ?>">Оплаты</a> <span class="count"><?= Payment::find()->count() ?></span></li>
                            <li><a href="<?= Url::to(['/admin/promo']); ?>">Промокоды</a> <span class="count"><?= Promo::find()->count() ?></span></li>
                            <li><a href="<?= Url::to(['/admin/vendor']); ?>">Поставщики</a> <span class="count"><?= Vendor::find()->count() ?></span></li>
                            <li><a href="<?= Url::to(['/admin/vendor-group']); ?>">Группы поставщиков</a> <span class="count"><?= VendorGroup::find()->count() ?></span></li>
                        </ul>
                    </li>
                    <li>
                        <div class="dropdownlink"><i class="fas fa-question-circle" aria-hidden="true"></i> Поддержка</span>
                            <i class="fa fa-chevron-down" aria-hidden="true"></i>
                        </div>
                        <ul class="submenuItems">
                            <li><a href="<?= Url::to(['/admin/support']) ?>">Обращения </a> <span class="count"><?= Tickets::find()->count() ?></span></li>
                            <li><a href="<?= Url::to(['/admin/support-category']) ?>">Разделы</a></li>
                            <li><a href="<?= Url::to(['/admin/supportstatus']) ?>">Статус</a></li>
                        </ul>
                    </li>
                    <li>
                        <div class="dropdownlink"><i class="fas fa-users" aria-hidden="true"></i> Пользователи
                            <i class="fa fa-chevron-down" aria-hidden="true"></i>
                        </div>
                        <ul class="submenuItems">
                            <li><a href="<?= Url::to(['/admin/user']) ?>">Пользователи</a> <span class="count"><?= User::find()->count() ?></span></li>
                            <li><a href="<?= Url::to(['/admin/group']) ?>">Группы</a></li>
                            <li><a href="<?= Url::to(['/admin/permission']) ?>">Разрешения</a></li>
                        </ul>
                    </li>
                    <li>
                        <div class="dropdownlink"><i class="far fa-file-alt" aria-hidden="true"></i> Контент
                            <i class="fa fa-chevron-down" aria-hidden="true"></i>
                        </div>
                        <ul class="submenuItems">
                            <li><a href="<?= Url::to(['/admin/news']) ?>">Новости</a> <span class="count"><?= News::find()->count() ?></span></li>
                            <li><a href="<?= Url::to(['/admin/newssections']) ?>">Рубрики</a></li>
                            <li><a href="<?= Url::to(['/admin/content/slider-backend/index']) ?>">Слайдеры</a></li>
                            <li><a href="<?= Url::to(['/admin/content/slider-images-backend/index']) ?>">Изображения слайдеров</a></li>
                        </ul>
                    </li>
                    <li>
                        <div class="dropdownlink"><i class="fas fa-jedi" aria-hidden="true"></i> Инструменты
                            <i class="fa fa-chevron-down" aria-hidden="true"></i>
                        </div>
                        <ul class="submenuItems">
                            <li><a href="<?= Url::to(['/admin/shortly']) ?>">Короткие ссылки</a> <span class="count"><?= ShortLinks::find()->count() ?></span></li>
                            <li><a href="<?= Url::to(['/admin/feed/feed/index']) ?>">Поисковой контент</a></li>
                            <li><a href="<?= Url::to(['/admin/sale-product']) ?>">Акционные товары</a></li>
                            <li><a href="<?= Url::to(['/admin/promo/promo/index']) ?>">Запустить акцию</a></li>
                        </ul>
                    </li>
                    <li>
                        <div class="dropdownlink"><i class="fas fa-briefcase" aria-hidden="true"></i> Персонал
                            <i class="fa fa-chevron-down" aria-hidden="true"></i>
                        </div>
                        <ul class="submenuItems">
                            <li><a href="<?= Url::to(['/admin/vacancy']) ?>">Список вакансий</a> <span class="count"><?= Vacancy::find()->count() ?></span></li>
                            <li><a href="<?= Url::to(['/admin/personal']) ?>">Сотрудники</a></li>
                        </ul>
                    </li>
                </ul>
            </div>

            <div class="bottom-controls-panel">
                <div><i class="fas fa-envelope"></i></div>
                <div><i class="fas fa-bell"></i></div>
                <div><a href="/admin/settings/"><i class="fas fa-sliders-h"></i></a></div>
                <div><a href="/logout/"><i class="fas fa-sign-out-alt"></i></a></div>
            </div>
        </div>
    </nav>
</aside>
<div class="main">
    <?= $content; ?>
</div>
<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
