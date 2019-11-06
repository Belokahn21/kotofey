<?

use app\models\tool\seo\Title;
use yii\widgets\ActiveForm;
use yii\helpers\Html;
use app\models\entity\Geo;
use app\models\entity\GeoType;
use yii\helpers\ArrayHelper;

/* @var $model \app\models\entity\Stocks */

?>
<? $this->title = Title::showTitle("Склады"); ?>
<section>
    <h1 class="title">Склад: <?= $model->name; ?></h1>
    <?= Html::a("Назад", '/admin/stocks/', ['class' => 'btn-back']) ?>
    <? $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>
    <div class="tabs-container">
        <ul class="tabs">
            <li class="tab-link current" data-tab="tab-1">Основное</li>
        </ul>

        <div id="tab-1" class="tab-content current">
            <?= $form->field($model, 'name'); ?>
            <?= $form->field($model, 'address'); ?>
			<?= $form->field($model, 'sort')->textInput(['value' => 500]); ?>
			<?= $form->field($model, 'active')->checkbox(); ?>
			<?= $form->field($model, 'city_id')->dropDownList(ArrayHelper::map(Geo::find()->where(['type_id'=>GeoType::findOne(['slug'=>'city'])])->all(), 'id', 'name'), ['prompt'=>'Выбрать город']); ?>
            <hr/>
            <div>
                <h1>Время работы</h1>
                <div style="display: flex">
                    <div style="display:flex;">
                        <? $model->hour_start = date("G", $model->time_start) ?>
                        <?= $form->field($model, 'hour_start')->dropDownList(range(0, 23)); ?>
                        <? $model->hour_start = intval(date('i', $model->time_start)); ?>
                        <?= $form->field($model, 'minute_start')->dropDownList(range(0, 59)); ?>
                    </div>
                    <div style="display:flex; margin: 0 0 0 10%;">
                        <? $model->hour_end = date("G", $model->time_end) ?>
                        <?= $form->field($model, 'hour_end')->dropDownList(range(0, 23)); ?>

                        <? $model->minute_end = intval(date('i', $model->time_end)); ?>
                        <?= $form->field($model, 'minute_end')->dropDownList(range(0, 59)); ?>
                    </div>
                </div>
            </div>
        </div>

    </div>
    <?= Html::submitButton('Обновить'); ?>
    <? ActiveForm::end(); ?>
</section>