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

/* @var \yii\web\View $this */
/* @var \app\models\entity\Product $product */
/* @var \app\models\entity\Category $category */

$this->params['breadcrumbs'][] = ['label' => "Каталог", 'url' => ['/catalog/']];
if($category){
    $this->params['breadcrumbs'][] = ['label' => $category->name, 'url' => ['/catalog/'.$category->slug."/"]];
}
$this->params['breadcrumbs'][] = ['label' => $product->name, 'url' => [$product->detail]];

$this->title = Title::showTitle($product->name);
?>

<div class="detail-product" itemtype="http://schema.org/Product" itemscope>
    <div class="detail-product-wrap">
        <div class="detail-product-galery">
            <a href="/web/upload/<?=$product->image;?>" class="image-link">
                <img src="/web/upload/<?= $product->image ?>" alt="<?=$product->name;?>" title="<?=$product->name;?>" class="detail-product__image">
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

    <? }catch(ErrorException $exception){?>

    <?} ?>


</div>
<div class="clearfix"></div>
