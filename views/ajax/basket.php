<?php

use app\models\entity\Basket;

?>
<?= Yii::$app->i18n->format("{n, plural, =0{Корзина пуста} =1{В крзине # товар} one{В крзине # товар} few{В корзине # товаров} many{В корзине # товаров} other{Корзина пуста}}", ['n' => Basket::count()], 'ru_RU'); ?>


