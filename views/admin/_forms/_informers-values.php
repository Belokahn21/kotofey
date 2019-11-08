<?php

use app\models\entity\Informers;
use yii\helpers\ArrayHelper;

?>
<div class="tabs-container">
    <ul class="tabs">
        <li class="tab-link current" data-tab="tab-1">Основное</li>
    </ul>

    <div id="tab-1" class="tab-content current">
        <?= $form->field($model, 'informer_id')->dropDownList(ArrayHelper::map(Informers::find()->all(), 'id','name'), ['prompt'=>'Справочник']) ?>
        <?= $form->field($model, 'value')->textInput() ?>
        <?= $form->field($model, 'description')->textarea() ?>
    </div>

</div>