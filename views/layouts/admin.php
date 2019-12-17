<?php

/* @var $this \yii\web\View */
/* @var $content string */

use app\models\entity\Vacancy;
use yii\helpers\Url;
use app\models\entity\News;
use yii\helpers\Html;
use app\models\entity\Product;
use app\models\entity\Order;
use app\assets\AdminAsset;
use app\models\entity\support\Tickets;
use app\models\entity\User;
use app\widgets\notification\Notify;
use app\models\entity\Sliders;
use app\models\entity\Geo;
use app\models\entity\ShortLinks;

AdminAsset::register($this);
$this->beginPage();
$user = \app\models\entity\User::findOne(Yii::$app->user->identity->id);
?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.3/css/all.css" integrity="sha384-UHRtZLI+pbxtHCWp1t77Bi1L4ZtiqrqD80Kn4Z8NTSRyMA2Fd33n5dQ8lWUE00s/" crossorigin="anonymous">
    <meta name="viewport" content="width=device-width, initial-scale=1">
	<?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
	<?php $this->head() ?>
</head>
<body>
<?php $this->beginBody() ?>
<?= Notify::widget(); ?>
<aside class="left-sidebar">
    <nav class="dashboard-left-sidebar" data-show="false">
        <!--        <button class="show-dashboard">X</button>-->
        <div class="dashboard-left-sidebar__content">
            <h4 style="color: white; text-align: center; padding: 0 0 2% 0; margin: 0; border-bottom: 1px grey solid;">
                Панель управления</h4>
            <div class="current-profile">
                <div class="avatar-wrap">
                    <img class="current-profile__avatar"
                         src="/upload/<?= ((!empty($user->avatar)) ? $user->avatar : "/images/boy.png"); ?>"
                         alt="Аватар пользователя <?= $user->email; ?>"
                         title="Аватар пользователя <?= $user->email; ?>">
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
                <ul class="panel-menu">
                    <li class="panel-menu__item"><a href="/"><i class="fas fa-home"></i>Сайт</a></li>
                    <li class="panel-menu__item"><a href="/admin/"><i class="fa fa-tachometer-alt"></i>Рабочий стол</a></li>
                    <li class="panel-menu__item">
                        <a href="/admin/"><i class="fas fa-globe-asia"></i>Гео</a>
                        <ul>
                            <li class="panel-menu__item sub"><a href="/admin/geo/">Гео объекты<span class="count"><?= Geo::find()->count() ?></span></a></li>
                        </ul>
                    </li>
                    <li class="panel-menu__item"><a href="/admin/"><i class="fa fa-shopping-cart"></i>Магазин</a>
                        <ul>
                            <li class="panel-menu__item sub"><a href="/admin/order/">Заказы
                                    <span class="count"><?= Order::find()->count() ?></span>
                                </a>
                                <ul>
                                    <li class="panel-menu__item sub"><a href="/admin/status/">Статус заказа</a></li>
                                </ul>
                            </li>
                            <li class="panel-menu__item sub"><a href="/admin/delivery/">Доставки</a></li>
                            <li class="panel-menu__item sub"><a href="/admin/payment/">Оплаты</a></li>
                            <li class="panel-menu__item sub"><a href="/admin/selling/">Продажи</a></li>
                            <li class="panel-menu__item sub"><a href="/admin/promo/">Промокоды</a></li>
                            <li class="panel-menu__item sub"><a href="/admin/provider/">Поставщики</a></li>
                        </ul>
                    </li>
                    <li class="panel-menu__item"><a href="/admin/catalog/"><i class="fas fa-cookie"></i>Товары<span
                                    class="count"><?= Product::find()->count() ?></span></a>
                        <ul>
                            <li class="panel-menu__item sub"><a href="/admin/category/">Разделы</a></li>
                            <li class="panel-menu__item sub"><a href="/admin/properties/">Свойства</a></li>
                            <li class="panel-menu__item sub">
                                <a href="/admin/informers/">Справочники</a>
                                <ul>
                                    <li><a href="/admin/informers-values/">Значения справочников</a></li>
                                </ul>
                            </li>
                            <li class="panel-menu__item sub"><a href="/admin/stocks/">Склады</a></li>
                        </ul>
                    </li>
                    <li class="panel-menu__item"><a href="/admin/support/"><i
                                    class="far fa-life-ring"></i>Поддержка<span
                                    class="count"><?= Tickets::find()->count() ?></span></a>
                        <ul>
                            <li class="panel-menu__item sub"><a href="/admin/support-category/">Разделы</a></li>
                            <li class="panel-menu__item sub"><a href="/admin/supportstatus/">Статусы</a></li>
                        </ul>
                    </li>
                    <li class="panel-menu__item"><a href="/admin/user/"><i class="fa fa-user-alt"></i>Пользователи<span
                                    class="count"><?= User::find()->count(); ?></span></a>
                        <ul>
                            <li class="panel-menu__item sub"><a href="/admin/group/">Группы</a></li>
                            <li class="panel-menu__item sub"><a href="/admin/permission/">Разрешения</a></li>
                        </ul>
                    </li>
                    <li class="panel-menu__item"><a href="/admin/"><i class="fas fa-pencil-alt"></i>Контент</a>
                        <ul>
                            <li class="panel-menu__item sub">
                                <a href="/admin/news/">
                                    Новости<span class="count"><?= News::find()->count() ?></span>
                                </a>
                                <ul>
                                    <li class="panel-menu__item sub"><a href="/admin/newssections/">Рубрики</a></li>
                                </ul>
                            </li>
                            <li class="panel-menu__item sub">
                                <a href="<?php echo Url::to(['admin/sliders']); ?>">
                                    Слайдеры<span class="count"><?= Sliders::find()->count() ?></span>
                                </a>
                                <ul>
                                    <li class="panel-menu__item sub">
                                        <a href="<?php echo Url::to(['admin/sliderimages']) ?>">Изображения</a>
                                    </li>
                                </ul>
                            </li>
                        </ul>
                    </li>
                    <li class="panel-menu__item"><a href="<?= Url::to(['admin/seo']) ?>"><i class="fab fa-empire"></i>SEO</a>
                        <ul>
                            <li class="panel-menu__item sub">
                                <a href="<?= Url::to(['admin/shortly']); ?>">
                                    Короткие ссылки<span class="count"><?= ShortLinks::find()->count() ?></span>
                                </a>
                            </li>
                        </ul>
                    </li>
                    <li class="panel-menu__item">
                        <a href="<?= Url::to(['admin/management']) ?>"><i class="fas fa-users"></i>Персонал</a>
                        <ul>
                            <li class="panel-menu__item sub">
                                <a href="<?= Url::to(['admin/vacancy']); ?>">
                                    Список вакансий<span class="count"><?= Vacancy::find()->count() ?></span>
                                </a>
                            </li>
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
