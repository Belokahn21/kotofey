<?php

use app\modules\site_settings\models\entity\SiteSettings;
use app\modules\search\widges\search\SearchWidget;
use app\modules\menu\widgets\Menu\MenuWidget;
use app\modules\basket\models\entity\Basket;
use yii\helpers\Url;
use app\modules\catalog\models\helpers\ProductCategoryHelper;

?>
<header class="header page-container">
    <div class="logo">
        <?php if (empty(Yii::$app->request->getPathInfo())): ?>
            <img title="Интернет-зоомагазин Котофей" alt="Интернет-зоомагазин Котофей" class="logo__image spin circle" src="/upload/images/logo150_150.png">
        <?php else: ?>
            <a href="/">
                <img title="Интернет-зоомагазин Котофей" alt="Интернет-зоомагазин Котофей" class="logo__image spin circle" src="/upload/images/logo150_150.png">
            </a>
        <?php endif; ?>
        <a class="logo__link" href="/">
            <div class="logo__title">kotofey.store</div>
            <div class="logo__sub-title">интернет-зоомагазин</div>
            <div class="logo__city">В Барнауле</div>
        </a>
    </div>

    <div class="phone">
        <img class="phone__icon" src="/images/phone-black.png" alt="Телефон">
        <div class="c8800-group">
            <a href="tel:<?= SiteSettings::getValueByCode('phone_2'); ?>" class="js-phone-mask-8800">
                <?= SiteSettings::getValueByCode('phone_2'); ?>
            </a>
            <div class="note">горячая линия - пн-вс 10:00-21:00</div>
            <?php /*
            <a class="wh-group-link" href="whatsapp://send?phone=<?= SiteSettings::getValueByCode('phone_1'); ?>">
                <img class="wh-group-icon" src="/images/whatsapp32x32.png" width="24px">
            </a>
 */ ?>
        </div>
    </div>
    <div class="header-menu-mobile">
        <div class="phone">
            <img class="phone__icon" src="/upload/images/phone.png" alt="Телефон">
            <a href="tel:<?= SiteSettings::getValueByCode('phone_2'); ?>" class="js-phone-mask-8800"><?= SiteSettings::getValueByCode('phone_2'); ?></a>
        </div>
        <?= MenuWidget::widget([
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
            <a href="tel:<?= SiteSettings::getValueByCode('phone_2'); ?>"><img src="/upload/images/phone.png"></a>
        </div>
    </div>
    <div class="header-mobile-full active">
        <div class="header-mobile-full__group">
            <div class="header-mobile-full__title">Зоотовары</div>
            <div class="header-mobile-full__switch"><img src="/upload/images/arrow-top.svg" alt="Стрелка"></div>
        </div>
        <ul class="full-mobile-menu">
            <?php if ($parentCategories): ?>
                <?php foreach ($parentCategories as $category): ?>
                    <li class="full-mobile-menu__item"><a class="full-mobile-menu__link" href="<?= ProductCategoryHelper::getDetailUrl($category); ?>"><?= $category->name; ?></a></li>
                <?php endforeach; ?>
            <?php endif; ?>
        </ul>
        <?= MenuWidget::widget([
            'menu_id' => 2,
            'view' => 'mobile-full'
        ]); ?>
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