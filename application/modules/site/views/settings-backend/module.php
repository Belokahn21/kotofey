<?php
/* @var $this \yii\web\View
 * @var $module \yii\base\Module
 * @var $model \app\modules\site\models\entity\ModuleSettings
 */

use app\modules\site\models\entity\ModuleSettings;
use app\modules\seo\models\tools\Title;
use yii\helpers\ArrayHelper;
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
                <b><?= ArrayHelper::getValue($module->getParamsLabel(), $moduleParameter, $moduleParameter); ?></b>
                <?= $form->field($model, '[' . $moduleParameter . ']param_name')->hiddenInput(['value' => $moduleParameter])->label(false); ?>
            </div>
            <div class="col-2">
                <?php $value = $defaultValue; ?>
                <?php $valueModel = ModuleSettings::findOne(['module_id' => $module->id, 'param_name' => $moduleParameter]); ?>
                <?php if ($valueModel) $value = $valueModel->param_value; ?>


                <?php if (is_array($defaultValue)): ?>
                    <?php
                    $dropParams = ['prompt' => 'Выбрать значение'];

                    if ($value) {
                        $dropParams['options'] = [$value => ["selected" => true]];
                    }

                    ?>
                    <?= $form->field($model, '[' . $moduleParameter . ']param_value')->dropDownList($defaultValue, $dropParams)->label(false); ?>
                <?php else: ?>
                    <?= $form->field($model, '[' . $moduleParameter . ']param_value')->textInput(['value' => $value])->label(false); ?>
                <?php endif; ?>

            </div>
        </div>
    <?php endforeach; ?>
    <?= Html::submitButton('Сохранить', ['class' => 'btn-main']); ?>
    <?php ActiveForm::end(); ?>
<?php endif; ?>
