<?php

use app\models\tool\seo\Title;
use app\widgets\Breadcrumbs;

?>
<?php $this->title = Title::showTitle("Доставка заказов");
$this->params['breadcrumbs'][] = ['label' => 'Доставка и оплата', 'url' => ['/delivery/']];
?>


<div class="page">
    <?= Breadcrumbs::widget([
        'homeLink' => [
            'label' => 'Главная ',
            'url' => Yii::$app->homeUrl,
            'title' => 'Первая страница сайта зоомагазина Котофей',
        ],
        'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
    ]); ?>
    <h1 class="page__title">Доставка и оплата</h1>
    <div class="page__group-row">
        <div class="page__left">
            <h2 class="page__sub-title">Как мы работаем?</h2>
            <div class="page__text">После оформления заказа, с вами свяжется менеджер для подтверждения заявки и уточнит сроки доставки (Обычно 1 час). <br><strong>Бесплатная доставка от 500р</strong>.</div>
            <div class="page__text">В другой город? Воспользуйтесь нашим калькулятором доставки. Введите адрес получения и выберите примерный груз для отправки.</div>
            <div class="page__text">При доставке в удалённые точки города или за город сумма доставки может быть выше обычной. Уточнить сумму доставки можно у опретаторов при подтверждении заказа.</div>
            <h2 class="page__title">Как оплатить?</h2>
            <div class="page__text">При получении заказа наличными или банковским переводом. Так же можно оплатить заказ в личном кабинете. <a href="#">Подробнее об оплате на сайте</a></div>
            <img class="payments-image" src="./assets/images/payments.png">
            <div class="page__title">Куда доставляем товар?</div>
            <div class="page__text">По городу Барнаул и всей России</div>
            <h2 class="page__title">Время доставки</h2>
            <div class="page__text">Заказы доставляются в будние дни с понедельника по пятницу в утреннее время с 9.00 до 11.00 и в вечернее время с 19.00 до 23.00</div>
            <div class="page__text">Доставка в выходные дни возможна при заказе до 17.00 пятницы.</div>
        </div>
        <div class="page__right">
            <div class="form-delivery-calc-react"></div>
        </div>
    </div>
    <script type="text/javascript" charset="utf-8" async="" src="https://api-maps.yandex.ru/services/constructor/1.0/js/?um=constructor%3A75a2c08cf453a0309392fdcb243329f2301db73bdb97f18c8bc32cb9e14c1f93&amp;width=100%25&amp;height=400&amp;lang=ru_RU&amp;scroll=true"></script>

</div>

