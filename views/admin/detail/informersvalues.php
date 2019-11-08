<?

use app\models\tool\seo\Title;
use yii\widgets\ActiveForm;
use yii\helpers\Html;
use app\models\entity\Informers;
use yii\helpers\ArrayHelper;

/* @var $this \yii\web\View */
$this->title = Title::showTitle($model->value); ?>
<section>
    <h1 class="title">Значение справочника: <?= $model->value; ?></h1>
    <?= Html::a("Назад", '/admin/informers-values/', ['class' => 'btn-back']) ?>
    <? $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>
    <?= $this->render('../_forms/_informers-values', [
        'form' => $form,
        'model' => $model,
    ]) ?>
    <?= Html::submitButton('Обновить'); ?>
    <? ActiveForm::end(); ?>
</section>