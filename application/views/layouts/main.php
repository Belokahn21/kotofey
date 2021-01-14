<?php

/* @var $this \yii\web\View
 * @var $content string
 * @var $parentCategories Category[]
 */

use yii\helpers\Url;
use yii\helpers\Html;
use app\assets\AppAsset;
use app\widgets\notification\Alert;
use app\modules\user\models\entity\User;
use app\modules\basket\models\entity\Basket;
use app\modules\menu\widgets\Menu\MenuWidget;
use app\modules\catalog\models\entity\Category;
use app\modules\site\widgets\SocialMe\SocialMe;
use app\modules\stock\widgets\store\StoreWidget;
use app\modules\search\widges\search\SearchWidget;
use app\modules\site_settings\models\entity\SiteSettings;
use app\modules\subscribe\widgets\subscribe\SubscribeWidget;
use app\modules\catalog\models\helpers\CategoryHelper;
use app\modules\site\widgets\AdminPanel\AdminPanel;

AppAsset::register($this);

$parentCategories = Yii::$app->cache->getOrSet('parent-cats', function () {
    return Category::find()->select(['id', 'name', 'slug'])->where(['parent' => 0])->all();
}, 3600 * 7 * 24);

$this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="google-site-verification" content="2lxEu3cepZijbEYmJ7zv4H8lhUKvX89GhMA_ujLklmk"/>
    <script src="https://kit.fontawesome.com/33cf5fcfbe.js" crossorigin="anonymous" defer></script>
    <?php if (YII_ENV == 'prod'): ?>
        <?php echo $this->render('include/head/yandex/webmaster.php'); ?>
        <?php echo $this->render('include/head/google/google_metrika.php'); ?>
    <?php endif; ?>
    <link rel="apple-touch-icon" sizes="57x57" href="/apple-icon-57x57.png">
    <link rel="apple-touch-icon" sizes="60x60" href="/apple-icon-60x60.png">
    <link rel="apple-touch-icon" sizes="72x72" href="/apple-icon-72x72.png">
    <link rel="apple-touch-icon" sizes="76x76" href="/apple-icon-76x76.png">
    <link rel="apple-touch-icon" sizes="114x114" href="/apple-icon-114x114.png">
    <link rel="apple-touch-icon" sizes="120x120" href="/apple-icon-120x120.png">
    <link rel="apple-touch-icon" sizes="144x144" href="/apple-icon-144x144.png">
    <link rel="apple-touch-icon" sizes="152x152" href="/apple-icon-152x152.png">
    <link rel="apple-touch-icon" sizes="180x180" href="/apple-icon-180x180.png">
    <link rel="icon" type="image/png" sizes="192x192" href="/android-icon-192x192.png">
    <link rel="icon" type="image/png" sizes="32x32" href="/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="96x96" href="/favicon-96x96.png">
    <link rel="icon" type="image/png" sizes="16x16" href="/favicon-16x16.png">
    <link rel="manifest" href="/manifest.json">
    <meta name="msapplication-TileColor" content="#ffffff">
    <meta name="msapplication-TileImage" content="/ms-icon-144x144.png">
    <meta name="theme-color" content="#ffffff">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body>
<?php $this->beginBody() ?>

<?= AdminPanel::widget(); ?>
<header class="header page-container">
    <div class="logo">
        <img title="Интернет-зоомагазин Котофей" alt="Интернет-зоомагазин Котофей" class="logo__image spin circle" src="/upload/images/logo150_150.png">
        <a class="logo__link" href="/">
            <div class="logo__title">kotofey.store</div>
            <div class="logo__sub-title">интернет-зоомагазин</div>
        </a>
    </div>
    <div class="phone">
        <img class="phone__icon" src="/upload/images/phone.png" alt="Телефон">
        <a href="tel:<?= SiteSettings::getValueByCode('phone_1'); ?>"
           class="js-phone-mask"><?= SiteSettings::getValueByCode('phone_1'); ?></a></div>
    <div class="header-menu-mobile">
        <div class="phone">
            <img class="phone__icon" src="/upload/images/phone.png" alt="Телефон">
            <a href="tel:<?= SiteSettings::getValueByCode('phone_1'); ?>"
               class="js-phone-mask"><?= SiteSettings::getValueByCode('phone_1'); ?></a>
        </div>
        <?php MenuWidget::widget([
            'menu_id' => 1
        ]) ?>
    </div>
