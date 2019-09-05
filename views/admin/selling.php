<?

use app\models\tool\seo\Title;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use app\models\entity\SiteTypeSettings;

$this->title = Title::showTitle("Продажи"); ?>
<h1 class="title">Продажи</h1>
<section>
    <? $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>
    <div class="tabs-container">
        <ul class="tabs">
            <li class="tab-link current" data-tab="tab-1">Основное</li>
            <li class="tab-link" data-tab="tab-2">Товары</li>
            <li class="tab-link" data-tab="tab-3">Пусто</li>
        </ul>

        <div id="tab-1" class="tab-content current">
            <?= $form->field($model, 'summ'); ?>
        </div>
        <div id="tab-2" class="tab-content">
        </div>
        <div id="tab-3" class="tab-content">
        </div>

    </div>
    <?= Html::submitButton('Добавить'); ?>
    <? ActiveForm:: end(); ?>
</section>