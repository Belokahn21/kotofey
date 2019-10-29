<?

/* @var $this yii\web\View */

/* @var $model \app\models\entity\Delivery */

use app\models\tool\seo\Title;
use yii\widgets\ActiveForm;
use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\Url;

$this->title = Title::showTitle($model->name);
?>
<section class="delivery">
    <h1 class="title">Доставка: <?= $model->name; ?></h1>
	<? $form = ActiveForm::begin(); ?>
	<?= $form->field($model, 'active')->checkbox(); ?>
	<?= $form->field($model, 'name') ?>
	<?= $form->field($model, 'description')->textarea(); ?>
	<?= Html::submitButton('Обновить', ['class' => 'btn-main']) ?>
	<? ActiveForm::end(); ?>
</section>