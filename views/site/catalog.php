<?

/* @var $this yii\web\View */
/* @var $products \app\models\entity\Product */
/* @var $filterModel CatalogFilter */

/* @var $category \app\models\entity\Category */

use yii\helpers\StringHelper;
use app\models\tool\Currency;
use app\models\tool\Price;
use app\models\tool\seo\Title;
use app\widgets\catalog_filter\CatalogFilterWidget;
use app\models\entity\Category;
use app\models\forms\CatalogFilter;
use yii\widgets\LinkPager;

$this->title = Title::showTitle("Товары");
$this->params['breadcrumbs'][] = ['label' => 'Товары', 'url' => ['/catalog/']];
if ($category) {
	$this->params['breadcrumbs'][] = ['label' => $category->name, 'url' => ['/catalog/' . $category->slug . "/"]];
	$this->title = Title::showTitle($category->name);
}
?>
<div class="catalog filtred">

	<?php echo CatalogFilterWidget::widget(); ?>

    <ul class="catalog-list">
		<?php /* @var $product \app\models\entity\Product */ ?>
		<?php foreach ($products as $product): ?>
            <li class="catalog-list__item">
                <a href="<?php echo $product->getDetail(); ?>">
                    <div class="catalog-list__item-image-wrap">
                        <?php if (!empty($product->image) and is_file(Yii::getAlias('@webroot/upload/') . $product->image)): ?>
                            <img class="catalog-list__item-image" src="/web/upload/<?= $product->image; ?>" title="<?= $product->detail; ?>" alt="<?= $product->detail; ?>">
                        <?php else: ?>
                            <img class="catalog-list__item-image" src="/web/upload/images/not-image.png" title="<?= $product->detail; ?>" alt="<?= $product->detail; ?>">
                        <?php endif; ?>
                    </div>
                    <h2 class="catalog-list__item-title" title="<?= $product->name; ?>"><?= StringHelper::truncate($product->name, 70, '...'); ?></h2>
                    <div class="catalog-list__item-category"><?= Category::findOne($product->category)->name; ?></div>
                    <div class="catalog-list__item-price"><?= Price::format($product->price); ?><?= Currency::getInstance()->show(); ?></div>
                </a>
            </li>
        <?php endforeach; ?>
    </ul>
</div>
<div class="pagination-wrap">
	<?php echo LinkPager::widget([
		'pagination' => $pagerItems,
	]); ?>
</div>

