<?php

use app\modules\site\widgets\HelpDesk\HelpDeskWidget;

?>
<div class="js-help-panel help-panel">
    <div class="help-panel__header">
        <div class="help-panel-container">
            <div class="help-panel__title">Помощь по сайту</div>
            <a class="js-close-help-panel help-panel__close" href="#"><i class="far fa-times-circle"></i></a>
        </div>
    </div>
    <?php HelpDeskWidget::begin(); ?>
    <?= HelpDeskWidget::addItem('Сколько стоит доставка?', 'Доставка по городу Барнаул при заказе от 500 рублей - бесплатная. В противном случае, если сумма заказа не набирается, то доставка оплачивается отдельно в размере 100 рублей.'); ?>
    <?= HelpDeskWidget::addItem('Как посмотреть историю заказов?', ''); ?>
    <?= HelpDeskWidget::addItem('Как потратить бонусы?', 'Списать бонусы можно при любом заказе, в котором нет акционных товаров. Если заказ производится через сайт, то в форме оформления заказа, есть поле чтобы указать количество списываемх бонусов. Оно доступно только, если вы авторизованы на сайте.'); ?>
    <?= HelpDeskWidget::addItem('Где получить промокод?', "Промокоды на скидку можно получить случайным образом у наших Instagram-партнеров. Мы проводим случайные раздачи через их страницы. Но не очень часто."); ?>
    <?php HelpDeskWidget::end(); ?>
</div>