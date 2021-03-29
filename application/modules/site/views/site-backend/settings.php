<?php

use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;

/* @var $this \yii\web\View */
/* @var $moduleParams array|\yii\db\ActiveRecord[] */
/* @var $module \yii\base\Module */
/* @var $model \app\modules\site\models\entity\ModuleSettings */

$this->title = \app\modules\seo\models\tools\Title::show('Настройки модуля: ' . $module->name);
?>

<?php $form = ActiveForm::begin(); ?>
<?php foreach ($module->getParams() as $param => $defaultValue): ?>
    <?= $form->field($model, 'param_name')->hiddenInput()->label(false); ?>
    <div class="row">
        <div class="col-12">
            <b><?= ArrayHelper::getValue($module->getParamsLabel(), $param, $param); ?></b>
            <?= $form->field($model, 'param_value')->textInput(['value' => $defaultValue])->label(false); ?>
        </div>
    </div>
<?php endforeach; ?>
<?php ActiveForm::end(); ?>
