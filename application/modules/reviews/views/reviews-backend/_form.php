<?php

use yii\helpers\ArrayHelper;
use app\modules\user\models\entity\User;

/* @var $model \app\modules\reviews\models\entity\Reviews
 * @var $form \yii\widgets\ActiveForm
 */

?>
<nav>
    <div class="nav nav-tabs" id="backendForms" role="tablist">
        <a class="nav-item nav-link active" id="nav-common-edit-tab" data-toggle="tab" href="#nav-common-edit" role="tab" aria-controls="nav-common-edit" aria-selected="false">Основное</a>
    </div>
</nav>

<div class="tab-content" id="backendFormsContent">
    <div class="tab-pane fade show active" id="nav-common-edit" role="tabpanel" aria-labelledby="nav-common-edit">
        <?= $form->field($model, 'is_active')->checkbox(); ?>
        <?= $form->field($model, 'status_id')->dropDownList($model->getStatusList(), ['prompt' => 'Статус']); ?>
        <?= $form->field($model, 'rate')->dropDownList($model->getRates(), ['prompt' => 'Оценка']); ?>
        <?= $form->field($model, 'user_id')->dropDownList(ArrayHelper::map(User::find()->all(), 'id', 'email'), ['prompt' => 'Автор']); ?>
        <?= $form->field($model, 'text')->textarea(); ?>
    </div>
</div>