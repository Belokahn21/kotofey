<?php

use app\models\tool\seo\Title;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;

/* @var $this \yii\web\View */
/* @var $sales \app\modules\catalog\models\entity\InformersValues[] */
/* @var $model \app\models\forms\SaleProductForm */

$this->title = Title::showTitle("Упрвление акционными товарами");
?>
<section>
    <h1 class="title">Упрвление акционными товарами</h1>
	<?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>
    <div class="form-element">
		<?= $form->field($model, 'sale_id')->dropDownList(ArrayHelper::map($sales, 'id', 'name')); ?>
    </div>
	<?= Html::submitButton('Снять с акции', ['class' => 'btn-main']); ?>
	<?php ActiveForm:: end(); ?>
</section>



