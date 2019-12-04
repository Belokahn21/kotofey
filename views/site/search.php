<?php

use yii\helpers\StringHelper;
use yii\widgets\ActiveForm;
use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use app\models\entity\Category;
use app\models\tool\seo\Title;
use app\models\entity\Favorite;
use app\models\tool\Price;
use app\models\tool\Currency;

$this->title = Title::showTitle("Поиск по сайту");
$this->params['breadcrumbs'][] = ['label' => 'Поиск по сайту', 'url' => ['/search/']]; ?>
<? if ($products): ?>
    <div class="catalog filtred">
        <ul class="catalog-list">
<?php /* @var $product \app\models\entity\Product */ ?>
<?php foreach ($products as $product): ?>
                <li class="catalog-list__item">
                    <a href="<?php echo $product->getDetail(); ?>">
                        <div class="catalog-list__item-image-wrap">
                            <img class="catalog-list__item-image" src="/web/upload/<?php echo $product->image; ?>" title="<?php echo $product->detail; ?>" alt="<?php echo $product->detail; ?>">
                        </div>
                        <h2 class="catalog-list__item-title" title="<?= $product->name; ?>"><?php echo StringHelper::truncate($product->name,70,'...'); ?></h2>
                        <div class="catalog-list__item-category"><?php echo Category::findOne($product->category)->name; ?></div>
                        <div class="catalog-list__item-price"><?php echo Price::format($product->price); ?><?php echo Currency::getInstance()->show(); ?></div>
                    </a>
                </li>
<?php endforeach; ?>
        </ul>

        <div class="clearfix"></div>
    </div>
    <div class="clearfix"></div>
<? else: ?>
    К сожаление ничего не нашлось :(
<? endif; ?>