<?php

use yii\widgets\ActiveForm;
use app\models\entity\User;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;

?>
<div class="modal fade" id="new-task" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
			<?php $form = ActiveForm::begin(); ?>
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">Новое задание</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="task-element-form">
					<?= $form->field($model, 'user_id')->dropDownList(ArrayHelper::map(User::find()->all(), 'id', 'email'), ['prompt' => 'Кому поставить задачу?']); ?>
                </div>
                <div class="task-element-form">
					<?= $form->field($model, 'name')->textInput(); ?>
                </div>
                <div class="task-element-form">
					<?= $form->field($model, 'description')->textarea(); ?>
                </div>
            </div>
            <div class="modal-footer">
				<?= Html::button('Закрыть', ['class' => 'btn btn-secondary', 'data-dismiss' => 'modal']); ?>
				<?= Html::submitButton('Добавить', ['class' => 'btn btn-primary']); ?>
            </div>
			<?php ActiveForm::end(); ?>
        </div>
    </div>
</div>