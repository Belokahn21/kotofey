<?

use yii\widgets\ActiveForm;
use yii\bootstrap\Modal;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use app\models\tool\Policy;

/* @var $order \app\models\entity\Order */
/* @var $billing \app\models\entity\user\Billing */
/* @var $delivery array */
/* @var $payments array */
/* @var $product \app\models\entity\Product */
/* @var $this \yii\web\View */
?>
<div class="product-button product-fast-buy" onclick="ym(55089223, 'reachGoal', 'fast_buy');" data-toggle="modal" data-target="#modal-product-detail-buy-click">
    Купить в 1 клик
</div>

<!-- Modal -->
<div class="modal fade" id="modal-product-detail-buy-click" tabindex="-1" role="dialog" aria-labelledby="modal-product-detail-delivery-label" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
			<?php $form = ActiveForm::begin(); ?>
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Купить в один клик</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="fast-buy-wrap">
                    <div class="fast-buy-image-wrap">
						<?php if (!empty($product->image) and is_file(Yii::getAlias('@webroot/upload/') . $product->image)): ?>
                            <img class="fast-buy-image" src="/web/upload/<?= $product->image; ?>" alt="<?= $product->name; ?>" title="<?= $product->name; ?>">
						<?php else: ?>
                            <img class="fast-buy-image" src="/web/upload/images/not-image.png" alt="<?= $product->name; ?>" title="<?= $product->name; ?>">
						<?php endif; ?>
                    </div>
                    <div class="fast-buy__title"><?= $product->name; ?></div>
                </div>
				<?php if (Yii::$app->user->isGuest): ?>
					<?= $this->render('_form', [
						'user' => $user,
						'form' => $form
					]); ?>
				<?php else: ?>
					<?= $this->render('_info'); ?>
				<?php endif; ?>
            </div>
            <div class="modal-footer">
				<?= Html::a('Персональные данные', Policy::getInstance()->getPath(), ['target' => '_blank']) ?>
				<?= Html::button('Закрыть', ['class' => 'btn-cancel', 'data-dismiss' => 'modal']) ?>
				<?= Html::submitButton('Купить', ['class' => 'btn-main']) ?>
            </div>
			<?php ActiveForm::end(); ?>
        </div>
    </div>
</div>