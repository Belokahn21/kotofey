<?php

/* @var $models \app\modules\promotion\models\entity\Promotion[] */

use yii\helpers\Url;
use yii\helpers\Html;
use app\widgets\Breadcrumbs;
use app\modules\seo\models\tools\Title;
use app\modules\promotion\models\helpers\PromotionHelper;

$this->title = Title::show('Скидки и акции');
$this->params['breadcrumbs'][] = ['label' => 'Скидки и акции', 'url' => Url::to(['/promotion/'])];
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
        <div class="promotion-list">

            <?php foreach ($models as $model): ?>
                <a href="<?= PromotionHelper::getDetailUrl($model); ?>" class="promotion-list__item">
                    <?php if ($model->media): ?>
                        <?= Html::img(PromotionHelper::getImageUrl($model), [
                            'class' => 'promotion-list__image'
                        ]) ?>
                    <?php else: ?>
                        <?= $model->name; ?>
                    <?php endif; ?>
                </a>
            <?php endforeach; ?>
        </div>
    <?php else: ?>
        <p>Новых акций нету, приходите чуть позже!</p>
    <?php endif; ?>
</div>
