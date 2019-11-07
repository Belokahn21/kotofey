<?

use app\models\tool\seo\Title;
use yii\widgets\ActiveForm;
use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;

/* @var $model \app\models\entity\OrderStatus */
/* @var $this \yii\web\View */
?>
<? $this->title = Title::showTitle("Статус: " . $model->name); ?>
<section>
    <h1 class="title">Статус: <?= $model->name; ?></h1>
	<?= Html::a("Назад", '/admin/status/', ['class' => 'btn-back']) ?>
	<? $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>
	<?= $this->render('../_forms/_status', [
		'model' => $model,
		'form' => $form
	]) ?>
	<?= Html::submitButton('Обновить', ['class' => 'btn-main']); ?>
	<? ActiveForm::end(); ?>
</section>
