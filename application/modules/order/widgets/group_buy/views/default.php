<?php

use yii\helpers\Html;

/* @var $groupedData array */

?>
<?= Html::a('Группировка', 'javascript:void(0);', ['class'=>'group-buy-toggle btn-main','data-target' => '#group-buy', 'data-toggle' => 'modal']); ?>
<?= $this->render('data-modal', [
    'groupedData' => $groupedData
]); ?>
