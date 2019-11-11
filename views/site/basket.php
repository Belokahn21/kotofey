<?
/* @var $this yii\web\View */
/* @var $products \app\models\entity\Product */

/* @var $currency Currency */

use app\models\tool\seo\Title;
use app\models\tool\Price;
use app\models\tool\Currency;
use yii\helpers\Html;
use app\models\entity\Basket;
use yii\helpers\StringHelper;

$this->title = Title::showTitle("Корзина товаров");
$this->params['breadcrumbs'][] = ['label' => 'Корзина товаров', 'url' => ['/basket/']];
?>
<section class="basket">
    <h1>Корзина товаров</h1>
    <? if (Basket::count() > 0): ?>
        <?= Html::a('Очистить корзину', "/clear/", ['class' => 'btn-cancel']); ?>
        <?= Html::a('Оформить заказ', "/checkout/", ['class' => 'btn-main']); ?>
    <? endif; ?>
    <? if (!empty(Yii::$app->session->get('basket'))): ?>
        <ul class="basket-page-list">
            <?php /* @var $item \app\models\entity\BasketItem */ ?>
            <? foreach (Basket::findAll() as $item): ?>
                <li class="basket-page-item">
                    <div class="basket-page-item__image-wrap">
                        <a href="<?= $item->getProduct()->detail; ?>">
                            <?php if (!empty($item->getProduct()->image) and is_file(Yii::getAlias('@webroot/upload/') . $item->getProduct()->image)): ?>
                                <img src="/web/upload/<?= $item->getProduct()->image; ?>">
                            <?php else: ?>
                                <img src="/web/upload/images/not-image.png">
                            <?php endif; ?>
                        </a>
                    </div>
                    <div class="basket-page-item__title">
                        <a href="<?= $item->getProduct()->detail; ?>"><?= $item->getProduct()->name; ?></a>
                    </div>
                    <div class="basket-page-item__calculate">
                        <div class="basket-page-item__price">
                            <?= Price::format($item->getProduct()->price); ?> <?= Currency::getInstance()->show(); ?>
                        </div>
                        <form class="basket-page-item__form">
                            <span><i class="fas fa-minus"></i></span>
                            <input class="basket-page-item__form-input" type="text" name="count" placeholder="1" value="<?= $item->getCount(); ?>">
                            <span><i class="fas fa-plus"></i></span>
                        </form>
                    </div>
                </li>
            <? endforeach; ?>
        </ul>
    <? else: ?>
        Ничего не выбрано
    <? endif; ?>
</section>
