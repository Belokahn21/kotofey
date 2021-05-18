<?php

/* @var $models \app\modules\promotion\models\entity\Promotion[] */

use app\widgets\Breadcrumbs;
use app\modules\seo\models\tools\Title;
use app\modules\promotion\widgets\CurrentPromotions\CurrentPromotionsWidget;

$this->title = Title::show('Скидки и акции');
$this->params['breadcrumbs'][] = ['label' => 'Скидки и акции'];
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
    <h1 class="page__title">Скидки и акции</h1>
    <?php if ($models): ?>
        <?= CurrentPromotionsWidget::widget([
            'view' => 'no-slider',
            'models' => $models
        ]); ?>
    <?php else: ?>
        <p>Новых акций нету, приходите чуть позже!</p>
    <?php endif; ?>
</div>
