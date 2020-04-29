<?php

use app\models\tool\seo\Title;

$this->title = Title::showTitle("Помощь по сайту");
$this->params['breadcrumbs'][] = ['label' => 'Помощь по сайту', 'url' => ['/faq/']]; ?>
<section class="faq">
    <h1>Ответы на вопросы</h1>
    <ul class="list-faq">
        <li class="list-faq-item">
            <a name="new-comment">
                <div class="list-faq-item__quest">
                    <strong>Вопрос:</strong> Почему я не могу оставить комментарий к товару?<br/>
                </div>
                <div class="list-faq-item__answer">
                    <strong>Ответ:</strong> Мы ввели в тестирование данное ограничение. Чтобы клиент мог оставлять
                    комментарий он должен быть
                    зарегестрирован на нашем сайте и иметь оплаченный заказ с купленным товаром. Только тогда клиент
                    сможет
                    оставить комментарий и получить за него баллы к своей скидке товаров.
                </div>
            </a>
        </li>
        <li class="list-faq-item">
            <a name="order-not-buy">
                <div class="list-faq-item__quest">
                    <strong>Вопрос:</strong> Что значит "Купить без оплаты" ?<br/>
                </div>
                <div class="list-faq-item__answer">
                    <strong>Ответ:</strong> Оформляется заказ, но без оплаты после чего с вами связывается менеджер. Этот метод особо
                    не отличается от обычной покупки. Мы считаем это повысит доверие к нашему клиенту потому что не все
                    готовы вносить деньги
                </div>
            </a>
        </li>
    </ul>
</section>
