<?php

use yii\widgets\ActiveForm;
use yii\helpers\Html;

/* @var $model \app\modules\search\models\entity\Search */

$phrase = @Yii::$app->request->get()['Search']['search'];
?>

<div class="search-react" data-options='<?= \yii\helpers\Json::encode([
    'searchText' => $phrase
]) ?>'></div>