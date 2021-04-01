<?php

use app\modules\stock\widgets\store\StoreWidget;
use app\modules\site_settings\models\entity\SiteSettings;
use app\modules\menu\widgets\Menu\MenuWidget;
use app\modules\site\widgets\SocialMe\SocialMe;
use app\modules\catalog\models\helpers\CategoryHelper;
use app\modules\subscribe\widgets\subscribe\SubscribeWidget;
use app\modules\catalog\models\entity\ProductCategory;
use app\modules\catalog\widgets\CatalogCategories\CatalogCategoriesWidget;

/* @var $parentCategories \app\modules\catalog\models\entity\ProductCategory[] */

?>
<footer class="footer page-container">
    <div class="footer-layer-1">
        <div class="footer-col">
            <div class="footer__logo">kotofey.store</div>
            <div class="footer__description">Интернет-магазин зоотоваров</div>
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
            <?= MenuWidget::widget([
                'menu_id' => 3,
                'view' => 'footer-menu'
            ]); ?>
            <ul class="footer-payment-vairiant">
                <li class="footer-payment-vairiant__item"><img src="/images/payments/visa.jpg"/></li>
                <li class="footer-payment-vairiant__item"><img src="/images/payments/mastercard.png"/></li>
                <li class="footer-payment-vairiant__item"><img src="/images/payments/mir.jpg"/></li>
                <li class="footer-payment-vairiant__item"><img src="/images/payments/jcb.png"/></li>
            </ul>
        </div>
        <div class="footer-col">
            <div class="footer-categories-container">
                <div class="footer__title">Каталог зоотоваров</div>
                <div class="row">
                    <div class="col-6">
                        <?= CatalogCategoriesWidget::widget([
                            'select' => ['id', 'name', 'slug', 'seo_title'],
                            'where' => ['id' => 1],
                            'view' => 'footer-with-subs'
                        ]); ?>
                    </div>
                    <div class="col-6">
                        <?= CatalogCategoriesWidget::widget([
                            'select' => ['id', 'name', 'slug', 'seo_title'],
                            'where' => ['id' => 2],
                            'view' => 'footer-with-subs'
                        ]); ?>
                    </div>

                </div>
            </div>
        </div>
        <div class="footer-col">
            <div class="footer-logo">
                <img src="/images/logo.png" alt="Интернет-магазин зоотоваров">
            </div>
            <?php if ($specialCategories = ProductCategory::find()->where(['id' => [3, 4, 11]])->all()): ?>
                <ul class="footer-categories">
                    <?php foreach ($specialCategories as $item): ?>
                        <li class="footer-categories__item is-parent">
                            <a class="footer-categories__link" href="<?= CategoryHelper::getDetailUrl($item); ?>"><?= $item->seo_title; ?></a>
                        </li>
                    <?php endforeach; ?>
                </ul>
            <?php endif; ?>
            <?= SubscribeWidget::widget(); ?>
            <?= SocialMe::widget(); ?>
        </div>
    </div>
    <div class="footer-layer-2">
        <div class="requesites">
            <div class="requesites__item">ООО "Интернет-Зоомагазин Котофей", ОГРН: 1212200000022 ИНН: 2222889641 <a href="https://www.rusprofile.ru/id/1212200000022" target="_blank">(Проверить)</a></div>
            <div class="requesites__item">Разработка сайта — <a href="https://adelfo-studio.ru/" target="_blank">Adelfo</a> <img alt="Разработка сайта" src="/upload/images/who_dev.png"></div>
        </div>
    </div>
</footer>
