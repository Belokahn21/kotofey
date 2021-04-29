<?php

/* @var $this \yii\web\View
 * @var $model \app\modules\pets\models\entity\Pets
 */

use yii\helpers\Url;
use app\widgets\Breadcrumbs;
use app\modules\seo\models\tools\Title;

$this->title = Title::show('Личный кабинет');
$this->params['breadcrumbs'][] = ['label' => 'Личный кабинет', 'url' => Url::to(['/profile/'])];
$this->params['breadcrumbs'][] = ['label' => 'Изменение даных питомца'];

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
    <h1 class="page__title">Изменить питомца: <?= $model->name; ?></h1>
</div>