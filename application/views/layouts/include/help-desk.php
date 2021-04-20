<?php

use app\modules\site\widgets\HelpDesk\HelpDeskWidget;
use app\modules\site_settings\models\entity\SiteSettings;

?>
<div class="js-help-panel help-panel">
    <div class="help-panel__header">
        <div class="help-panel-container">
            <div class="help-panel__title">Помощь по сайту</div>
            <a class="js-close-help-panel help-panel__close" href="#"><i class="far fa-times-circle"></i></a>
        </div>
    </div>
    <?php HelpDeskWidget::begin(); ?>
    <?= HelpDeskWidget::addItem('Как вернуть деньги за заказ?', 'Согласно закону о защите прав потребителя, вы в праве до истечения 14 дней обменять товар надлежащего качества на аналогичный товар в нашем магазине. Стоит учесть перед покупокой, что правильный выбор товара залог хороших и добрых отношений между продавцом и покупателем. Перед покупкой убедитесь на 100% в своём выборе. Если вам требуется больше информации, чем та что есть на сайте - обратитесь к нам в чат либо по телефону <a class="js-phone-mask" href="tel:' . SiteSettings::getValueByCode('phone_1') . '">' . SiteSettings::getValueByCode('phone_1') . '</a> чтобы мы предоставили вам больше фото, видео описания, дополнительные характеристики и так далее. Делайте покупки правильно!'); ?>
    <?= HelpDeskWidget::addItem('Сколько стоит доставка?', 'Доставка по городу Барнаул при заказе от 500 рублей - бесплатная. В противном случае, если сумма заказа не набирается, то доставка оплачивается отдельно в размере 100 рублей.'); ?>
    <?= HelpDeskWidget::addItem('Как посмотреть историю заказов?', 'Все заказы оформляются без регистрации. Свои заказы вы можете посмотреть в личном кабинете, зарегестрировавшись под своим номером телефона. Оформляя заказы вводите корректно свои данные иначе есть риск потери информации.'); ?>
    <?= HelpDeskWidget::addItem('Как потратить бонусы?', 'Списать бонусы можно при любом заказе, в котором нет акционных товаров. Если заказ производится через сайт, то в форме оформления заказа, есть поле чтобы указать количество списываемх бонусов. Оно доступно только, если вы авторизованы на сайте.'); ?>
    <?= HelpDeskWidget::addItem('Где получить промокод?', "Промокоды на скидку можно получить случайным образом у наших Instagram-партнеров. Мы проводим случайные раздачи через их страницы. Но не очень часто."); ?>
    <?php HelpDeskWidget::end(); ?>
</div>