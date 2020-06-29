<?php

use yii\helpers\ArrayHelper;
use app\modules\vendors\models\entity\VendorGroup;

?>
<nav>
    <div class="nav nav-tabs" id="nav-tab" role="tablist">
        <a class="nav-item nav-link active" id="nav-home-tab" data-toggle="tab" href="#nav-home" role="tab" aria-controls="nav-home" aria-selected="true">Основное</a>
    </div>
</nav>
<div class="tab-content" id="nav-tab-content-form">
    <div class="tab-pane fade show active" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab">
        <div class="form-element">
            <?php echo $form->field($model, 'is_active')->checkbox(); ?>
        </div>
        <div class="form-element">
            <?php echo $form->field($model, 'name')->textInput(); ?>
        </div>
        <div class="form-element">
            <?php echo $form->field($model, 'sort')->textInput(); ?>
        </div>
    </div>
</div>