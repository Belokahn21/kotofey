<?

use app\models\tool\seo\Title;
use app\models\tool\Currency;
use app\models\tool\Price;
use app\models\entity\Product;
use app\models\entity\Order;
use app\widgets\todo\ToDoWidget;

/* @var $this yii\web\View */
/* @var $all integer */
/* @var $price integer */
/* @var $purchase integer */
/* @var $order Order */

$this->title = Title::showTitle("Главная страница");
?>
<section class="desktop">
    <h1 class="title">Рабочий стол</h1>
    <div class="desktop-items">
        <div class="desktop-item">
            <div class="desktop-item__logo money-logo">
                <i class="fas fa-dollar-sign"></i>
            </div>
            <div class="desktop-item__content">
                <h2 class="desktop-item__title">Доход</h2>
                <div class="desktop-item__money"><?= Price::format(rand()); ?> <?= (new Currency())->show(); ?></div>
            </div>
            <div class="desktop-item__resume">+ <?= Price::format(rand(1000,
                    10000)) ?> <?= (new Currency())->show(); ?></div>
        </div>
        <div class="desktop-item">
            <div class="desktop-item__logo order-logo">
                <i class="fas fa-shopping-cart"></i>
            </div>
            <div class="desktop-item__content">
                <h2 class="desktop-item__title">Заказов</h2>
                <div class="desktop-item__money"><?= $order->count(); ?></div>
            </div>
            <div class="desktop-item__resume">+ <?= Order::orderProfit(); ?></div>
        </div>
        <div class="desktop-item">
            <div class="desktop-item__logo product-logo">
                <i class="fas fa-cash-register"></i>
            </div>
            <div class="desktop-item__content">
                <h2 class="desktop-item__title">Товаров</h2>
                <div class="desktop-item__money"><?= $product->count(); ?></div>
            </div>
            <div class="desktop-item__resume"><?= Price::format(Product::countRent()) ?> / +<?= Price::format(Product::countProfit()) ?></div>
        </div>
        <div class="desktop-item">
            <div class="desktop-item__logo core-logo">
                <i class="fas fa-cogs"></i>
            </div>
            <div class="desktop-item__content">
            </div>
        </div>
    </div>
    <?php echo ToDoWidget::widget(); ?>
</section>