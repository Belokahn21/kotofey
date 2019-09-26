<?

/* @var $this yii\web\View */
/* @var $products \app\models\entity\Product */
/* @var $filterModel CatalogFilter */

/* @var $category \app\models\entity\Category */

use app\models\entity\InformersValues;
use app\models\tool\Currency;
use app\models\tool\Price;
use app\models\tool\seo\Title;
use app\widgets\catalog_filter\CatalogFilterWidget;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\models\entity\Category;
use app\models\forms\CatalogFilter;
use yii\helpers\ArrayHelper;
use yii\widgets\Pjax;
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
                        <img class="catalog-list__item-image" src="<?php echo $product->image; ?>" title="<?php echo $product->detail; ?>" alt="<?php echo $product->detail; ?>">
                    </div>
                    <h2 class="catalog-list__item-title"><?php echo $product->name; ?></h2>
                    <div class="catalog-list__item-category"><?php echo Category::findOne($product->category)->name; ?></div>
                    <div class="catalog-list__item-price"><?php echo Price::format($product->price); ?> <?php echo (new Currency())->show(); ?></div>
                </a>
            </li>
        <?php endforeach; ?>
    </ul>
</div>


<?php echo LinkPager::widget([
    'pagination' => $pagerItems,
]); ?>

