<?php
/* @var $this \yii\web\View
 * @var $module \yii\base\Module
 * @var $model \app\modules\site\models\entity\ModuleSettings
 */

use yii\widgets\ActiveForm;
use yii\helpers\Html;

?>
<?php if (method_exists($module, 'getParams')): ?>
    <?php $form = ActiveForm::begin(); ?>
    <?php foreach ($module->getParams() as $moduleParameter => $defaultValue): ?>
        <?= $form->field($model, 'paramName'); ?>
        <?= $form->field($model, 'paramValue')->textInput(['value' => $defaultValue]); ?>
    <?php endforeach; ?>
    <?= Html::submitButton('Сохранить', ['btn-main']); ?>
    <?php ActiveForm::end(); ?>
<?php endif; ?>
