<?php
/* @var $this \yii\web\View */
/* @var $models \app\modules\catalog\models\entity\Product[] */

var_dump($models);
exit();
?>

<ul>
    <?php foreach ($models as $model): ?>
        <li><?= \yii\helpers\Html::a($model->name, \yii\helpers\Url::to(['product-backend/update', 'id' => $model->id]), ['target' => '_blank']); ?></li>
    <?php endforeach; ?>
</ul>
