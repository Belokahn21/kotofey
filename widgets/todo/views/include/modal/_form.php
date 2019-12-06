<?php

use yii\helpers\ArrayHelper;
use app\models\entity\User;

?>
<div class="task-element-form">
	<?= $form->field($model, 'user_id')->dropDownList(ArrayHelper::map(User::find()->all(), 'id', 'email'), ['prompt' => 'Кому поставить задачу ? ']); ?>
</div>
<div class="task-element-form">
	<?= $form->field($model, 'close')->dropDownList(['Открыто', 'Закрыто'], ['prompt' => 'Закрытость']); ?>
</div>
<div class="task-element-form">
	<?= $form->field($model, 'name')->textInput(); ?>
</div>
<div class="task-element-form">
	<?= $form->field($model, 'description')->textarea(); ?>
</div>