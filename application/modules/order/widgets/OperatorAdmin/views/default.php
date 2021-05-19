<?php

use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use app\modules\user\models\helpers\UserHelper;

?>
<?= Html::beginForm('','get'); ?>
<?= Html::dropDownList('manager_id', false, ArrayHelper::map(UserHelper::getManagers(), 'id', 'email'), ['prompt' => 'Войти под оператором']); ?>
<?= Html::submitButton('Применить', ['class' => 'btn-main']); ?>
<?= Html::endForm(); ?>