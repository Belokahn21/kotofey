<?php

use yii\helpers\ArrayHelper;
use app\modules\menu\models\entity\MenuItem;

/* @var $form \yii\widgets\ActiveForm
 * @var $model \app\modules\menu\models\entity\MenuItem
 * @var $listMenu \app\modules\menu\models\entity\Menu[]
 */
?>

<nav>
    <div class="nav nav-tabs" id="backendForms" role="tablist">
        <a class="nav-item nav-link active" id="nav-main-edit-tab" data-toggle="tab" href="#nav-main-edit" role="tab" aria-controls="nav-main-edit" aria-selected="false">Главное</a>
    </div>
</nav>
<div class="tab-content" id="backendFormsContent">
    <div class="tab-pane fade show active" id="nav-main-edit" role="tabpanel" aria-labelledby="nav-main-edit">
        <?= $form->field($model, 'is_active')->checkbox(); ?>
        <?= $form->field($model, 'name'); ?>
        <?= $form->field($model, 'parent_id')->dropDownList(ArrayHelper::map(MenuItem::find()->all(), 'id', 'name'), ['prompt' => 'Родительский пункт менню']); ?>
        <?= $form->field($model, 'menu_id')->dropDownList(ArrayHelper::map($listMenu, 'id', 'name'), ['prompt' => 'Меню']); ?>
        <?= $form->field($model, 'sort')->textInput(['value' => 500]); ?>
    </div>
</div>