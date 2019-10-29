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


/* @var \app\models\entity\Product $product */
/* @var \app\models\entity\Category $category */

$this->params['breadcrumbs'][] = ['label' => "Каталог", 'url' => ['/catalog/']];
if($category){
    $this->params['breadcrumbs'][] = ['label' => $category->name, 'url' => ['/catalog/'.$category->slug."/"]];
}
$this->params['breadcrumbs'][] = ['label' => $product->name, 'url' => [$product->detail]];

$this->title = Title::showTitle($product->name); ?>

<div class="detail-product" itemtype="http://schema.org/Product" itemscope>
    <div class="detail-product-wrap">
        <div class="detail-product-galery">
            <a href="<?=$product->image;?>" class="image-link">
                <img src="<?= $product->image ?>" alt="<?=$product->name;?>" title="<?=$product->name;?>" class="detail-product__image">
            </a>
        </div>
        <div class="detail-product-info">

            <div class="detail-product__title-wrap">

                <h1 class="detail-product__title"><?= $product->name ?></h1>
            </div>

            <div class="detail-product__category"><a href="<?= $category->detail; ?>"><?= $category->name; ?></a></div>
            <div class="block-buy-wrap">
                <div class="detail-product__price">
                    <?= Price::format($product->price) ?> <?= Currency::getInstance()->show(); ?>
                    <span class="detail-product__available">
                        <?php if ($product->vitrine == 1): ?>
                            В наличии
						<?php else: ?>
							<?php if ($product->count > 0): ?>
                                В наличии <?= $product->count; ?> шт.
							<?php else: ?>
                                <span class="error">Нет в наличии</span>
							<?php endif; ?>
						<?php endif ?>
                    </span>
                </div>
                <a class="detail-product__cart add-basket" data-id="<?=$product->id;?>">
                    <i class="fas fa-shopping-cart"></i>
                </a>
                <?= FastBuyWidget::widget([
                        'product'=>$product
                ]); ?>
                <span class="item-bookmark" data-id="<?= $product->id; ?>">
                    <? if (Favorite::isProductInFavorite($product->id)): ?>
                        <i class="fas fa-bookmark"></i>
					<? else: ?>
                        <i class="far fa-bookmark"></i>
					<? endif; ?>
                </span>
            </div>
            <ul class="detail-product-properties">
                <li class="detail-product-properties__item">
                    <div>
                        <h2 class="harmon-title detail-product-properties__item__title">Описание изделия<i class="fas fa-chevron-up"></i></h2>
                        <div class="harmon-content first">
                            <p>
                                <?= $product->description ?>
                            </p>
                        </div>
                    </div>
                </li>
<!--                <li class="detail-product-properties__item">-->
<!--                    <div>-->
<!--                        <h2 class="harmon-title detail-product-properties__item__title">Нанесение инициалов<i class="fas fa-chevron-down"></i></h2>-->
<!--                        <div class="harmon-content">-->
<!--                            <p>-->
<!--                                На это изделие можно бесплатно нанести персональные инициалы владельца. Мы используем один-->
<!--                                универсальный шрифт нейтрального стиля, чтобы он вписывался в любой формат аксессуаров и одежды.-->
<!--                                Для того, чтобы согласовать нанесение инициалов, Вам необходимо оформить заказ и сообщить-->
<!--                                инициалы менеджеру магазина, который будет принимать Ваш заказ.-->
<!--                            </p>-->
<!--                        </div>-->
<!--                    </div>-->
<!--                </li>-->
                <li class="detail-product-properties__item">
                    <div>
                        <h2 class="harmon-title detail-product-properties__item__title">Свойства продукта<i class="fas fa-chevron-down"></i></h2>
                        <div class="harmon-content">
                            <ul class="list-properties">
                                <? /* @var $property ProductPropertiesValues */ ?>
                                <? foreach (ProductPropertiesValues::find()->where(['product_id' => $product->id])->andWhere(['not in','property_id',ProductProperties::find()->select('id')->where(['need_show' => 0])])->all() as $property): ?>
                                    <li class="list-properties-item">
                                        <span class="list-properties-item__key">
                                            <?= $property->property->name; ?>
                                        </span>
                                        <? if ($property->property->type == 1): ?>
                                            <span>: <?= InformersValues::find()->where(['id' => $property->value])->andWhere(['informer_id' => $property->informer->id])->one()->value; ?></span>
                                        <? else: ?>
                                            <span>: <?= $property->value; ?></span>
                                        <? endif; ?>
                                    </li>
                                <? endforeach; ?>
                            </ul>
                        </div>
                    </div>
                </li>
                <li class="detail-product-properties__item">
                    <div>
                        <h2 class="harmon-title detail-product-properties__item__title">Информация о доставке<i class="fas fa-chevron-down"></i></h2>
                        <div class="harmon-content">
                            <p>
                                <?//= \app\widgets\calc_porduct_delivery\Delivery::widget(); ?>
                            </p>
                        </div>
                    </div>
                </li>
            </ul>
        </div>
    </div>

    <div class="clearfix"></div>

    <? try{ ?>

        <? if (count(Json::decode($product->images)) > 0): ?>
            <div class="gallery-more">
                <div class="owl-carousel owl-detail">
                    <? foreach (Json::decode($product->images) as $image): ?>
                        <img src="<?= $image; ?>" alt="<?= $product->detail; ?>" title="<?= $product->detail; ?>">
                    <? endforeach; ?>
                </div>
            </div>
        <? endif; ?>

    <? }catch(\yii\base\InvalidArgumentException $exception){?>

    <?} ?>


