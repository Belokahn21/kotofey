<?php

use app\modules\order\models\entity\Order;
use app\modules\seo\models\tools\Title;
use app\widgets\Breadcrumbs;
use app\modules\catalog\models\entity\Product;
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
            <div class="about-statistic__title">Самая быстрая доставка</div>
            <div class="about-statistic__sub-title">доставляем за 1 час</div>
        </div>
        <div class="about-statistic__item">
            <div class="about-statistic__title">1 год на рынке</div>
            <div class="about-statistic__sub-title">работаем с 31.12.2020</div>
        </div>
        <div class="about-statistic__item">
            <div class="about-statistic__title">1 год на рынке</div>
            <div class="about-statistic__sub-title">работаем с 31.12.2020</div>
        </div>
    </div>
    <div class="container">
        <?= InformerSliderWidget::widget(); ?>
    </div>
    <h1 class="title">О нашем интернет-зоомагазине</h1>
    <div class="about-text">
        <div class="slider">
            <div class="swiper-container about-swiper-container">
                <div class="swiper-wrapper">
                    <div class="swiper-slide"><img src="/images/eq1.jpg"></div>
                    <div class="swiper-slide"><img src="/images/eq2.jpg"></div>
                    <div class="swiper-slide"><img src="/images/eq3.jpg"></div>
                    <div class="swiper-slide"><img src="/images/eq5.jpg"></div>
                </div>
            </div>
            <div class="swiper-pagination about-swiper-pagination"></div>
        </div>
        <p>Кстати, элементы политического процесса, вне зависимости от их<br>уровня, должны быть заблокированы в рамках своих собственных<br>рациональных ограничений.</p>
        <p>Лишь базовые сценарии поведения пользователей заблокированы<br>в рамкахсвоих<br>собственных рациональных ограничений.</p>
        <p>Равным образом, глубокий уровень погружения говорит о<br>возможностях формвоздействия.</p>
        <p>Для современного мира глубокий уровень погружения<br>требует определения и уточнения новых предложений.</p>
        <p>Ясность нашей позиции очевидна: понимание<br>сути ресурсосберегающих технологий, в своём<br>классическом представлении, допускает внедрение своевременного<br>выполнения сверхзадачи.</p>
        <p>Банальные, но неопровержимые выводы, а также представители<br>современных социальных резервов призывают нас к новым<br>свершениям, которые, в свою очередь, должны быть преданы<br>социально-демократической анафеме.</p>
        <p>Банальные, но неопровержимые выводы, а также представители современных социальных резервов призывают нас к новым свершениям, которые, в свою очередь, должны быть преданы социально-демократической анафеме.</p>
        <p>Банальные, но неопровержимые выводы, а также представители современных социальных резервов призывают нас к новым свершениям, которые, в свою очередь, должны быть преданы социально-демократической анафеме.</p>
        <p>Банальные, но неопровержимые выводы, а также представители современных социальных резервов призывают нас к новым свершениям, которые, в свою очередь, должны быть преданы социально-демократической анафеме.</p>
        <p>Банальные, но неопровержимые выводы, а также представители современных социальных резервов призывают нас к новым свершениям, которые, в свою очередь, должны быть преданы социально-демократической анафеме.</p>
        <p>Банальные, но неопровержимые выводы, а также представители современных социальных резервов призывают нас к новым свершениям, которые, в свою очередь, должны быть преданы социально-демократической анафеме.</p>
        <p>Банальные, но неопровержимые выводы, а также представители современных социальных резервов призывают нас к новым свершениям, которые, в свою очередь, должны быть преданы социально-демократической анафеме.</p>
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
</div>

