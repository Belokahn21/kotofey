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
        <div class="site-settings-list-wrap">
            <ul class="site-settings-list">
                <? foreach ($paramsList as $param): ?>
                    <li class="site-settings-list-element">
                        <div class="site-settings-list-element-block-name"><?= $param->name; ?></div>
                        <div class="site-settings-list-element-block-value"><?= $param->value; ?></div>
                        <div class="site-settings-list-element-block-code"><?= $param->code; ?></div>
                        <div class="site-settings-list-element-block-type"><?= SiteTypeSettings::findOne(['code' => $param->type])->name; ?></div>
                        <div class="site-settings-list-element-block-control">
                            <a href="/admin/settings/<?= $param->id; ?>/"><i class="fas fa-pencil-alt"></i></a>
                            <a href="/admin/settings/?action=delete&id=<?=$param->id;?>">
                                <i class="fas fa-trash-alt"></i>
                            </a>
                        </div>
                    </li>
                <? endforeach; ?>
            </ul>
        </div>
    </div>
</section>