<?php

/* @var $this \yii\web\View
 * @var $content string
 */

use yii\helpers\Url;
use yii\helpers\Html;
use app\assets\AppAsset;
use app\widgets\notification\Alert;
use app\widgets\admin_panel\AdminPanel;
use app\modules\user\models\entity\User;
use app\modules\basket\models\entity\Basket;
use app\modules\catalog\models\entity\Category;
use app\modules\search\widges\search\SearchWidget;
use app\modules\site_settings\models\entity\SiteSettings;
use app\modules\subscribe\widgets\subscribe\SubscribeWidget;

AppAsset::register($this);

$parentCategories = Category::find()->where(['parent' => 0])->all();

$this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="google-site-verification" content="2lxEu3cepZijbEYmJ7zv4H8lhUKvX89GhMA_ujLklmk"/>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.3/css/all.css"
          integrity="sha384-UHRtZLI+pbxtHCWp1t77Bi1L4ZtiqrqD80Kn4Z8NTSRyMA2Fd33n5dQ8lWUE00s/" crossorigin="anonymous">
	<?php if (YII_ENV == 'prod'): ?>
		<?php echo $this->render('include/head/yandex/metrika.php'); ?>
		<?php echo $this->render('include/head/yandex/webmaster.php'); ?>
		<?php echo $this->render('include/head/google/google_metrika.php'); ?>
		<?php echo $this->render('include/head/jivo.php'); ?>
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
        <img title="Интернет-зоомагазин Котофей" alt="Интернет-зоомагазин Котофей" class="logo__image spin circle" src="/upload/images/logo.png">
        <a class="logo__link" href="/">
            <div class="logo__title">kotofey.store</div>
            <div class="logo__sub-title">интернет-зоомагазин</div>
        </a>
    </div>
    <div class="phone">
        <img class="phone__icon" src="/upload/images/phone.png">
        <a href="tel:<?= SiteSettings::getValueByCode('phone_1'); ?>" class="js-phone-mask"><?= SiteSettings::getValueByCode('phone_1'); ?></a></div>
    <div class="header-menu-mobile">
        <div class="phone">
            <img class="phone__icon" src="/upload/images/phone.png">
            <a href="tel:<?= SiteSettings::getValueByCode('phone_1'); ?>" class="js-phone-mask"><?= SiteSettings::getValueByCode('phone_1'); ?></a>
        </div>
        <ul class="header-menu">
            <li class="header-menu__item"><a class="header-menu__link" href="<?= Url::to(['/about/']); ?>">О компании</a></li>
            <li class="header-menu__item"><a class="header-menu__link" href="<?= Url::to(['/delivery/']); ?>">Доставка и оплата</a>
            </li>
            <li class="header-menu__item"><a class="header-menu__link" href="<?= Url::to(['/contacts/']); ?>">Контакты</a></li>
        </ul>
    </div>
</header>
<header class="header-mobile">
    <div class="header-mobile-container">
        <div class="header-mobile__hamburger"><img src="/upload/images/hamburger.svg"></div>
        <div class="header-mobile__logoheader-menu"><a class="header-mobile__link" href="/">kotofey.store</a>
        </div>
        <div class="header-mobile__search"><img src="/upload/images/search.png"></div>
        <div class="header-mobile__basket">
            <a href="<?= Url::to(['/checkout/']); ?>">
                <div class="counter"><?= Basket::count(); ?></div>
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
            <div class="header-mobile-full__switch"><img src="/upload/images/arrow-top.svg"></div>
        </div>
        <ul class="full-mobile-menu">
			<?php foreach ($parentCategories as $category): ?>
                <li class="full-mobile-menu__item"><a class="full-mobile-menu__link" href="<?= $category->detail; ?>"><?= $category->name; ?></a></li>
			<?php endforeach; ?>
        </ul>
        <ul class="full-mobile-nav">
            <li class="full-mobile-nav__item"><a class="full-mobile-nav__link" href="<?= Url::to(['/about/']); ?>">О компании</a>
            </li>
            <li class="full-mobile-nav__item"><a class="full-mobile-nav__link" href="<?= Url::to(['/news/']); ?>">Новости</a></li>
            <li class="full-mobile-nav__item"><a class="full-mobile-nav__link" href="<?= Url::to(['/delivery/']); ?>">Доставка и оплата</a></li>
            <li class="full-mobile-nav__item"><a class="full-mobile-nav__link" href="<?= Url::to(['/contacts/']); ?>">Контакты</a>
            </li>
        </ul>
        <div class="header-mobile-full__footer">
            <ul class="header-mobile-full-footer-menu">
                <li class="header-mobile-full-footer-menu__item">
					<?php if (Yii::$app->user->isGuest): ?>
                        <a class="header-mobile-full-footer-menu__link" href="javascript:void(0);" data-target="#signupModal" data-toggle="modal">
                            <div class="header-mobile-full-footer-menu__icon"><img src="/upload/images/lock-white.png"></div>
                            <div class="header-mobile-full-footer-menu__label">Регистрация/Войти на сайт</div>
                        </a>
					<?php else: ?>
                        <a class="header-mobile-full-footer-menu__link" href="<?= Url::to(['/user/profile/index']) ?>">
                            <div class="header-mobile-full-footer-menu__icon"><img src="/upload/images/lock-white.png"></div>
                            <div class="header-mobile-full-footer-menu__label">Личный кабинет</div>
                        </a>
					<?php endif; ?>
                </li>
                <li class="header-mobile-full-footer-menu__item">
                    <a class="header-mobile-full-footer-menu__link" href="<?= Url::to(['/checkout/']) ?>">
                        <div class="header-mobile-full-footer-menu__icon">
                            <div class="counter"><?= Basket::count(); ?></div>
                            <img src="/upload/images/basket-white.svg"></div>
                        <div class="header-mobile-full-footer-menu__label">Корзина заказа</div>
                    </a>
                </li>
            </ul>
        </div>
    </div>