</header>
<header class="header-mobile">
    <?= SearchWidget::widget([
        'view' => 'mobile'
    ]) ?>
    <div class="header-mobile-container">
        <div class="header-mobile__hamburger"><img src="/upload/images/hamburger.svg"></div>
        <div class="header-mobile__logoheader-menu"><a class="header-mobile__link" href="/">kotofey.store</a>
        </div>
        <div class="header-mobile__search js-search-toggle"><img src="/upload/images/search.png"></div>
        <div class="header-mobile__basket">
            <a href="<?= Url::to(['/checkout/']); ?>">
                <?php if ($count = Basket::count()): ?>
                    <div class="counter"><?= $count; ?></div>
                <?php endif; ?>
                <img src="/upload/images/basket.png">
            </a>
        </div>
        <div class="header-mobile__call">
            <a href="tel:<?= SiteSettings::getValueByCode('phone_1'); ?>"><img src="/upload/images/phone.png"></a>
        </div>
    </div>
    <div class="header-mobile-full active">
        <div class="header-mobile-full__group">
            <div class="header-mobile-full__title">Каталог</div>
            <div class="header-mobile-full__switch"><img src="/upload/images/arrow-top.svg" alt="Стрелка"></div>
        </div>
        <ul class="full-mobile-menu">
            <?php if ($parentCategories): ?>
                <?php foreach ($parentCategories as $category): ?>
                    <li class="full-mobile-menu__item"><a class="full-mobile-menu__link" href="<?= CategoryHelper::getDetailUrl($category); ?>"><?= $category->name; ?></a></li>
                <?php endforeach; ?>
            <?php endif; ?>
        </ul>
        <ul class="full-mobile-nav">
            <li class="full-mobile-nav__item"><a class="full-mobile-nav__link" href="<?= Url::to(['/about/']); ?>">О компании</a></li>
            <li class="full-mobile-nav__item"><a class="full-mobile-nav__link" href="<?= Url::to(['/news/']); ?>">Новости</a></li>
            <li class="full-mobile-nav__item"><a class="full-mobile-nav__link" href="<?= Url::to(['/delivery/']); ?>">Доставка и оплата</a></li>
            <li class="full-mobile-nav__item"><a class="full-mobile-nav__link" href="<?= Url::to(['/contacts/']); ?>">Контакты</a>
            </li>
        </ul>
        <div class="header-mobile-full__footer">
            <ul class="header-mobile-full-footer-menu">
                <li class="header-mobile-full-footer-menu__item">
                    <?php if (Yii::$app->user->isGuest): ?>
                        <a class="header-mobile-full-footer-menu__link" href="javascript:void(0);"
                           data-target="#signupModal" data-toggle="modal">
                            <div class="header-mobile-full-footer-menu__icon"><img src="/upload/images/lock-white.png" alt="lock"></div>
                            <div class="header-mobile-full-footer-menu__label">Регистрация/Войти на сайт</div>
                        </a>
                    <?php else: ?>
                        <a class="header-mobile-full-footer-menu__link" href="<?= Url::to(['/user/profile/index']) ?>">
                            <div class="header-mobile-full-footer-menu__icon"><img src="/upload/images/lock-white.png" alt="lock"></div>
                            <div class="header-mobile-full-footer-menu__label">Личный кабинет</div>
                        </a>
                    <?php endif; ?>
                </li>
                <li class="header-mobile-full-footer-menu__item">
                    <a class="header-mobile-full-footer-menu__link" href="<?= Url::to(['/checkout/']) ?>">
                        <div class="header-mobile-full-footer-menu__icon">
                            <?php if ($count = Basket::count() > 0): ?>
                                <div class="counter"><?= $count; ?></div>
                            <?php endif; ?>
                            <img src="/upload/images/basket-white.svg" alt="Корзина"></div>
                        <div class="header-mobile-full-footer-menu__label">Корзина заказа</div>
                    </a>
                </li>
            </ul>
        </div>
    </div>
</header>

