<?php

use app\models\entity\Payment;
use app\models\entity\Delivery;
use yii\grid\GridView;
use yii\helpers\Html;
use app\models\tool\seo\Title;
use app\models\entity\User;
use yii\widgets\ActiveForm;
use yii\helpers\Url;
use app\models\helpers\OrderHelper;
use app\models\tool\statistic\OrderStatistic;

/* @var $model \app\modules\order\models\entity\Order */

$this->title = Title::showTitle("Список заказов"); ?>
    <section class="new-order-block">
		<?php $form = ActiveForm::begin(); ?>
		<?= $this->render('_forms/_order', [
			'form' => $form,
			'model' => $model,
			'itemModel' => $itemModel,
			'items' => array()
		]); ?>
		<?= Html::submitButton('Добавить', ['class' => 'btn-main']) ?>
		<?php ActiveForm::end(); ?>
    </section>