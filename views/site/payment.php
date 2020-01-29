<?php

use app\models\tool\seo\Title;
use app\models\tool\System;

?>
<?php $this->title = Title::showTitle("Оплата");
$this->params['breadcrumbs'][] = ['label' => 'Оплата', 'url' => ['/payment/']]; ?>
<h1>Информация об оплате</h1>
<h2>Оплата картой</h2>
<p align="justify">
    Оплата картой может производится переводом денег по мобильному банку либо на расчётный счёт, реквезиты для оплаты предоставляюся только курьерами при выдаче товара
</p>
<h2>Оплата наличными</h2>
<p align="justify">
    Расчёт наличными при получении заказа курьеру
</p>
