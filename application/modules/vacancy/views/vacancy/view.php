<?php

use yii\helpers\Url;
use app\widgets\Breadcrumbs;

/* @var $model \app\modules\vacancy\models\entity\Vacancy */
?>
<div class="page">
    <?php
    $this->params['breadcrumbs'][] = ['label' => 'Вакансии', 'url' => Url::to(['/vacancy/index'])];
    $this->params['breadcrumbs'][] = ['label' => $model->title, 'url' => Url::to(['/vacancy/index'])];
    ?>
    <?= Breadcrumbs::widget([
        'homeLink' => [
            'label' => 'Главная ',
            'url' => Yii::$app->homeUrl,
            'title' => 'Первая страница сайта зоомагазина Котофей',
        ],
        'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
    ]); ?>
    <h1 class="page__title"><?= $model->title; ?></h1>
</div>