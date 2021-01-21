<?php

use yii\web\View;
use yii\helpers\Url;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\modules\catalog\models\helpers\NotifyAdmissionHelper;

/* @var $model \app\modules\catalog\models\entity\NotifyAdmission
 * @var $product \app\modules\catalog\models\entity\Product
 * @var $this \yii\web\View
 */

//todo остается кнопка отправить, отправляем аякс, в успехе меняем кнопку на надпись - вы уже отслеживаете товар(отписаться)

$hideAlready = ' hidden';
$hideForm = ' hidden';

if (NotifyAdmissionHelper::isAlreadyObserver($product->id, Yii::$app->user->identity->email)) {
    $hideAlready = "";
    $hideForm = " hidden";
} else {
    $hideAlready = ' hidden';
    $hideForm = '';
}
?>


<div class="product-status__already<?= $hideAlready ?>">Вы уже отслеживаете этот товар (<?= Html::a('Отмена', 'javascript:void(0);', ['class' => 'remove-notify-admission', 'data-product-id' => $product->id]); ?>)</div>
<?php $form = ActiveForm::begin([
    'options' => [
        'class' => 'site-form' . $hideForm,
        'enctype' => 'multipart/form-data'
    ],
    'id' => 'form-admission-id',
    'action' => Url::to(['/save-notify-admission']),
]); ?>
<?= $form->field($model, 'email')->hiddenInput(['value' => Yii::$app->user->identity->email, 'readonly' => true])->label(false); ?>
<?= $form->field($model, 'product_id')->hiddenInput(['value' => $product->id, 'readonly' => true])->label(false); ?>
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
$email = Yii::$app->user->identity->email;
$jscode = <<<JS
    let form = $("#form-admission-id");
    let alreadyElement = $(".product-status__already");
    
    $(document).on('submit', 'form.site-form', function (e) {
        e.preventDefault();
        let thisEl = $(this);
        
        $.ajax({
            url:thisEl.attr('action'),
            method:'POST',
            data:thisEl.serialize(),
            success:function(data){
                data = JSON.parse(data);
                
                if(data.success == 1){
                    form.toggleClass('hidden');
                    alreadyElement.toggleClass('hidden');
                }
            }
        });
        
    });
    $('.remove-notify-admission').click(function (e) {
        e.preventDefault();
        let thisEl = $(this);
        
        $.ajax({
            url:'/remove-notify-admission/',
            method:'POST',
            data:{
                'product_id':thisEl.data('product-id'),
                'email':'$email'
            },
            success:function(data){
                data = JSON.parse(data);
                if(data.success == 1){
                    form.toggleClass('hidden');
                    alreadyElement.toggleClass('hidden');
                }
            }
        });
        
    });
JS;

$this->registerJs($jscode, View::POS_END);
?>
