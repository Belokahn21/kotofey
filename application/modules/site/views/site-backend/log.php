<?php
/* @var $this \yii\web\View */

use yii\helpers\Url;
use yii\helpers\Html;

?>
<div class="title-group">
    <?= Html::a('Очистить', Url::to(['site-backend/log-clear']), ['class' => 'btn-main']); ?>
</div>
<?= $attributes; ?>
