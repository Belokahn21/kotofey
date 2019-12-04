<?php

use app\models\tool\seo\Title;
use app\models\tool\System;

?>
<? $this->title = Title::showTitle("Доставка заказов");
$this->params['breadcrumbs'][] = ['label' => 'Доставка', 'url' => ['/delivery/']];
?>
<h1>Доставка</h1>
<p align="justify">
    В магзине <b>Котофей</b> действует бесплатная доставка по городу Барнаул своим клиентам. Так же мы доставляем товар
    в регионы по всей территории России. Сумма доставки зависит от выбранного способа доставки, обычно им является
    транспортная компания. Каждая транспортная компания предоставляет свои тарифы на доставку поэтому при заказе в
    другой город уточняйте сумму доставки у транспортных компаний
</p>
<!--<ul class="list-delivery-comp">-->
<!--    <li class="list-delivery-comp-item">-->
<!--        <div class="list-delivery-comp-item__content">-->
<!--            <a href="https://www.cdek.ru/" target="_blank">-->
<!--                <img src="https://s.zagranitsa.com/images/guides/18924/original/748fbe3fc1c3f0d90c91ef3c6bb53359.jpg?1439834688"-->
<!--                     alt="Транспортная компания СДЭК" title="Транспортная компания СДЭК"/>-->
<!--            </a>-->
<!--        </div>-->
<!--    </li>-->
<!--    <li class="list-delivery-comp-item">-->
<!--        <div class="list-delivery-comp-item__content">-->
<!--            <a href="https://barnaul.dellin.ru/" target="_blank">-->
<!--                <img src="/web/upload/images/delline.png" alt="Транспортная компания Деловые линии"-->
<!--                     title="Транспортная компания Деловые линии">-->
<!--            </a>-->
<!--        </div>-->
<!--    </li>-->
<!--    <li class="list-delivery-comp-item">-->
<!--        <div class="list-delivery-comp-item__content">-->
<!--            <a href="https://www.cdek.ru/" target="_blank">-->
<!--                <img src="/web/upload/images/ratek.png" alt="Транспортная компания Деловые линии"-->
<!--                     title="Транспортная компания Деловые линии">-->
<!--            </a>-->
<!--        </div>-->
<!--    </li>-->
<!--    <li class="list-delivery-comp-item">-->
<!--        <div class="list-delivery-comp-item__content">-->
<!--            <a href="https://new.pecom.ru/" target="_blank">-->
<!--                <img src="/web/upload/images/pek.jpg">-->
<!--            </a>-->
<!--        </div>-->
<!--    </li>-->
<!--</ul>-->
<!--<div class="clearfix"></div>-->
<!--<h2>Доставка по городу</h2>-->
<!--<p>-->
<!--    Так же в нашем магазине есть бесплатная доставка в черте города Барнаул и Новоалтайска. Доставка в этом-->
<!--    периметре не зависит от суммы заказа. При доставки в более удаленные сумма заказа может увеличится-->
<!--</p>-->
<!--<h2>Сроки доставки</h2>-->
<!--<p>-->
<!--    Доставка вашего заказа может занимать до 3-х дней в зависимости от выбранного варианта доставки. Если вы выбрали-->
<!--    доставку по городу, то заказ будет доставлен в течении дня после его готовности. Если вы выбираете услуги-->
<!--    транспортных компаний или Почты России, то срок доставки можно узнать у них на сайте</p>-->
