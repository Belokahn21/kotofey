<?

use app\models\tool\seo\Title;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

$this->title = Title::showTitle("Разделы технической поддержки"); ?>
<section>
    <h1 class="title">Разделы</h1>
    <? $form = ActiveForm::begin(); ?>
    <?= $form->field($model, 'name'); ?>
    <?= $form->field($model, 'description')->textarea(); ?>
    <?= $form->field($model, 'sort'); ?>
	<?= Html::submitButton('Добавить', ['class' => 'btn-main']); ?>
    <? ActiveForm::end(); ?>
</section>

