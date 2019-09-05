<?

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
            <? /* @var $product \app\models\entity\Product */ ?>
            <? foreach ($products as $product): ?>
                <li class="catalog-list__item">
                    <a href="<?= $product->getDetail(); ?>">
                        <img src="<?= $product->image; ?>">
                        <h2 class="catalog-list__item-title"><?= $product->name; ?></h2>
                        <div class="catalog-list__item-category"><?= Category::findOne($product->category)->name; ?></div>
                        <div class="catalog-list__item-price"><?= Price::format($product->price); ?> <?= (new Currency())->show(); ?></div>
                    </a>
                </li>
            <? endforeach; ?>
        </ul>

        <div class="clearfix"></div>
    </div>
    <div class="clearfix"></div>
<? else: ?>
    К сожаление ничего не нашлось :(
<? endif; ?>