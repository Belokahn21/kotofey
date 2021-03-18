<?php

use app\widgets\Breadcrumbs;
use app\modules\seo\models\tools\Title;
use app\modules\order\models\entity\Order;
use app\modules\catalog\models\entity\Product;
use app\modules\content\widgets\slider\SliderWidget;
use app\modules\content\widgets\informers_slider\InformerSliderWidget;

$this->title = Title::show("О зоомагазине");
$this->params['breadcrumbs'][] = ['label' => 'О зоомагазине', 'url' => ['/about/']]; ?>


<div class="page">
    <?= Breadcrumbs::widget([
        'homeLink' => [
            'label' => 'Главная ',
            'url' => Yii::$app->homeUrl,
            'title' => 'Первая страница сайта зоомагазина Котофей',
        ],
        'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
    ]); ?>

    <div class="about-statistic">
        <div class="about-statistic__item">
            <div class="about-statistic__title">1 год на рынке</div>
            <div class="about-statistic__sub-title">работаем с 01.01.2020</div>
        </div>
        <div class="about-statistic__item">
            <div class="about-statistic__title">более <?= Product::find()->count(); ?> товаров</div>
            <div class="about-statistic__sub-title">
                Сухие, влажные корма, акссуары для собак
            </div>
        </div>
        <div class="about-statistic__item">
            <div class="about-statistic__title">более <?= Order::find()->select('phone')->groupBy(['phone'])->count(); ?> счастливых клиентов</div>
        </div>
        <div class="about-statistic__item">
            <div class="about-statistic__title">доставка в удобное время</div>
            <div class="about-statistic__sub-title">доставляем за 1 час</div>
        </div>
        <div class="about-statistic__item">
            <div class="about-statistic__title">1 склад</div>
            <div class="about-statistic__sub-title">возможен самовывоз</div>
        </div>
        <div class="about-statistic__item">
            <div class="about-statistic__title">бонусы за покупку</div>
            <div class="about-statistic__sub-title">система лояльности с повышением уровня</div>
        </div>
    </div>
    <div class="container">
        <?= InformerSliderWidget::widget(); ?>
    </div>
    <h1 class="title">О нашем интернет-зоомагазине</h1>
    <div class="about-text">
        <?= SliderWidget::widget(['slider_id' => 3, 'view' => 'about']) ?>

        <p>Барнаульский интернет-зоомагазин Котофей!</p>
        <p>Занимаемся продажей зоотоваров для домашних питомцев и<br>доставкой зоотоваров в городе Барнаул и по России.</p>
        <p>Мы продаём сухие и влажные корма, товары для груминга, предметы<br>интерьра такие как домики, когтеточки для кошек, лежанки<br></p>аксессуары в том числе одежда для животных, игрушки.<br><br>
        <p>Каждый месяц в нашем интернет-магазине появляются интересные<br>акции от торговых марок <strong>Royal Canin</strong>, <strong>Hiil's</strong>, <strong>Purina</strong>. Акции содержат<br>скидки на товары, выгодные предложения 1+1 и другие приятные<br>условия!</p><br>
        <p>Наши клиенты имеют возможность:</p>
        <ul>
            <li>Удобно заказать зоотовары с доставкой на дом;</li>
            <li>Получить рекомендации по выбору товара;</li>
            <li>Сравнить интересующие товары через сайт;</li>
            <li>Задать вопросы оператору прямо в чате сайта;</li>
        </ul>
        <p>Наша цель - стать намного удобней чтобы покупки совершались с<br>большим удобством и выгодой для клиента!</p>
        <p>Во время пандемии нужно сокращать походы в общественные<br>места. Наш магазин вам поможет и в этом. Курьеры службы<br>доставки используют средства защиты для предотвращения<br>распространения вируса COVID-19. Если вас интересует бесконтактная доставка, то вы можете попросить оператора предоставить эту возможность при получении заказа.</p>

    </div>
    <h2 class="title">Отзывы о нас</h2>
    <div class="feedback-wrapper">
        <form class="feedback-form" method="post">
            <div class="feedback-form__title">Оставить отзыв</div>
            <input class="feedback-form__input" type="text" placeholder="Представьтесь">
            <input class="feedback-form__input js-mask-ru" type="text" placeholder="Телефон">
            <textarea class="feedback-form__input" placeholder="Ваш отзыв"></textarea>
            <button class="btn-main" type="submit">Опубликовать отзыв</button>
        </form>
        <div class="feedback-list">
            <div class="feedback-list__item">
                <div class="feedback-list__isUser" data-toggle="tooltip" data-placement="right" rel="tooltip" title="Пользователь сайта"><i class="fas fa-user-check"></i></div>
                <div class="feedback-list__personal">
                    <div class="feedback-list__date">(04.02.2020)</div>
                    <div class="feedback-list__author">Борис Вишневский</div>
                    <div class="feedback-list__isBuyer" data-toggle="tooltip" data-placement="bottom" rel="tooltip" title="Действующий покупатель"><i class="fas fa-coins"></i></div>
                </div>
                <div class="feedback-list__comment">Замечательный магазин. Всегда доставляют в срок, целые упаковки, свежий корм, никаких просрочек. Рекомендую всем тем более есть скидка за друга!</div>
            </div>
        </div>
    </div>

    <script type="text/javascript" charset="utf-8" async src="https://api-maps.yandex.ru/services/constructor/1.0/js/?um=constructor%3A75a2c08cf453a0309392fdcb243329f2301db73bdb97f18c8bc32cb9e14c1f93&amp;width=100%25&amp;height=400&amp;lang=ru_RU&amp;scroll=true"></script>

</div>

