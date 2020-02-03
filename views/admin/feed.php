<?php

use app\models\tool\seo\Title;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;

/* @var $property_values \app\models\entity\InformersValues[] */
/* @var $model \app\models\forms\FeedmakerForm */
/* @var $products \app\models\entity\Product[] */

$this->title = Title::showTitle("Поисковой контент по производителям");
?>
<h1>Поисковой контент по производителям</h1>
<?php $form = ActiveForm::begin(); ?>
<?= $form->field($model, 'update')->checkbox(); ?>
<?= $form->field($model, 'name')->textInput(); ?>
<?= $form->field($model, 'feed')->textarea(); ?>
<?= Html::submitButton('Выполнить', ['class' => 'btn-main']); ?>
<?php ActiveForm::end(); ?>
<?php if ($products): ?>
    <ul class="">
		<?php foreach ($products as $product): ?>
            <li><?= $product->name; ?>: <?= $product->feed; ?></li>
		<?php endforeach; ?>
    </ul>
<?php endif; ?>
