<?

use app\models\tool\seo\Title;
use yii\widgets\ActiveForm;
use yii\helpers\Html;
use app\models\entity\Informers;
use yii\helpers\ArrayHelper;

$this->title = Title::showTitle($model->value); ?>
<section>
    <h1 class="title"><?= $model->value; ?></h1>
    <br />
    <?= Html::a("Назад", '/admin/informersvalues/', ['class' => 'btn-back']) ?>
    <? $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>
    <div class="tabs-container">
        <ul class="tabs">
            <li class="tab-link current" data-tab="tab-1">Основное</li>
        </ul>

        <div id="tab-1" class="tab-content current">
            <?= $form->field($model, 'informer_id')->dropDownList(ArrayHelper::map(Informers::find()->all(), 'id',
                'name')) ?>
            <?= $form->field($model, 'value')->textInput() ?>
            <?= $form->field($model, 'description')->textarea(); ?>
        </div>

    </div>
    <?= Html::submitButton('Обновить'); ?>
    <? ActiveForm::end(); ?>
</section>