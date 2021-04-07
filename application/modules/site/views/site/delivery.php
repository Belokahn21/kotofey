<?php

use app\modules\site_settings\models\entity\SiteSettings;
use app\modules\seo\models\tools\Title;
use app\widgets\Breadcrumbs;

?>
<?php $this->title = Title::show("Доставка заказов");
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
            <div class="page__text">После оформления заказа, с вами свяжется менеджер для подтверждения заявки и уточнит сроки доставки (Обычно 1 час).</div>
            <div class="page__text">В другой город? Воспользуйтесь нашим калькулятором доставки. Введите адрес получения и выберите примерный груз для отправки.</div>
            <div class="page__text">При доставке в удалённые точки города или за город сумма доставки может быть выше обычной. Уточнить сумму доставки можно у опретаторов при подтверждении заказа.</div>
            <h2 class="page__sub-title">Способы оплаты</h2>
            <div class="page__text">

                <u>Наличный расчёт</u><br/>
                Если товар доставляется курьером, то оплата осуществляется наличными курьеру в руки. При получении товара обязательно проверьте комплектацию товара, наличие гарантийного талона и чека.<br/><br/>

                <u>Банковской картой</u><br/><br/>
                Для выбора оплаты товара с помощью банковской карты на соответствующей странице необходимо нажать кнопку Оплата заказа банковской картой. Оплата происходит через ПАО СБЕРБАНК с использованием банковских карт следующих платёжных систем:<br/><br/>
                <div class="payment-cards">
                    <div class="payment-cards__item"><img class="payment-cards__image" src="/images/payments/visa.jpg"></div>
                    <div class="payment-cards__item"><img class="payment-cards__image" src="/images/payments/mastercard.png"></div>
                    <div class="payment-cards__item"><img class="payment-cards__image" src="/images/payments/mir.jpg"></div>
                    <div class="payment-cards__item"><img class="payment-cards__image" src="/images/payments/jcb.png"></div>
                </div>
                <?php /*
                МИР (разместить логотип МИР);<br/>
                VISA International (разместить логотип VISA International);<br/>
                Mastercard Worldwide (разместить логотип Mastercard Worldwide);<br/>
                JCB (разместить логотип JCB).<br/><br/>
 */ ?>
                Для оплаты (ввода реквизитов Вашей карты) Вы будете перенаправлены на платёжный шлюз ПАО СБЕРБАНК. Соединение с платёжным шлюзом и передача информации осуществляется в защищённом режиме с использованием протокола шифрования SSL. В случае если Ваш банк поддерживает технологию безопасного проведения интернет-платежей Verified By Visa, MasterCard SecureCode, MIR Accept, J-Secure, для проведения платежа также может потребоваться ввод специального пароля.<br/><br/>
                Настоящий сайт поддерживает 256-битное шифрование. Конфиденциальность сообщаемой персональной информации обеспечивается ПАО СБЕРБАНК. Введённая информация не будет предоставлена третьим лицам за исключением случаев, предусмотренных законодательством РФ. Проведение платежей по банковским картам осуществляется в строгом соответствии с требованиями платёжных систем МИР, Visa Int., MasterCard Europe Sprl, JCB.

                <u>Возврат товара</u><br/><br/>
                Срок возврата товара надлежащего качества составляет 14 дней с момента получения товара.<br/>
                Надлежащим качеством является - товар, у которого сохранены пломбы<br/>
                Возврат переведённых средств, производится на ваш банковский счёт в течение 5-30 рабочих дней (срок зависит от банка, который выдал вашу банковскую карту).
            </div>
            <h2 class="page__sub-title">Доставка зоотоваров</h2>
            <div class="page__text">Доставка зоотоваров по городу Барнаул осуществляется в будние дни с понедельника по пятницу в утреннее время с 9.00 до 11.00 и в вечернее время с 19.00 до 23.00</div>
            <div class="page__text">Отправляем заказы по всей России различными транспортными компаниями и Почтой России. На текущий момент мы сотрудничаем с ТК СДЭК, DPD</div>
            <div class="page__text">Время и сумма доставки для каждого заказа индивидуальна поэтому перед покупкой воспользуйтесь калькулятором расчёта предоставленный на сайтах транспортных компаний либо обратитесь к нам за консультацией по телефону <a href="tel:<?= SiteSettings::getValueByCode('phone_1'); ?>" class="js-phone-mask"><?= SiteSettings::getValueByCode('phone_1'); ?></a>. Мы с радостью проконсультируем по срокам и стомости доставки.</div>
        </div>
    </div>
</div>

