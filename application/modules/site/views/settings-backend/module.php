<?php
/* @var $this \yii\web\View
 * @var $module \yii\base\Module
 * @var $model \app\modules\site\models\entity\ModuleSettings
 */

use app\modules\site\models\helpers\ModuleSettingsHelper;
use app\modules\seo\models\tools\Title;
use yii\widgets\ActiveForm;
use yii\helpers\Html;

$this->title = Title::show('Настройки модуля: ' . $module->name);
?>
<h1>Настройки модуля: <?= $module->name; ?></h1>
<?php if (method_exists($module, 'getParams')): ?>
    <?php $form = ActiveForm::begin(); ?>
    <?php foreach ($module->getParams() as $moduleParameter => $defaultValue): ?>
        <div class="row">
            <?= $form->field($model, '[' . $moduleParameter . ']module_id')->hiddenInput(['value' => $module->id])->label(false); ?>
            <div class="col-2">
                <b><?= ModuleSettingsHelper::getLabel($moduleParameter, $module); ?></b>
                <?= $form->field($model, '[' . $moduleParameter . ']param_name')->hiddenInput(['value' => $moduleParameter])->label(false); ?>
            </div>
            <div class="col-2"><?= $form->field($model, '[' . $moduleParameter . ']param_value')->textInput(['value' => $defaultValue])->label(false); ?></div>
        </div>
    <?php endforeach; ?>
    <?= Html::submitButton('Сохранить', ['class' => 'btn-main']); ?>
    <?php ActiveForm::end(); ?>
<?php endif; ?>
