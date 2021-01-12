<?php

/* @var $models \app\modules\promotion\models\entity\Promotion[] */

use app\models\tool\seo\Title;
use app\widgets\Breadcrumbs;
use yii\helpers\Html;
use app\modules\promotion\models\helpers\PromotionHelper;

$this->title = Title::showTitle('Скидки и акции');
$this->params['breadcrumbs'][] = ['label' => 'Скидки и акции', 'url' => ['/promotion/']];
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
        <?php foreach ($models as $model): ?>
            <a href="<?= PromotionHelper::getDetailUrl($model); ?>">
                <?php if ($model->media): ?>
                    <?= Html::img(\Yii::$app->CDN->resizeImage($model->media->cdnData['public_id'])) ?>
                <?php else: ?>
                    <?= $model->name; ?>
                <?php endif; ?>
            </a>
        <?php endforeach; ?>
    <?php else: ?>
        <p>Новых акций нету, приходите чуть позже!</p>
    <?php endif; ?>
</div>