<div class="menu-wrapper">
    <div class="menu page-container">
        <div class="menu__item hamburger js-hamburger"><img alt="Показать меню" class="hamburger__icon" src="/upload/images/hamburger.svg">
        </div>
        <div class="menu__item"><a class="menu__link" href="<?= Url::to(['/catalog/']); ?>">Каталог</a></div>
        <div class="menu__item"><a class="menu__link" href="<?= Url::to(['/promotion/']); ?>">Акции и скидки</a></div>
        <div class="menu__item">
            <?= SearchWidget::widget(); ?>
        </div>
        <div class="menu__item">
            <?php if (Yii::$app->user->isGuest): ?>
                <a class="menu__link profile" href="javascript:void(0);" data-toggle="modal" data-target="#signupModal">
                    <img class="profile__icon" src="/upload/images/lock.png" alt="Регистрация"><span>Регистрация</span>
                </a>
            <?php else: ?>
                <a class="menu__link profile" href="<?= Url::to(['/user/profile/index']); ?>">
                    <img class="profile__icon" src="/upload/images/lock.png" alt="Личный кабинет"><span>Личный кабинет</span>
                </a>
            <?php endif; ?>
        </div>

        <div class="menu__item"><a class="menu__link basket" href="<?= Url::to(['/checkout/']) ?>">
                <img class="basket__icon" src="/upload/images/basket.png" alt="Корзина">
                <div class="basket__counter<?= (Basket::count() > 0 ? '' : ' hidden'); ?>">
                    <span><?= Basket::count(); ?></span></div>
            </a>
        </div>
    </div>
    <div class="menu-full js-show-with-hamburger">
        <?php if ($parentCategories): ?>
            <?php foreach ($parentCategories as $parentCategory) : ?>
                <div class="block-menu">
                    <div class="block-menu__title"><?= $parentCategory->name; ?></div>
                    <?php if ($subsection = $parentCategory->subsections()): ?>
                        <ul class="block-menu-list">
                            <?php foreach ($subsection as $item): ?>
                                <li class="block-menu-list__item">
                                    <a class="block-menu-list__link" href="<?= CategoryHelper::getDetailUrl($item); ?>"><?= $item->name; ?></a>
                                </li>
                            <?php endforeach; ?>
                        </ul>
                    <?php endif; ?>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>
</div>


<?php if (Yii::$app->controller->id == 'site' && Yii::$app->controller->action->id == 'index'): ?>
    <?= $content; ?>
<?php else: ?>
    <div class="page-container">
        <?= $content; ?>
    </div>
<?php endif ?>


<footer class="footer page-container">
    <div class="footer-layer-1">
        <div class="footer-layer-1-left">
            <div class="footer__logo">kotofey.store</div>
            <ul class="footer-contact">
                <li class="footer-contact__item">
                    <?= StoreWidget::widget(); ?>
                </li>
                <li class="footer-contact__item">
                    <a class="footer-contact__link" href="mailto:<?= SiteSettings::getValueByCode('email'); ?>"><?= SiteSettings::getValueByCode('email'); ?></a>
                </li>
                <li class="footer-contact__item">
                    <a class="phone footer-contact__link js-phone-mask" href="tel:<?= SiteSettings::getValueByCode('phone_1'); ?>">
                        <?= SiteSettings::getValueByCode('phone_1'); ?>
                    </a>
                </li>
            </ul>
            <ul class="footer-nav">
                <li class="footer-nav__item"><a class="footer-nav__link" href="<?= Url::to(['/news']); ?>">Новости</a></li>
                <li class="footer-nav__item"><a class="footer-nav__link" href="<?= Url::to(['/about/']) ?>">О нас</a></li>
                <li class="footer-nav__item"><a class="footer-nav__link" href="<?= Url::to(['/delivery/']); ?>">Доставка и оплата</a></li>
                <li class="footer-nav__item"><a class="footer-nav__link" href="<?= Url::to(['/contacts/']); ?>">Контакты</a></li>
            </ul>
        </div>
        <div class="footer-layer-1-right">
            <div class="footer-categories-container">
                <div class="footer__title">Каталог зоотоваров</div>
                <ul class="footer-categories">
                    <?php if ($parentCategories): ?>
                        <?php foreach ($parentCategories as $item): ?>
                            <li class="footer-categories__item">
                                <a class="footer-categories__link" href="<?= CategoryHelper::getDetailUrl($item); ?>"><?= $item->name; ?></a>
                            </li>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </ul>
            </div>
            <div style="margin: auto auto;">
                <?= SubscribeWidget::widget(); ?>
                <?= SocialMe::widget(); ?>
            </div>
        </div>
    </div>
    <div class="footer-layer-2">
        <div class="requesites">
            <div class="requesites__item">ООО "Интернет-Зоомагазин Котофей", ОГРН: 1212200000022 ИНН: 2222889641 <a href="https://www.rusprofile.ru/id/1212200000022" target="_blank">(Проверить)</a></div>
            <div class="requesites__item">Разработка сайта — <a href="https://adelfo-studio.ru/" target="_blank">Adelfo</a> <img src="/upload/images/who_dev.png"></div>
        </div>
    </div>
</footer>

<?php
$signinModel = new User(['scenario' => User::SCENARIO_LOGIN]);
$signupModel = new User(['scenario' => User::SCENARIO_INSERT]);
?>
<?= $this->render('include/auth', [
    'signin' => $signinModel,
    'signup' => $signupModel,
]); ?>
<?= Alert::widget(); ?>
<script src="/js/frontend-core.min.js"></script>
<?php $this->endBody(); ?>
<?php echo $this->render('include/head/yandex/metrika.php'); ?>
<!--    --><?php //echo $this->render('include/head/fb/pixel.php'); ?>
<?php echo $this->render('include/head/jivo.php'); ?>
</body>
</html>
<?php $this->endPage(); ?>
