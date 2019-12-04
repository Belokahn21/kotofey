<?php

use yii\widgets\ActiveForm;
use app\models\entity\User;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\helpers\Url;

?>
<div class="modal fade" id="update-task" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
			<?php $form = ActiveForm::begin(); ?>
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">Редактировать: <?= $model->name; ?></h5>
				<?= Html::a('<span aria-hidden="true">&times;</span>', Url::to(['admin/index']), ['class' => 'close', 'aria-label' => 'Close']); ?>
            </div>
            <div class="modal-body">
                <div class="task-element-form">
					<?= $form->field($model, 'user_id')->dropDownList(ArrayHelper::map(User::find()->all(), 'id', 'email'), ['prompt' => 'Кому поставить задачу ? ']); ?>
                </div>
                <div class="task-element-form">
					<?= $form->field($model, 'name')->textInput(); ?>
                </div>
                <div class="task-element-form">
					<?= $form->field($model, 'description')->textarea(); ?>
                </div>
            </div>
            <div class="modal-footer">
				<?= Html::a('Закрыть', Url::to(['admin/index']), ['class' => 'btn btn-secondary']); ?>
				<?= Html::submitButton('Обновить', ['class' => 'btn btn-primary']); ?>
            </div>
			<?php ActiveForm::end(); ?>
        </div>
    </div>
</div>