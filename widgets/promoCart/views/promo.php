<?

use yii\widgets\Pjax;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\models\entity\Basket;

?>

<div class="promo-cart-warp">
    <div class="order-type-form__title">Промокод</div>
    <?php Pjax::begin(); ?>

    <?php /* @var $promo  \app\models\entity\Promo */ ?>
    <?php if ($promo): ?>
        <div class="your-title-promo">
            Ваш промокод: <span class="your-title-promo-code"><?= $promo->code; ?></span>.
            Скидка <?php echo $promo->discount; ?>%
        </div>
    <? else: ?>
        <? $form = ActiveForm::begin([
            'options' => [
                'data-pjax' => true,
            ]
        ]); ?>
        <?= $form->field($model, 'code')->textInput(['placeholder' => 'Промокод'])->label(false) ?>
        <?php ActiveForm::end() ?>
    <?php endif; ?>

    <?php Pjax::end(); ?>

</div>
