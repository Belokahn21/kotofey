<?php
/* @var $product \app\modules\catalog\models\entity\Product */

use app\modules\vendors\models\entity\Vendor;
use app\modules\catalog\models\entity\Product;
use app\modules\site_settings\models\entity\SiteSettings;

?>
<div class="product-info">
    <?php if ($product->count > 0): ?>
        <div class="green"><strong>В налиии <?= $product->count; ?> шт.</strong></div>
        <div class="green"><strong>Доставим сегодня после 19.00</strong></div>
    <?php elseif ($product->status_id == Product::STATUS_WAIT or $product->status_id == Product::STATUS_DRAFT): ?>
    <?php else:
        $nDay = date('w');

        // условия роял канин
        if ($product->vendor_id == Vendor::VENDOR_ID_ROYAL):
            if (date('H') < 16 || date('i') < 30):
                echo '<div class="green"><strong>Товар в наличии. Доставка будет сегодня после 19.00</strong></div><br/>';
            else:
                echo '<div class="green"><strong>Товар в наличии. Доставка на завтра после 19.00.</strong></div><br/>';
            endif;
        endif;

        // условия хилса
        if ($product->vendor_id == Vendor::VENDOR_ID_HILLS):
            if (date('H') < 16):
                echo '<div class="green"><strong>Товар в наличии. Доставка на завтра после 19.00</strong></div><br/>';
            else:
                echo '<div class="green"><strong>Товар в наличии. Доставка на после-завтра после 19.00.</strong></div><br/>';
            endif;
        endif;

        // условия валты
        if ($product->vendor_id == Vendor::VENDOR_ID_VALTA):
            if ($nDay <= 2 and date('H') < 11):
                echo '<div class="green"><strong>Товар в наличии. Доставка в ближайшую среду после 19.00. ' . \Yii::t(
                        'app',
                        'Через {n, plural, =0{# дней} =1{# день} one{# день} few{# дней} many{# дней} other{# дней}}',
                        ['n' => 3 - date('w')]
                    ) . '.</strong></div><br/>';
            else:
                echo '<div class="green"><strong>Товар в наличии. Доставка в следующую среду после 19.00.</strong></div><br/>';
            endif;
        endif;

        // условия форзы
        if ($product->vendor_id == Vendor::VENDOR_ID_FORZA):
            if (date('w') >= 2):
                echo '<div class="green"><strong>Товар в наличии. Доставка в ближайшую пятницу.</strong></div><br/>';
            elseif (date('w') >= 5):
                echo '<div class="green"><strong>Товар в наличии. Доставка в ближайший вторник.</strong></div><br/>';
            endif;
        endif;

        // условия Пурины
        if ($product->vendor_id == Vendor::VENDOR_ID_PURINA):
            if ($nDay == 0 || $nDay == 6):
                echo '<div class="green"><strong>Товар в наличии. Доставка в ближайшую среду.</strong></div><br/>';
            else:
                if ($nDay >= 5):
                    echo '<div class="green"><strong>Товар в наличии. Доставка в ближайшую среду.</strong></div><br/>';
                elseif ($nDay >= 2 && date('H') > 17):
                    echo '<div class="green"><strong>Товар в наличии. Доставка в ближайшую пятницу.</strong></div><br/>';
                else:
                    echo '<div class="green"><strong>Товар в наличии. Доставка в ближайшую среду.</strong></div><br/>';
                endif;
            endif;
        endif;

        // условия Бош/Санабель
        if ($product->vendor_id == Vendor::VENDOR_ID_SANABELLE):
            if ($nDay <= 4 && date('H') < 15):
                echo '<div class="green"><strong>Товар в наличии. Доставка в ближайшую пятницу.</strong></div><br/>';
            else:
                echo '<div class="green"><strong>Товар в наличии. Доставка в следующую пятницу!</strong></div><br/>';
            endif;
        endif;

        // для всех остальных (мясоешки, сибагро)
        if (in_array($product->vendor_id, [Vendor::VENDOR_ID_SIBAGRO, Vendor::VENDOR_ID_TAVELA, Vendor::VENDOR_ID_LIVERA, Vendor::VENDOR_ID_SIBMARKET])):
            echo '<div class="green"><strong>Товар в наличии. Доставка на завтра после 19.00.</strong></div><br/>';
        endif;

    endif;
    ?>
    <div class="product-info__title">При заказе на сумму от 500 рублей бесплатная доставка по городу Барнаул</div>
    <div class="product-info__note">
        <br>
        <ul class="fa-ul">
            <li>
                <span class="fa-li"><i class="fas fa-paw"></i></span>
                Доставляем по городу Барнаулу, поселки: Власиха, Лесной, Центральный, Южный, Авиатор, Спутник.
            </li>
            <li>
                <span class="fa-li"><i class="fas fa-paw"></i></span>
                Доставка в Новоалтайск, Казеную заимку, Гоньбу, Научный городок +150 рублей к любой сумме заказа
            </li>
            <li>
                <span class="fa-li"><i class="fas fa-paw"></i></span>
                Доставка в ЗАТО Сибирский +300 рублей к любой сумме заказа
            </li>
            <li>
                <span class="fa-li"><i class="fas fa-paw"></i></span>
                Для доставки в другие точки уточняйте по телефону<strong> <a class="js-phone-mask" style="color: black;" href="tel:<?= SiteSettings::getValueByCode('phone_1'); ?>"><?= SiteSettings::getValueByCode('phone_1'); ?></a></strong>
            </li>
        </ul>
        <div class="product-info__title">Время доставки</div>
        <div class="product-info__note">Заказы доставляются каждый день после 19.00. Доставка в выходные только при заказе с понедельника по пятницу!</div>
        <br/>
    </div>
</div>