<?php
/* @var $this yii\web\View
 * @var $model \app\modules\catalog\models\entity\PropertiesProductValues
 * @var $display string
 * @var $products \app\modules\catalog\models\entity\Product[]
 */

use app\modules\catalog\models\helpers\ProductPropertiesValuesHelper;
use app\modules\catalog\widgets\Sort\ProductSortWidget;
use app\modules\seo\models\tools\Title;
use app\widgets\Breadcrumbs;
use yii\widgets\LinkPager;

$this->params['breadcrumbs'][] = ['label' => 'Бренды', 'url' => ['/catalog/brand/index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => [ProductPropertiesValuesHelper::getBrandDetailUrl($model)]];
$this->title = Title::show($model->name);
?>
<div class="page">
    <?= Breadcrumbs::widget([
        'homeLink' => [
            'label' => 'Главная ',
            'url' => Yii::$app->homeUrl,
            'title' => 'Первая страница сайта зоомагазина Котофей',
        ],
        'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
    ]); ?>
    <h1 class="brand-page-title"><?= $model->name; ?></h1>
    <div class="brand-page-description">
        С 1968 года компания ROYAL CANIN® работает над тем, чтобы сделать питание одним из методов поддержания здоровья кошек и собак. Это наш способ сделать мир для домашних животных лучше.
    </div>
    <div class="catalog-container">
        <div class="catalog-wrap">
            <?= ProductSortWidget::widget(); ?>
            <?php if ($products): ?>

                <?php if ($display == 'block'): ?>
                    <?= $this->render('@app/modules/catalog/views/catalog/type-display/block', [
                        'products' => $products
                    ]); ?>
                <?php else: ?>
                    <?= $this->render('@app/modules/catalog/views/catalog/type-display/list', [
                        'products' => $products
                    ]); ?>
                <?php endif; ?>

                <div class="pagination-wrap">
                    <?= LinkPager::widget([
                        'pagination' => $pagerItems,
                    ]); ?>
                </div>
            <?php else: ?>
                <img style="width: 100%;" src="/upload/images/not-found.png">
            <?php endif; ?>
        </div>
    </div>

</div>

<style type="text/css">
    body {
        background: url("../../images/brandpage/rc.jpg");
        background-position: top center;
        background-size: 100% 100%;
    }

    body > .page-container {
        background: white;
    }

    .footer {
        background: none !important;
    }
</style>