</div>


<?

?>

<!--<section class="detail-product" itemtype="http://schema.org/Product" itemscope>-->
<!--    <div class="detail-product__gallery gallery-item">-->
<!--        <a href="--><?//= $product->image ?><!--">-->
<!--            <img src="--><?//= $product->image; ?><!--" itemprop="image" alt="--><?//= $product->name; ?><!--" title="--><?//= $product->name; ?><!--">-->
<!--        </a>-->
<!--        <div class="clearfix"></div>-->
<!--        --><?// if (!empty($product->images)): ?>
<!--            --><?// foreach (Json::decode($product->images) as $image): ?>
<!--            <a href="--><?//= $image ?><!--" >-->
<!--                <img src="--><?//= $image ?><!--" alt="--><?//= $product->name; ?><!--" title="--><?//= $product->name; ?><!--" class="detail-product__gallery-more">-->
<!--            </a>-->
<!--            --><?// endforeach; ?>
<!--        --><?// endif; ?>
<!--    </div>-->
<!--    <div class="detail-product__info">-->
<!--        <div class="detail-product__info-top-line">-->
<!--            <div class="detail-product__info-top-line__article">Артикул <span itemprop="sku">--><?//= $product->article; ?><!--</span></div>-->
<!--            --><?// if ($product->count > 0): ?>
<!--                <div class="detail-product__info-top-line__actual">В наличии</div>-->
<!--            --><?// else: ?>
<!--                <div class="detail-product__info-top-line__not_actual">Нет в наличии</div>-->
<!--            --><?// endif; ?>
<!--        </div>-->
<!--        <h1 class="detail-product__info-title" itemprop="name">--><?//= $product->name; ?><!--</h1>-->
<!--        <table class="detail-product__info-attributes">-->
<!--            <tr>-->
<!--                <td>Цена</td>-->
<!--                <td>--><?//= Price::format($product->price); ?><!-- --><?//=(new Currency())->show();?><!--</td>-->
<!--            </tr>-->
<!--            <tr>-->
<!--                <td>Количество</td>-->
<!--                <td>--><?//= $product->count; ?><!--</td>-->
<!--            </tr>-->
<!--            <tr>-->
<!--                <td>Категория</td>-->
<!--                <td itemprop="brand">-->
<!--                    --><?// if ($category): ?>
<!--                        <a class="detail-product__info-detail-url" href="--><?//= $category->detail; ?><!--">--><?//= $category->name; ?><!--</a>-->
<!--                    --><?// else: ?>
<!--                        <a href="" class="detail-product__info-detail-url">Без категории</a>-->
<!--                    --><?// endif; ?>
<!--                </td>-->
<!--            </tr>-->
<!--            --><?// /* @var $property \app\models\entity\ProductPropertiesValues */ ?>
<!--            --><?// foreach ($properties as $property): ?>
<!--                <tr>-->
<!--                    <td>-->
<!--                        --><?//= ProductProperties::findOne($property->property_id)->name; ?>
<!--                    </td>-->
<!--                    <td>--><?//= $property->value; ?><!--</td>-->
<!--                </tr>-->
<!--            --><?// endforeach; ?>
<!--            <tr>-->
<!--                <td colspan="2">-->
<!--                    --><?// if ($product->count > 0): ?>
<!--                        <a href="" class="btn-effect bubble left catalog-element__links-element add-basket" data-id="--><?//= $product->id; ?><!--">Вкорзину</a>-->
<!--                    --><?// endif; ?>
<!--                </td>-->
<!--            </tr>-->
<!--        </table>-->
<!--        <div class="detail-product__info-description">-->
<!--            <h3>Описание товара</h3>-->
<!--            <div class="detail-product__info-description__text" itemprop="description">--><?//= $product->description; ?><!--</div>-->
<!--        </div>-->
<!--    </div>-->
<!--    <div class="clearfix"></div>-->
<!--    --><?//= Related::widget(['category' => $product->category]); ?>
<!--    --><?//= ReviewsProduct::widget(['product' => $product]); ?>
<!--</section>-->

<div class="clearfix"></div>