</header>
<div class="menu-wrapper">
    <div class="menu page-container">
        <div class="menu__item hamburger js-hamburger"><img class="hamburger__icon" src="/upload/images/hamburger.svg">
        </div>
        <div class="menu__item"><a class="menu__link" href="<?= Url::to(['/catalog/']); ?>">Каталог</a></div>
        <div class="menu__item"><a class="menu__link" href="<?= Url::to(['/news/']); ?>">Новости</a></div>
        <div class="menu__item">
			<?= SearchWidget::widget(); ?>
        </div>
        <div class="menu__item">
			<?php if (Yii::$app->user->isGuest): ?>
                <a class="menu__link profile" href="javascript:void(0);" data-toggle="modal" data-target="#signupModal">
                    <img class="profile__icon" src="/upload/images/lock.png"><span>Регистрация</span>
                </a>
			<?php else: ?>
                <a class="menu__link profile" href="<?= Url::to(['/user/profile/index']); ?>">
                    <img class="profile__icon" src="/upload/images/lock.png"><span>Личный кабинет</span>
                </a>
			<?php endif; ?>
        </div>

        <div class="menu__item"><a class="menu__link basket" href="<?= Url::to(['/checkout/']) ?>">
                <img class="basket__icon" src="/upload/images/basket.png">
                <div class="basket__counter<?= (Basket::count() > 0 ? '' : ' hidden'); ?>"><span><?= Basket::count(); ?></span></div>
            </a>
        </div>
    </div>
    <div class="menu-full js-show-with-hamburger">
		<?php foreach ($parentCategories as $parentCategory) : ?>
            <div class="block-menu">
                <div class="block-menu__title"><?= $parentCategory->name; ?></div>
				<?php if ($subsection = $parentCategory->subsections()): ?>
                    <ul class="block-menu-list">
						<?php foreach ($subsection as $item): ?>
                            <li class="block-menu-list__item">
                                <a class="block-menu-list__link" href="<?= $item->detail; ?>"><?= $item->name; ?></a>
                            </li>
						<?php endforeach; ?>
                    </ul>
				<?php endif; ?>
            </div>
		<?php endforeach; ?>
    </div>
</div>
<div class="page-container">
	<?= $content; ?>
</div>
<footer class="footer page-container">
    <div class="footer-layer-1">
        <div class="footer-layer-1-left">
            <div class="footer__logo">kotofey.store</div>
            <ul class="footer-contact">
                <li class="footer-contact__item">
                    <a class="footer-contact__link address" href="javascript:void(0);">
                        Баранул ул.Северо-Западная, 6Б <img src="/upload/images/gps.png">
                    </a>
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
					<?php foreach ($parentCategories as $item): ?>
                        <li class="footer-categories__item">
                            <a class="footer-categories__link" href="<?= $item->detail; ?>"><?= $item->name; ?></a>
                        </li>
					<?php endforeach; ?>
                </ul>
            </div>
			<?= SubscribeWidget::widget(); ?>
        </div>
    </div>
    <div class="footer-layer-2">
        <div class="requesites">
            <div class="requesites__item">ИП Васин К.В., ОГРН: 319222500105168 ИНН: 222261129226 <a href="https://www.rusprofile.ru/ip/319222500105168" target="_blank">(Проверить)</a></div>
            <div class="requesites__item">Разработка сайта — <a href="javascript:void(0);">Adelfo</a> <img src="/upload/images/who_dev.png"></div>
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
<script src="/js/frontend-core.min.js"></script>
<?= Alert::widget(); ?>
<?php $this->endBody(); ?>
</body>
</html>
<?php $this->endPage(); ?>
