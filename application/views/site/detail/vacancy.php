<?php

use app\models\tool\seo\Title;
use yii\helpers\Url;

/* @var $model \app\modules\vacancy\models\entity\Vacancy */

$this->title = Title::showTitle($model->title);

$this->params['breadcrumbs'][] = ['label' => 'Вакансии', 'url' => [Url::to(['site/vacancy'])]];
$this->params['breadcrumbs'][] = ['label' => $model->title, 'url' => [Url::to(['/vacancy/' . $model->slug . '/'])]];
?>
<h1>Вакансия: <?= $model->title; ?></h1>
