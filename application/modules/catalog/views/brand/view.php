<?php
/* @var $this yii\web\View */

/* @var $model \app\modules\catalog\models\entity\PropertiesProductValues */

use app\modules\catalog\models\helpers\ProductPropertiesValuesHelper;
use app\models\tool\seo\Title;
use app\widgets\Breadcrumbs;

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
    <h1><?= $model->name; ?></h1>

    <?php /* foreach (\app\modules\catalog\models\entity\Product::find()->joinWith('propsValues pv')->where(['pv.property_id' => 1, 'pv.value' => $model->id])->all() as $product): ?>
        <?= $product->name; ?>
    <?php endforeach; */ ?>
</div>
