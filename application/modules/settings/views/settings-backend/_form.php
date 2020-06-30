<?php

use yii\helpers\ArrayHelper;
use app\modules\site_settings\models\entity\SiteTypeSettings;

?>
<?php if (!empty($_GET['type'])) {
    $model->type = $_GET['type'];
} ?>
<?= $form->field($model, 'type')->dropDownList(ArrayHelper::map(SiteTypeSettings::find()->all(), 'code', 'name'), ['prompt' => 'Тип параметра', 'id' => 'select-type-settings']); ?>
<?= $form->field($model, 'name'); ?>
<?= $form->field($model, 'code'); ?>
<?php if ($model->type == 'file'): ?>
    <?= $form->field($model, 'file')->fileInput(); ?>
<?php else: ?>
    <?= $form->field($model, 'value'); ?>
<?php endif; ?>