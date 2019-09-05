<?

use app\models\tool\seo\Title;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use app\models\entity\SiteTypeSettings;

$this->title = Title::showTitle("Настройки сайта");

/* @var $paramsList \app\models\entity\SiteSettings */
/* @var $model \app\models\entity\SiteSettings */

?>
<section class="site-settings">
    <h1 class="title">Настройки сайта</h1>
    <?=Html::a('Назад', '/admin/settings/');?>
    <div class="site-settings-wrap">
        <div class="site-settings-form">
            <? $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>
            <? if(!empty($_GET['type'])){ $model->type = $_GET['type']; } ?>
            <?= $form->field($model, 'type')->dropDownList(ArrayHelper::map(SiteTypeSettings::find()->all(), 'code', 'name'), ['prompt' => 'Тип параметра', 'id' => 'select-type-settings']); ?>
            <?= $form->field($model, 'name'); ?>
            <?= $form->field($model, 'code'); ?>
            <? if ($model->type == 'file'): ?>
                <?= $form->field($model, 'file')->fileInput(); ?>
            <? else: ?>
                <?= $form->field($model, 'value'); ?>
            <? endif; ?>
            <?= Html::submitButton("Прменить", ['class' => 'btn-main']) ?>
            <? ActiveForm::end(); ?>
        </div>
    </div>
</section>