<?

use yii\widgets\ActiveForm;
use yii\bootstrap\Modal;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use app\models\tool\Policy;

?>
<?
/* @var $order \app\models\entity\Order */
/* @var $billing \app\models\entity\user\Billing */
/* @var $delivery array */
/* @var $payments array */
/* @var $product \app\models\entity\Product */
?>
<? Modal::begin([
    'header' => '<h2>Быстрая покупка</h2>',
    'toggleButton' => ['label' => 'Купить в 1 клик', 'class' => 'detail-product__buy'],
]); ?>
<?php $form = ActiveForm::begin(); ?>

    <div class="fast_buy_detail_product">
        <div class="fast_buy_detail_product__image-wrap">
            <img class="fast_buy_detail_product__image" src="<?php echo $product->image; ?>" alt="<?php echo $product->name; ?>" title="<?php echo $product->name; ?>">
        </div>
        <div class="fast_buy_detail_product__title"><?php echo $product->name; ?></div>
    </div>

    <hr/>

<?php if (Yii::$app->user->isGuest): ?>
    <?php include_once "_form.php"; ?>
<?php endif; ?>

<?= Html::submitButton('Заказать', ['class' => 'btn-main', 'value' => 'nopaid', 'name' => 'type']) ?>
<?= Html::a("Персональные данные", (new Policy())->getPath(), ['class' => 'policy-link-checkout']); ?>
<? ActiveForm::end(); ?>

<? Modal::end(); ?>