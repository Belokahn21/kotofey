<?php

/* @var $this \yii\web\View */

/* @var $content string */

use app\modules\geo\models\entity\GeoTimezone;
use app\modules\vacancy\models\entity\Vacancy;
use yii\helpers\Url;
use app\modules\news\models\entity\News;
use yii\helpers\Html;
use app\modules\catalog\models\entity\Product;
use app\modules\order\models\entity\Order;
use app\assets\AdminAsset;
use app\modules\support\models\entity\Tickets;
use app\modules\user\models\entity\User;
use app\widgets\notification\Alert;
use app\modules\stock\models\entity\Stocks;
use app\modules\order\models\entity\OrderStatus;
use app\modules\delivery\models\entity\Delivery;
use app\modules\payment\models\entity\Payment;
use app\modules\promo\models\entity\Promo;
use app\modules\vendors\models\entity\VendorGroup;
use app\modules\vendors\models\entity\Vendor;
use app\modules\geo\models\entity\Geo;
use app\modules\short_link\models\entity\ShortLinks;
use app\modules\catalog\models\entity\Category;
use app\modules\catalog\models\entity\ProductProperties;
use app\modules\catalog\models\entity\Informers;
use app\modules\catalog\models\entity\InformersValues;

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
<div class="page-container">
    <?= Alert::widget([
        'template' => 'backend'
    ]); ?>
    <div class="left-side-react"></div>
    <?php /*
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
                            <li><a href="<?= Url::to(['/admin/geo/geo-backend/index']); ?>">Города</a><span class="count"><?= Geo::find()->count() ?></span></li>
                            <li><a href="<?= Url::to(['/admin/geo/timezone-backend/index']); ?>">Временные зоны</a><span class="count"><?= GeoTimezone::find()->count() ?></span></li>
                        </ul>
                    </li>
                    <li>
                        <div class="dropdownlink"><i class="fas fa-cubes" aria-hidden="true"></i> Склад
                            <i class="fa fa-chevron-down" aria-hidden="true"></i>
                        </div>
                        <ul class="submenuItems">
                            <li><a href="<?= Url::to(['/admin/catalog/product-backend/index']); ?>">Товары <span class="count"><?= Product::find()->count() ?></span></a></li>
                            <li><a href="<?= Url::to(['/admin/catalog/product-category-backend/index']); ?>">Разделы <span class="count"><?= Category::find()->count() ?></span></a></li>
                            <li><a href="<?= Url::to(['/admin/catalog/product-properties-backend/index']); ?>">Свойства <span class="count"><?= ProductProperties::find()->count() ?></span></a></li>
                            <li><a href="<?= Url::to(['/admin/catalog/product-informer-backend/index']); ?>">Справочники <span class="count"><?= Informers::find()->count() ?></span></a></li>
                            <li><a href="<?= Url::to(['/admin/catalog/product-informer-value-backend/index']); ?>">Значения справочников <span class="count"><?= InformersValues::find()->count() ?></span></a></li>
                        </ul>
                    </li>
                    <li>
                        <div class="dropdownlink"><i class="fas fa-shopping-basket" aria-hidden="true"></i> Магазин
                            <i class="fa fa-chevron-down" aria-hidden="true"></i>
                        </div>
                        <ul class="submenuItems">
                            <li><a href="<?= Url::to(['/admin/order/order-backend/index']); ?>">Заказы</a> <span class="count"><?= Order::find()->count() ?></span></li>
                            <li><a href="<?= Url::to(['/admin/stock/stock-backend/index']); ?>">Склады</a> <span class="count"><?= Stocks::find()->count() ?></span></li>
                            <li><a href="<?= Url::to(['/admin/order/order-status-backend/index']); ?>">Статус заказа</a> <span class="count"><?= OrderStatus::find()->count() ?></span></li>
                            <li><a href="<?= Url::to(['/admin/delivery/delivery-backend/index']); ?>">Доставки</a> <span class="count"><?= Delivery::find()->count() ?></span></li>
                            <li><a href="<?= Url::to(['/admin/payment/payment-backend/index']); ?>">Оплаты</a> <span class="count"><?= Payment::find()->count() ?></span></li>
                            <li><a href="<?= Url::to(['/admin/vendors/vendors-backend/index']); ?>">Поставщики</a> <span class="count"><?= Vendor::find()->count() ?></span></li>
                            <li><a href="<?= Url::to(['/admin/vendors/vendors-group-backend/index']); ?>">Группы поставщиков</a> <span class="count"><?= VendorGroup::find()->count() ?></span></li>
                        </ul>
                    </li>
                    <li>
                        <div class="dropdownlink"><i class="fas fa-question-circle" aria-hidden="true"></i> Поддержка</span>
                            <i class="fa fa-chevron-down" aria-hidden="true"></i>
                        </div>
                        <ul class="submenuItems">
                            <li><a href="<?= Url::to(['/admin/support/support-backend/index']) ?>">Обращения </a> <span class="count"><?= Tickets::find()->count() ?></span></li>
                            <li><a href="<?= Url::to(['/admin/support/support-category-backend/index']) ?>">Разделы</a></li>
                            <li><a href="<?= Url::to(['/admin/support/support-status-backend/index']) ?>">Статус</a></li>
                        </ul>
                    </li>
                    <li>
                        <div class="dropdownlink"><i class="fas fa-users" aria-hidden="true"></i> Пользователи
                            <i class="fa fa-chevron-down" aria-hidden="true"></i>
                        </div>
                        <ul class="submenuItems">
                            <li><a href="<?= Url::to(['/admin/user/user-backend/index']) ?>">Пользователи</a> <span class="count"><?= User::find()->count() ?></span></li>
                            <li><a href="<?= Url::to(['/admin/user/user-group-backend/index']) ?>">Группы</a></li>
                            <li><a href="<?= Url::to(['/admin/user/user-permission-backend/index']) ?>">Разрешения</a></li>
                        </ul>
                    </li>
                    <li>
                        <div class="dropdownlink"><i class="far fa-file-alt" aria-hidden="true"></i> Контент
                            <i class="fa fa-chevron-down" aria-hidden="true"></i>
                        </div>
                        <ul class="submenuItems">
                            <li><a href="<?= Url::to(['/admin/news/news-backend/index']) ?>">Новости</a> <span class="count"><?= News::find()->count() ?></span></li>
                            <li><a href="<?= Url::to(['/admin/news/news-category-backend/index']) ?>">Рубрики</a></li>
                            <li><a href="<?= Url::to(['/admin/content/slider-backend/index']) ?>">Слайдеры</a></li>
                            <li><a href="<?= Url::to(['/admin/content/slider-images-backend/index']) ?>">Изображения слайдеров</a></li>
                        </ul>
                    </li>
                    <li>
                        <div class="dropdownlink"><i class="fas fa-jedi" aria-hidden="true"></i> Инструменты
                            <i class="fa fa-chevron-down" aria-hidden="true"></i>
                        </div>
                        <ul class="submenuItems">
                            <li><a href="<?= Url::to(['/admin/short_link/short-link-backend/index']) ?>">Короткие ссылки</a> <span class="count"><?= ShortLinks::find()->count() ?></span></li>
                            <li><a href="<?= Url::to(['/admin/feed/feed/index']) ?>">Поисковой контент</a></li>
                            <li><a href="<?= Url::to(['/admin/sale-product']) ?>">Акционные товары</a></li>
                        </ul>
                    </li>
                    <li>
                        <div class="dropdownlink"><i class="fas fa-briefcase" aria-hidden="true"></i> Персонал
                            <i class="fa fa-chevron-down" aria-hidden="true"></i>
                        </div>
                        <ul class="submenuItems">
                            <li><a href="<?= Url::to(['/admin/vacancy/vacancy-backend/index']) ?>">Список вакансий</a> <span class="count"><?= Vacancy::find()->count() ?></span></li>
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
*/ ?>

    <div class="content">
        <?= $content; ?>
    </div>
</div>
<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
