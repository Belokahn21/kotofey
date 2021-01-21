<?php

use yii\helpers\Html;

?>

<?= Html::submitButton('Уведомить о поступлении', [
    'class' => 'product-status__notify',
    'data-toggle' => 'modal tooltip',
    'data-target' => '#signinModal',
    'data-placement' => "top",
    'title' => "Доступно только авторизованным пользователям"
]); ?>