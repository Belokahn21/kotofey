<?php

use app\modules\rbac\models\entity\AuthItem;
use yii\helpers\ArrayHelper;

/* @var $model AuthItem
 * @var $form \yii\widgets\ActiveForm
 */

?>

<nav>
    <div class="nav nav-tabs" id="nav-tab" role="tablist">
        <a class="nav-item nav-link active" id="nav-home-tab" data-toggle="tab" href="#nav-home" role="tab" aria-controls="nav-home" aria-selected="true">Основное</a>
        <a class="nav-item nav-link " id="nav-permissions-tab" data-toggle="tab" href="#nav-permissions" role="tab" aria-controls="nav-home" aria-selected="true">Разрешения</a>
    </div>
</nav>
<div class="tab-content" id="nav-tab-content-form">
    <div class="tab-pane fade show active" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab">
        <?= $form->field($model, 'name')->textInput(); ?>
        <?= $form->field($model, 'parent')->dropDownList(ArrayHelper::map((new AuthItem())->threeGroups(), 'name', 'format_name'), ['prompt' => 'Родительская группа']); ?>
        <?= $form->field($model, 'description')->textInput(); ?>
    </div>
    <div class="tab-pane fade" id="nav-permissions" role="tabpanel" aria-labelledby="nav-permissions-tab">
        <?= $form->field($model, 'permissionsGroup')->dropDownList(ArrayHelper::map($permissions, 'name', 'name'), ['prompt' => 'Выбрать разрешения', 'multiple' => true, 'size' => 20]); ?>
    </div>
</div>