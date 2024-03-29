<?php

use yii\helpers\Url;
use app\modules\site\models\tools\PriceTool;
use app\modules\basket\models\entity\Basket;
use app\modules\site\models\tools\Currency;

?>
<div class="fast-cart<?= Basket::getInstance()->isEmpty() ? '' : ' active' ?>">
    <div class="fast-cart__total">
        <div class="fast-cart__count">
            <?= \Yii::t('app', '{n, plural, =0{позиций} =1{позиций} one{# позиций} few{# позиций} many{# позиций} other{# позиции}}', ['n' => Basket::count()]); ?>
        </div>
        <div class="fast-cart__summary"><?= PriceTool::format(Basket::getInstance()->cash()) ?> <?= Currency::getInstance()->show(); ?></div>
    </div>
    <a class="fast-cart__buy" href="<?= Url::to(['/checkout/']) ?>">Оплатить</a>
    <a class="fast-cart__icon" href="<?= Url::to(['/clear/']) ?>"><i class="fas fa-trash-alt"></i></a>
</div>