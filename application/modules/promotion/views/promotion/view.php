<?php

/* @var $model \app\modules\promotion\models\entity\Promotion
 * @var $products \app\modules\promotion\models\entity\PromotionProductMechanics[]
 * @var $this \yii\web\View
 */

use app\modules\seo\models\tools\Title;
use yii\helpers\Html;
use app\widgets\Breadcrumbs;
use app\modules\promotion\models\helpers\PromotionHelper;

$this->title = Title::show('Скидки и акции');
$this->params['breadcrumbs'][] = ['label' => 'Скидки и акции', 'url' => ['/promotion/']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => [PromotionHelper::getDetailUrl($model)]];
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
    <h1 class="page__title"><?= $model->name; ?></h1>
    <?php if ($model->media): ?>
        <?= Html::img(PromotionHelper::getImageUrl($model), ['width' => '100%']); ?>
    <?php endif; ?>
    <?php if ($products): ?>
        <h2 class="mt-5">Товары участвующие в акции</h2>
        <div class="catalog-wrap">
            <ul class="catalog">
                <?php foreach ($products as $product): ?>
                    <?= $this->render('@app/modules/catalog/views/__item-block', [
                        'product' => $product->product
                    ]); ?>
                <?php endforeach; ?>
            </ul>
        </div>
    <?php endif; ?>
</div>
