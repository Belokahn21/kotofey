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
    <?= HelpDeskWidget::addItem('Как вернуть деньги за заказ?', 'Согласно закону о защите прав потребителя, вы в праве до истечения 14 дней обменять товар надлежащего качества на аналогичный товар в нашем магазине. Стоит учесть перед покупокой, что правильный выбор товара залог хороших и добрых отношений между продавцом и покупателем. Перед покупкой убедитесь на 100% в своём выборе. Если вам требуется больше информации, чем та что есть на сайте - обратитесь к нам в чат либо по телефону <a class="js-phone-mask-8800" href="tel:' . SiteSettings::getValueByCode('phone_2') . '">' . SiteSettings::getValueByCode('phone_2') . '</a> чтобы мы предоставили вам больше фото, видео описания, дополнительные характеристики и так далее. Делайте покупки правильно!'); ?>
    <?= HelpDeskWidget::addItem('Сколько стоит доставка?', 'Бесплатная доставка по городу Барнаул при заказе на сумму от 500 рублей. В противном случае, если сумма заказа не набирается, то доставка оплачивается отдельно в размере 100 рублей.'); ?>
    <?= HelpDeskWidget::addItem('Как посмотреть историю заказов?', 'Все заказы оформляются без регистрации. Свои заказы вы можете посмотреть в личном кабинете, зарегестрировавшись под своим номером телефона. Оформляя заказы вводите корректно свои данные иначе есть риск потери информации, но не у нас :)'); ?>
    <?= HelpDeskWidget::addItem('Как потратить бонусы?', 'Списать бонусы можно при любом заказе, в котором нет акционных товаров. Если заказ производится через сайт, то в форме оформления заказа, есть поле чтобы указать количество списываемх бонусов. Оно доступно только, если вы авторизованы на сайте.'); ?>
    <?= HelpDeskWidget::addItem('Где получить промокод?', "Промокоды на скидку можно получить случайным образом у наших Instagram-партнеров. Мы проводим случайные раздачи через их страницы. Но не очень часто."); ?>
    <?= HelpDeskWidget::addItem('Почему доставка не всегда в день заказа?', "К сожалению это наш временный недостаток. Мы работаем напрямую с поставщиками, а значит товар находится далеко от нашей точки в следствии чего, получая заказ нам нужно время собрать его. Поэтому мы принмаем заказы в день вашего заказа, а на следующий день их формируем чтобы выполнить доставку. Если товар находится у нас на остатке, то это 100% гарантия, что вы получите заказ в день обращения."); ?>
    <?php HelpDeskWidget::end(); ?>
</div>