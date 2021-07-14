<?php

/* @var $this yii\web\View
 * @var $order Order
 * @var $basket \app\modules\order\models\entity\OrdersItems[]
 * @var $billing \app\modules\user\models\entity\UserBilling
 * @var $user \app\modules\user\models\entity\User
 * @var $deliveries app\modules\delivery\models\entity\Delivery[]
 * @var $payments \app\modules\payment\models\entity\Payment[]
 * @var $order_date \app\modules\order\models\entity\OrderDate
 * @var $delivery_time \app\modules\order\models\service\DeliveryTimeService
 * @var $billing_list \app\modules\user\models\entity\UserBilling[]
 */

use yii\helpers\Url;
use yii\helpers\Html;
use app\modules\site\models\tools\Price;
use yii\helpers\ArrayHelper;
use yii\bootstrap\ActiveForm;
use app\modules\site\models\tools\Currency;
use app\widgets\Breadcrumbs;
use app\modules\seo\models\tools\Title;
use app\modules\order\models\entity\Order;
use app\modules\basket\models\entity\Basket;
use app\modules\payment\models\entity\Payment;
use app\modules\delivery\models\entity\Delivery;
use app\modules\catalog\models\helpers\OfferHelper;
use app\modules\site_settings\models\entity\SiteSettings;
use app\modules\basket\widgets\addBasket\AddBasketWidget;
use app\modules\bonus\widgets\BonusFiled\BonusFieldWidget;
use app\modules\promocode\widgets\promocode_field\PromocodeFieldWidget;
use app\modules\bonus\models\helper\BonusHelper;

$this->title = Title::show("Оформление заказа");
$this->params['breadcrumbs'][] = ['label' => 'Корзина', 'url' => ['/basket/']];
$this->params['breadcrumbs'][] = ['label' => 'Оформление заказа', 'url' => ['/order/']];
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
    <h1 class="page__title">Оформление заказа</h1>
    <?php /*
    <div class="checkout-form-attention">Уважаемые покупатели, Оформление заказа временно работает в тестовом режиме поэтому просим вас при возникновении проблем с заказом обращаться по телефону <a href="tel:<?= SiteSettings::getValueByCode('phone_1'); ?>" class="js-phone-mask"><?= SiteSettings::getValueByCode('phone_1'); ?></a>. Мы поможем вам с покупокй и сделаем сервис лучше!</div>
 */ ?>
    <div class="page__group-row checkout-react" data-user="<?= Yii::$app->user->id; ?>"></div>
</div>