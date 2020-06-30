<?php

use app\modules\site_settings\models\entity\SiteSettings;

?>
<!-- Modal -->
<div class="modal fade" id="modal-product-detail-delivery" tabindex="-1" role="dialog" aria-labelledby="modal-product-detail-delivery-label" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Доставка заказов</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" style="text-align: justify;">
                <p style="text-indent: 1.25em;">
                    В нашем зоомагазине для клиентов есть бесплатная доставка прямо до порога при заказе от 500 рублей.
                    Бесплатная доставка зоотоваров работает в черте города. Если район доставки находится за пределеами города, то сумма доставки может отличатся от базовой.
                    Для точной информации о сумме доставке за пределы города узнавайте по операторов по телефону
                    <a class="phone_mask" style="color: #ff1a4a; font-weight: 600;" href="tel:<?= SiteSettings::getValueByCode('phone_1'); ?>">
                        <?= SiteSettings::getValueByCode('phone_1'); ?>
                    </a>
                </p>
                <br/>
                <p style="text-indent: 1.25em;">
                    Отдельными районами являются посёлок Центральный, Октябрьский, Новоалтайка, Бобровка, село Лебяжье, Затон
                </p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn-main" data-dismiss="modal">Закрыть</button>
            </div>
        </div>
    </div>
</div>