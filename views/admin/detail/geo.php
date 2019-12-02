<?

use app\models\tool\seo\Title;
use yii\widgets\ActiveForm;
use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\Url;

/* @var $model \app\models\entity\Geo */
/* @var $this \yii\web\View */

$this->title = Title::showTitle("Гео объекты"); ?>
<section>
    <h1 class="title">Гео объекты</h1>
    <div class="celearfix"></div>
    <div class="product-form">
		<? $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>
		<?= $this->render('../_forms/_geo', ['form' => $form, 'model' => $model]); ?>
		<?= Html::submitButton('Обновить', ['class' => 'btn-main']); ?>
		<? ActiveForm::end(); ?>
    </div>
</section>
<div class="clearfix"></div>
