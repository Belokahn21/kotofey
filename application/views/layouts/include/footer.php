<?php

use app\modules\stock\widgets\store\StoreWidget;
use app\modules\site_settings\models\entity\SiteSettings;
use app\modules\menu\widgets\Menu\MenuWidget;
use app\modules\site\widgets\SocialMe\SocialMe;
use app\modules\catalog\models\helpers\CategoryHelper;
use app\modules\subscribe\widgets\subscribe\SubscribeWidget;

/* @var $parentCategories \app\modules\catalog\models\entity\ProductCategory[] */

?>
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
            <?= MenuWidget::widget([
                'menu_id' => 3,
                'view' => 'footer-menu'
            ]); ?>
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
                <a class="footer-is-shop" href="/">Интернет-зоомагазин Котофей</a>
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
