<?php
/* @var $this \yii\web\View
 * @var $model \app\modules\user\models\entity\User
 * @var $orders \app\modules\order\models\entity\Order[]
 * @var $sexList \app\modules\user\models\entity\UserSex[]
 */

use yii\helpers\Url;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use app\models\tool\seo\Title;
use app\models\tool\Currency;
use app\modules\order\models\helpers\OrderHelper;

$this->title = Title::showTitle('Личный кабинет');
?>
<div class="page">
    <ul class="breadcrumbs">
        <li class="breadcrumbs__item"><a class="breadcrumbs__link" href="javascript:void(0);">Главная</a></li>
        <li class="breadcrumbs__item active"><a class="breadcrumbs__link" href="javascript:void(0);">Доставка и оплата</a></li>
    </ul>
    <h1 class="page__title">Личный кабинет</h1>
    <nav class="product-tabs in-profile">
        <div class="nav nav-tabs" id="nav-tab" role="tablist"><a class="nav-item nav-link active" id="nav-description-tab" data-toggle="tab" href="#nav-description" role="tab" aria-controls="nav-description" aria-selected="true">Мои заказы</a><a class="nav-item nav-link" id="nav-characteristics-tab" data-toggle="tab" href="#nav-characteristics" role="tab" aria-controls="nav-characteristics" aria-selected="false">Личные данные</a><a class="nav-item nav-link" id="nav-recommendations-tab" data-toggle="tab" href="#nav-recommendations" role="tab" aria-controls="nav-recommendations" aria-selected="false">Адрес доставки</a></div>
    </nav>
    <div class="tab-content" id="nav-tab-profile">
        <div class="tab-pane fade show active" id="nav-description" role="tabpanel" aria-labelledby="nav-description-tab">
			<?php if ($orders): ?>
                <ul class="order-list">
                    <li class="order-list__item order-list-header">
                        <div class="order-list__row order-list__date">Дата</div>
                        <div class="order-list__row order-list__number">Номер</div>
                        <div class="order-list__row order-list__summary">Сумма, <?= Currency::getInstance()->show(); ?></div>
                        <div class="order-list__row order-list__status">Статус</div>
                        <div class="order-list__row order-list__detail"></div>
                    </li>
					<?php foreach ($orders as $order): ?>
                        <li class="order-list__item order-list-body">
                            <div class="order-list__row order-list__date"><?= date('d.m.Y', $order->created_at); ?></div>
                            <div class="order-list__row order-list__number">Заказ №<?= $order->id; ?></div>
                            <div class="order-list__row order-list__summary"><?= OrderHelper::orderSummary($order->id); ?> <?= Currency::getInstance()->show(); ?></div>
                            <div class="order-list__row order-list__status"><?= OrderHelper::getStatus($order); ?></div>
                            <div class="order-list__row order-list__detail"><a href="<?= Url::to(['/order/order/view', 'id' => $order->id]); ?>">Подробнее</a></div>
                        </li>
					<?php endforeach; ?>
                </ul>
			<?php else: ?>
                У вас нет заказов. Следует исправить это!
			<?php endif ?>
        </div>
        <div class="tab-pane fade" id="nav-characteristics" role="tabpanel" aria-labelledby="nav-characteristics-tab">
			<?php $profile = ActiveForm::begin(); ?>
            <div class="row">
                <div class="col-6">
					<?= $profile->field($model, 'email')->textInput(); ?>
                    <div class=row>
                        <div class="col-4"><?= $profile->field($model, 'first_name')->textInput(); ?></div>
                        <div class="col-4"><?= $profile->field($model, 'name')->textInput(); ?></div>
                        <div class="col-4"><?= $profile->field($model, 'last_name')->textInput(); ?></div>
                    </div>
					<?= $profile->field($model, 'sex')->dropDownList(ArrayHelper::map($sexList, 'id', 'name'), ['prompt' => 'Выбрать']); ?>
                </div>
                <div class="col-6">
					<?php if ($model->avatar): ?>
                        <img src="/upload/<?= $model->avatar; ?>" style=" width: 200px; object-fit: contain; margin: 10px auto; display: block;">
					<?php endif; ?>
					<?= $profile->field($model, 'avatar')->fileInput(); ?>
                </div>
            </div>

			<?= Html::submitButton('Обновить', [
				'class' => 'btn-main'
			]); ?>
			<?php ActiveForm::end(); ?>
        </div>
        <div class="tab-pane fade" id="nav-recommendations" role="tabpanel" aria-labelledby="nav-recommendations-tab">...</div>
    </div>
</div>
