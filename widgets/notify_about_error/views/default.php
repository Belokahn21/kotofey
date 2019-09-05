<?

use yii\widgets\ActiveForm;
use yii\helpers\Html;

?>
<section>
    <? $form = ActiveForm::begin(); ?>
    <?= $form->field($model, 'url')->hiddenInput(['value' => $_SERVER['SERVER_NAME']])->label(false); ?>
    <?= Html::button('Сообщите нам об этом!', ['class' => 'notify-about-error-button']); ?>
    <? ActiveForm::end(); ?>
</section>
