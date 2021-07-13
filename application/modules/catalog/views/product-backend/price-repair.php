<?php
/* @var $this \yii\web\View
 * @var $models \app\modules\catalog\models\entity\Offers[]
 */

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;

?>
<?php $form = ActiveForm::begin(); ?>
<?= $form->field($model, 'name'); ?>
<?= $form->field($model, 'amount'); ?>
<?= Html::submitButton('Отправить'); ?>
<?php ActiveForm::end(); ?>
<ul>
    <?php foreach ($models as $model): ?>
        <li>
            Цена: <?= $model->price; ?>
            Закупочная: <?= $model->purchase; ?>
            <?= \app\modules\catalog\models\helpers\ProductHelper::getMarkup($model); ?>
            <?= Html::a($model->name, Url::to(['product-backend/update', 'id' => $model->id]), ['target' => '_blank']); ?>
        </li>
    <?php endforeach; ?>
</ul>
