<?

/* @var $this yii\web\View */
/* @var $products \app\models\entity\Product */
/* @var $category \app\models\entity\Category */


/* @var (new Currency) Currency */

use app\models\tool\Currency;
use app\models\tool\Price;
use app\models\tool\seo\Title;
use app\models\entity\Category;

$this->title = Title::showTitle("Товары");
$this->params['breadcrumbs'][] = ['label' => 'Товары', 'url' => ['/catalog/']];
if ($category) {
    $this->params['breadcrumbs'][] = ['label' => $category->name, 'url' => ['/catalog/' . $category->slug . "/"]];
    $this->title = Title::showTitle($category->name);
}
?>
<div class="catalog filtred">
    <ul class="catalog-list">
        <? /* @var $product \app\models\entity\Product */ ?>
        <? foreach ($products as $product): ?>
            <li class="catalog-list__item">
                <a href="<?= $product->getDetail(); ?>">
                    <div class="catalog-list__item-image-wrap">
                        <img class="catalog-list__item-image" src="<?= $product->image; ?>" title="<?= $product->detail; ?>"
                             alt="<?= $product->detail; ?>">
                    </div>
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

<?= \yii\widgets\LinkPager::widget([
    'pagination' => $pagerItems,
]); ?>

