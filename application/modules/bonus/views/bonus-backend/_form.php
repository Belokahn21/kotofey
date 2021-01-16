<?php
/* @var $form \yii\widgets\ActiveForm
 * @var $model \app\modules\bonus\models\entity\UserBonus
 */

use yii\helpers\ArrayHelper;

?>

<nav>
    <div class="nav nav-tabs" id="backendForms" role="tablist">
        <a class="nav-item nav-link active" id="nav-main-edit-tab" data-toggle="tab" href="#nav-main-edit" role="tab" aria-controls="nav-main-edit" aria-selected="false">Главное</a>
    </div>
</nav>
<div class="tab-content" id="backendFormsContent">
    <div class="tab-pane fade show active" id="nav-main-edit" role="tabpanel" aria-labelledby="nav-main-edit">
        <?= $form->field($model, 'phone') ?>
        <?= $form->field($model, 'count') ?>
    </div>
</div>