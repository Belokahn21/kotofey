<?php

use yii\web\View;
use yii\helpers\Url;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $model \app\modules\catalog\models\entity\NotifyAdmission
 * @var $product \app\modules\catalog\models\entity\Product
 * @var $this \yii\web\View
 */

//todo остается кнопка отправить, отправляем аякс, в успехе меняем кнопку на надпись - вы уже отслеживаете товар(отписаться)
?>

<?php $form = ActiveForm::begin([
    'options' => [
        'class' => 'site-form',
        'enctype' => 'multipart/form-data'
    ],
    'id' => 'form-admission-id',
    'action' => Url::to(['/save-notify-admission']),
    'enableAjaxValidation' => true
]); ?>
<?php $form->field($model, 'email')->hiddenInput(['value' => Yii::$app->user->identity->email, 'readonly' => true])->label(false); ?>
<?php $form->field($model, 'product_id')->hiddenInput(['value' => $model->id, 'readonly' => true])->label(false); ?>
<?= Html::submitButton('Уведомить о поступлении', [
    'class' => 'product-status__notify'
]); ?>
<?php ActiveForm::end(); ?>
<?php /*
 <div class="modal fade authModal " id="notifyPickup<?= $product->id; ?>" tabindex="-1" role="dialog" aria-labelledby="notifyPickup<?= $product->id; ?>Label" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <?php $form = ActiveForm::begin([
                'options' => [
                    'class' => 'site-form',
                    'enctype' => 'multipart/form-data'
                ],
                'id' => 'form-admission-id',
                'action' => Url::to(['/save-notify-admission']),
                'enableAjaxValidation' => true
            ]); ?>
            <div class="modal-header">
                <h5 class="modal-title" id="notifyPickup<?= $product->id; ?>Label">Уведомить о поступлении товара</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="site-form__item">
                    <label class="site-form__label" for="site-form-email">Адрес вашей электронной почты</label>
                    <?= $form->field($model, 'email')->textInput([
                        'class' => 'site-form__input',
                        'id' => 'site-form-email',
                        'placeholder' => 'Адрес вашей электронной почты',
                    ])->label(false); ?>
                </div>
                <?= $form->field($model, 'product_id')->hiddenInput(['value' => $product->id])->label(false); ?>
                <?= Html::submitButton('Отправить', ['class' => 'btn-main']) ?>
            </div>
            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>

 */ ?>
<?php
$jscode = <<<JS
    $(document).on('submit', 'form.site-form', function (e) {
        e.preventDefault();
        let form = $(this);
        
        $.ajax({
            url:form.attr('action'),
            method:'POST',
            data:form.serialize(),
            success:function(data){
                data = JSON.parse(data);
                console.log(data);
            }
        });
        
    });
JS;

$this->registerJs($jscode, View::POS_END);
?>
