<?php

/* @var $links array
 * @var $title string
 */

use yii\helpers\Html;

?>
<div class="title-group">
    <h1><?= $title; ?></h1>

    <?php foreach ($links as $link): ?>
        <?= Html::a($link['title'], $link['url'], ['class' => 'btn-main', 'target' => '_blank']); ?>
    <?php endforeach; ?>

</div>