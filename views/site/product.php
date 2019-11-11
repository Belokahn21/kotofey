<?

use app\models\tool\Price;
use app\models\tool\seo\Title;
use yii\helpers\Json;
use app\models\tool\Currency;
use app\models\entity\Favorite;
use app\models\entity\ProductPropertiesValues;
use app\models\entity\ProductProperties;
use app\models\entity\InformersValues;
use app\widgets\fast_buy\FastBuyWidget;

/* @var $properties ProductPropertiesValues[] */
/* @var \yii\web\View $this */
/* @var \app\models\entity\Product $product */
/* @var \app\models\entity\Category $category */

$this->params['breadcrumbs'][] = ['label' => "Каталог", 'url' => ['/catalog/']];
if ($category) {
    $this->params['breadcrumbs'][] = ['label' => $category->name, 'url' => ['/catalog/' . $category->slug . "/"]];
}
$this->params['breadcrumbs'][] = ['label' => $product->name, 'url' => [$product->detail]];

$this->title = Title::showTitle($product->name);

echo $this->render('modal/product-modal-bonus');
echo $this->render('modal/product-modal-buy-click');
echo $this->render('modal/product-modal-delivery');
echo $this->render('modal/product-modal-payment');
?>
<div class="product-detail-wrap">
    <div class="container">
        <div class="row">
            <div class="col-4">
                <div class="product-detail-image-wrap">
                    <?php if (!empty($product->image) and is_file(Yii::getAlias('@webroot/upload/') . $product->image)): ?>
                        <img class="product-detail-image" src="/web/upload/<?= $product->image; ?>" alt="<?= $product->name; ?>" title="<?= $product->name; ?>">
                    <?php else: ?>
                        <img class="product-detail-image" src="/web/upload/images/not-image.png" alt="<?= $product->name; ?>" title="<?= $product->name; ?>">
                    <?php endif; ?>
                </div>
            </div>
            <div class="col-6">
                <div class="product-title"><?= $product->name; ?></div>
                <div class="product-control">
                    <?php if ($product->vitrine == 1 or $product->count > 0): ?>
                        <div class="product-available green">В наличии</div>
                    <?php endif; ?>
                    <div class="product-rating">
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="far fa-star"></i>
                        <i class="far fa-star"></i>
                    </div>
                    <div class="product-favorite"><i class="far fa-heart"></i>В избранное</div>
                    <!--                            <div class="product-share" data-toggle="tooltip" data-placement="bottom" title="Tooltip on bottom"><i class="fas fa-share-alt"></i>Поделиться</div>-->
                </div>
                <div class="product-description">
                    <?php if ($product->description): ?>
                        <?= $product->description; ?>
                    <?php endif; ?>
                </div>
            </div>
            <div class="col-2">
                <div class="product-detail-sidebar">
                    <div class="product-price-wrap">
                        <span class="product-price"><?= Price::format($product->price); ?> <?= Currency::getInstance()->show(); ?></span> за шт
                    </div>
                    <!--                    <div class="product-button product-add-basket" data-product="1">-->
                    <div class="product-button product-add-basket add-basket" data-id="<?= $product->id; ?>">
                        В корзину
                    </div>


                    <div class="product-detail-calc-wrap hide">
                        <form class="product-detail-calc-form">

                            <div class="product-detail-calc-element">
                                <div class="product-detail-calc-min">-</div>
                            </div>

                            <div class="product-detail-calc-element">
                                <input type="text" class="product-detail-calc-count" name="count" placeholder="1">
                            </div>

                            <div class="product-detail-calc-element">
                                <div class="product-detail-calc-plus">+</div>
                            </div>
                        </form>
                    </div>
                    <?= FastBuyWidget::widget([
                        'product' => $product
                    ]); ?>
                    <hr/>
                    <ul class="product-pluses">
                        <li class="product-pluses__item" data-toggle="modal" data-target="#modal-product-detail-delivery">
                            <div class="product-pluses__icon">
                                <i class="fas fa-truck"></i>
                            </div>
                            <div class="product-pluses__title">Бесплатная доставка</div>
                        </li>

                        <li class="product-pluses__item" data-toggle="modal" data-target="#modal-product-detail-sale">
                            <div class="product-pluses__icon">
                                <i class="fas fa-piggy-bank"></i>
                            </div>
                            <div class="product-pluses__title">Скидки на покупки</div>
                        </li>

                        <li class="product-pluses__item" data-toggle="modal" data-target="#modal-product-detail-payment">
                            <div class="product-pluses__icon"><i class="far fa-credit-card"></i>
                            </div>
                            <div class="product-pluses__title">Оплата при получении</div>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <div class="product-attributes-wrap">
        <div class="container">
            <div class="product-attributes__title">Характеристики товара</div>
            <?php if ($properties): ?>
                <?php foreach ($properties as $property): ?>
                    <div class="row product-attributes__item">
                        <div class="col-4 product-attributes__key"><?= $property->property->name; ?></div>
                        <div class="col product-attributes__value"><?= $property->finalValue; ?></div>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>

        </div>
        <div class="container">
            <!--            <div class="product-attributes__title">Отзывы покупателей</div>-->
            <!--            <div class="product-review-wrap">-->
            <!--                <ul class="review-list">-->
            <!--                    <li class="review-item">-->
            <!--                        <div class="review-item__author-wrap">-->
            <!--                            <div class="review-item__image-wrap">-->
            <!--                                <img class="review-item__image" src="./assets/images/product.png">-->
            <!--                            </div>-->
            <!--                            <div>-->
            <!--                                <div class="review-item__author">Алексей Несмышлёный</div>-->
            <!--                                <div class="review-item__verify">Товар был куплен</div>-->
            <!--                            </div>-->
            <!--                        </div>-->
            <!--                        <div class="review-item__description">-->
            <!--                            Мой котик очень полюбил этот пауч. Неуспеваю открыть пачку, как котик сразу сносит меня сног игриво виляя хвостом словно Карлсон пропеллером-->
            <!--                        </div>-->
            <!--                    </li>-->
            <!--                    <li class="review-item">-->
            <!--                        <div class="review-item__author-wrap">-->
            <!--                            <div class="review-item__image-wrap">-->
            <!--                                <img class="review-item__image" src="./assets/images/product.png">-->
            <!--                            </div>-->
            <!--                            <div class="review-item__author">Алексей Несмышлёный</div>-->
            <!--                        </div>-->
            <!--                        <div class="review-item__description">-->
            <!--                            Мой котик очень полюбил этот пауч. Неуспеваю открыть пачку, как котик сразу сносит меня сног игриво виляя хвостом словно Карлсон пропеллером-->
            <!--                        </div>-->
            <!--                    </li>-->
            <!--                    <li class="review-item">-->
            <!--                        <div class="review-item__author-wrap">-->
            <!--                            <div class="review-item__image-wrap">-->
            <!--                                <img class="review-item__image" src="./assets/images/product.png">-->
            <!--                            </div>-->
            <!--                            <div class="review-item__author">Алексей Несмышлёный</div>-->
            <!--                        </div>-->
            <!--                        <div class="review-item__description">-->
            <!--                            Мой котик очень полюбил этот пауч. Неуспеваю открыть пачку, как котик сразу сносит меня сног игриво виляя хвостом словно Карлсон пропеллером-->
            <!--                        </div>-->
            <!--                    </li>-->
            <!--                    <li class="review-item">-->
            <!--                        <div class="review-item__author-wrap">-->
            <!--                            <div class="review-item__image-wrap">-->
            <!--                                <img class="review-item__image" src="./assets/images/product.png">-->
            <!--                            </div>-->
            <!--                            <div class="review-item__author">Алексей Несмышлёный</div>-->
            <!--                        </div>-->
            <!--                        <div class="review-item__description">-->
            <!--                            Мой котик очень полюбил этот пауч. Неуспеваю открыть пачку, как котик сразу сносит меня сног игриво виляя хвостом словно Карлсон пропеллером-->
            <!--                        </div>-->
            <!--                    </li>-->
            <!--                </ul>-->
            <!--                <div class="review-form-wrap">-->
            <!--                    <form class="review-form">-->
            <!--                        <div class="review-form__element">-->
            <!--                            <input type="text" name="name" placeholder="Автор">-->
            <!--                        </div>-->
            <!--                        <div class="review-form__element">-->
            <!--                            <textarea placeholder="Ваш отзыв"></textarea>-->
            <!--                        </div>-->
            <!--                        <div class="review-form__element">-->
            <!--                            <button class="btn-main">Отправить</button>-->
            <!--                        </div>-->
            <!--                    </form>-->
            <!--                </div>-->
            <!--            </div>-->
        </div>
    </div>
</div>
