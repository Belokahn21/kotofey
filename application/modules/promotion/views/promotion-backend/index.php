<?php

use app\models\tool\seo\Title;
use yii\widgets\ActiveForm;

/* @var $this \yii\web\View
 * @var $model \app\modules\promotion\models\entity\Promotion
 */

$this->title = Title::showTitle('Акции магазина');
?>
<div class="title-group">
    <h1>Акции магазина</h1>
</div>
<?php $form = ActiveForm::begin() ?>
<?= $this->render('_form', [
    'form' => $form,
    'model' => $model,
]); ?>
<?php ActiveForm::end() ?>
