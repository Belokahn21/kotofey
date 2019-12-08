<div class="checkout__title">Информация о покупателе</div>
<ul class="checkout-user-reqs">
    <li class="user-reqs__item">
        <div class="user-reqs__item__key">Телефон</div>
        <div class="user-reqs__item__value phone_mask"><?= \Yii::$app->user->identity->phone; ?></div>
    </li>
    <li class="user-reqs__item">
        <div class="user-reqs__item__key">Email</div>
        <div class="user-reqs__item__value"><?= \Yii::$app->user->identity->email; ?></div>
    </li>
</ul>