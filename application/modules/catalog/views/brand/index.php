<?php
/* @var $this yii\web\View
 * @var $models \app\modules\catalog\models\entity\PropertiesProductValues[]
 */


use app\modules\seo\models\tools\Title;
use app\widgets\Breadcrumbs;

$this->params['breadcrumbs'][] = ['label' => 'Бренды', 'url' => ['/catalog/brand/index']];
$this->title = Title::show('Бренды');
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
    <h1>Бренды</h1>

    <?php foreach ($models as $model): ?>
    <?php endforeach; ?>
</div>
