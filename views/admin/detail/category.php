<?

use app\models\entity\Product;
use yii\widgets\ActiveForm;
use yii\helpers\Html;
use app\models\tool\seo\Title;
use yii\helpers\ArrayHelper;
use yii\grid\GridView;
use yii\helpers\Url;

$this->title = Title::showTitle("Раздел: " . $model->name); ?>
<section>
    <h1 class="title">Раздел: <?= $model->name; ?></h1>
    <?= Html::a("Назад", '/admin/category/', ['class' => 'btn-back']) ?>
    <? $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>
    <div class="tabs-container">
        <ul class="tabs">
            <li class="tab-link current" data-tab="tab-1">Основное</li>
            <li class="tab-link" data-tab="tab-2">SEO</li>
            <li class="tab-link" data-tab="tab-3">Галлерея</li>
        </ul>

        <div id="tab-1" class="tab-content current">
            <?= $form->field($model, 'name'); ?>
            <?= $form->field($model, 'parent')->dropDownList(ArrayHelper::map($categories, 'id', 'name'),
                ['prompt' => 'Родительская категория']); ?>
            <?= $form->field($model, 'sort'); ?>
        </div>
        <div id="tab-2" class="tab-content">
            <?= $form->field($model, 'seo_keywords'); ?>
            <?= $form->field($model, 'seo_description'); ?>
        </div>
        <div id="tab-3" class="tab-content">
            <?= Html::img($model->image, ['width' => '200']) ?>
            <?= $form->field($model, 'imageFile')->fileInput(); ?>
        </div>

    </div>
    <?= Html::submitButton('Обновить'); ?>
    <? ActiveForm:: end(); ?>
</section>