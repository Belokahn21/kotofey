<?

use yii\widgets\Pjax;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\models\entity\Basket;

?>

<div class="promo-cart-warp">

    <? Pjax::begin(); ?>

    <? /* @var $promo  \app\models\entity\Promo */ ?>
    <? if ($promo): ?>
        <div class="your-title-promo">
            Ваш промокод: <span class="your-title-promo-code"><?= $promo->code; ?></span>.
            Скидка <?= $promo->discount; ?>%
        </div>
    <? else: ?>
        <? $form = ActiveForm::begin([
            'options' => [
                'data-pjax' => true,
            ]
        ]); ?>
        <?= $form->field($model, 'code') ?>
        <? ActiveForm::end() ?>
    <? endif; ?>

    <? Pjax::end(); ?>

</div>
