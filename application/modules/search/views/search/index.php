<?php

use app\modules\promotion\widgets\CurrentPromotions\CurrentPromotionsWidget;
use app\modules\catalog\widgets\VisitedProducts\VisitedProductsWidget;
use app\modules\search\widges\FastButtonSearch\FastButtonSearchWidget;
use app\modules\catalog\widgets\CatalogFilter\CatalogFilterWidget;
use app\modules\search\widges\SearchMessage\SearchMessageWidget;
use app\modules\catalog\widgets\Sort\ProductSortWidget;
use app\modules\seo\models\tools\Title;
use yii\helpers\ArrayHelper;
use app\widgets\Breadcrumbs;
use yii\widgets\LinkPager;

/* @var $products \app\modules\catalog\models\entity\Product[]
 * @var $model \app\modules\search\models\entity\Search
 */

$this->title = Title::show("Поиск по сайту");
$this->params['breadcrumbs'][] = ['label' => 'Поиск по сайту', 'url' => ['/search/']]; ?>
<div class="page">
    <?= Breadcrumbs::widget([
        'homeLink' => [
            'label' => 'Главная ',
            'url' => Yii::$app->homeUrl,
            'title' => 'Первая страница сайта зоомагазина Котофей',
        ],
        'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
    ]); ?>
    <h1 class="page__title">Результат поиска:</h1>
    <?= SearchMessageWidget::widget(['q' => $model->search]); ?>
    <div class="catalog-container">
        <aside class="left-siderbar">
            <?php if ($products): ?>
                <?= CatalogFilterWidget::widget([
                    'product_id' => ArrayHelper::getColumn($duplicateQueryProducts->all(), 'id'),
                ]); ?>
            <?php endif; ?>
        </aside>
        <div class="catalog-wrap">
            <?php if ($products): ?>
                <?= ProductSortWidget::widget(); ?>
                <ul class="catalog">
                    <?php foreach ($products as $product): ?>
                        <?php if ($display == 'block'): ?>
                            <?= $this->render('@app/modules/catalog/views/__item-block', [
                                'product' => $product
                            ]); ?>
                        <?php elseif ($display == 'list'): ?>
                            <?= $this->render('@app/modules/catalog/views/__item-list', [
                                'product' => $product
                            ]); ?>
                        <?php endif; ?>
                    <?php endforeach; ?>
                </ul>

                <div class="pagination-wrap">
                    <?= LinkPager::widget([
                        'pagination' => $pagerItems,
                    ]); ?>
                </div>
            <?php else: ?>
                <p style="text-align: center; margin: 20px 0; padding: 0 10px;">
                    К сожаление ничего не нашлось :(
                </p>
            <?php endif; ?>
        </div>
    </div>
    <?= CurrentPromotionsWidget::widget(); ?>
    <?= FastButtonSearchWidget::widget(); ?>
    <?= VisitedProductsWidget::widget(); ?>
</div>
