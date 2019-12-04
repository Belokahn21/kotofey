<?php

use app\models\tool\seo\Title;
use app\models\entity\User;

$this->title = Title::showTitle("О зоомагазине");
$this->params['breadcrumbs'][] = ['label' => 'О зоомагазине', 'url' => ['/about/']]; ?>
<section class="about page-content">
    <h2>О нашем маленьком зоомагазине</h2>
    <p align="justify">
        Здравствуй, дорогой читатель, ты находишься в зоомагазине <b>Котофей</b> и читаешь небольшую статью о нашей
        скромной компании, наших планах, продукции, которую мы проадём нашим дорогим петомцам. Да-да, ведь наш
        основой клиент это четвероногий друг будь то собака, кошка или пернатый попугайчик или пушисты хомячок. Все вы
        наши любимые и желанные клиенты в нашем интернет-магазине зоотоваров <B>Котофей.</B>
    </p>
    <img src="/web/upload/images/lester.jpg" style="float: right; width: 200px; margin: 1%">
    <p align="justify">А это я, шотладнский прямоухий котик, автор этой статьи и причина появления магазина, кот по
        кличке Лестер и
        мне <?php echo User::calcCurrentAge("28-04-2018"); ?>. Я активный и жизнерадостный кот и люблю много общения!</p>
    <p align="justify">
        Этот замечательный магазин появился благодаря моим хозяйвам, которые в один прекрасный момент решили открыть
        свой
        магазин, после работы в одном из Барнаульских зоомагазинов. Им очень нравилось это направление. Животные,
        сервис, возможности развития - всё это они видели в нише зоотоваров.</p>
    <p align="justify">
        В нашем магазине вы найдёте любой товар для собак, котиков, птиц и хомяков. Все товары продаются от известных
        брендов зоотоваров таких как Royal Canin, Purina, Monge, Мнямс, Dreamies.
    </p>
    <p align="justify">
        Выгода нашего магазина в том, что мы без труда доставим ваш заказ прямо до порога. Вам не нужно посещять лишний
        раз магазин спеша в очередной раз с работы чтобы усеть до закрытия магазина. Мы не заставляем вас покупать у
        нас, но вы только попробуйте и позже вы не остановитесь чтобы не побаловать своего любимого домашнего петомца.
    </p>
    <p align="justify">
        Периодически в нашем магазине проводятся акции по выгодным условиям.
    </p>
    <div class="clearfix"></div>
    <!--    <h2>Наша история появления</h2>-->
    <!--    <p align="justify">-->
    <!--        На создание магазина повлияло два события. Первое событие это опыт работы в розничном магазине зоотоваров <a-->
    <!--                href="">Демарис</a>. Нам очень нравилось видеть счастливые лица клиентов, когда мы обслуживали их. К-->
    <!--        сожалению его судьба закрылась и нам пришлось искать другую работу. А-->
    <!--        второе событие это появление в нашем доме кота. Нашего главного начальника зовут Лестер, ему-->
    <!--        сейчас --><!--.<br/><br/>-->
    <!---->
    <!--    </p>-->
    <!--    <div style="display: flex; flex-direction: column; align-items: center;">-->
    <!--        <img src="/web/upload/images/lester.jpg" alt="Наш главный начальник" title="Главный руковдитель" align="middle" width="200">-->
    <!--        <div style="color: grey; font-weight: 600; font-size: 14px; font-style: italic;">Главный дегустатор</div>-->
    <!--    </div>-->
    <!--    <p align="justify">Нас объединяют несколько направлений. Желание продавать и любовь к животным. В связи с этим мы решили продавать-->
    <!--        зоотовары поскольку у нас есть зверушка ради которой это хочется делать. Возможно это звучит странно :)</p>-->
    <!--    <p align="justify">-->
    <!--        Наша цель это лояльное и доброе обслуживание наших клиентов, чтобы видеть снова улыбки и понимать, что нам рады-->
    <!--        и готовы вернутся в наш магазин снова и снова-->
    <!--    </p>-->
    <!--    <p>-->
    <!--        В нашем магазине продаются товары различных компаний, всегда свежие и в наличии:-->
    <!--    </p>-->
    <!--    <ul>-->
    <!--        <li>-->
    <!--            <a href="https://www.royal-canin.ru/" target="_blank" rel="nofollow">Royal Canin</a>-->
    <!--        </li>-->
    <!--        <li>-->
    <!--            <a href="http://mnyams.ru/" target="_blank" rel="nofollow">Мнямс</a>-->
    <!--        </li>-->
    <!--        <li>-->
    <!--            <a href="http://www.monge.ru/" target="_blank" rel="nofollow">Monge</a>-->
    <!--        </li>-->
    <!--    </ul>-->
</section>
