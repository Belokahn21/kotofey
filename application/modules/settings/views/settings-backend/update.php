<?php

use app\models\tool\seo\Title;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use app\modules\site_settings\models\entity\SiteTypeSettings;

$this->title = Title::show("Настройки сайта");

/* @var $paramsList \app\modules\site_settings\models\entity\SiteSettings */
/* @var $model \app\modules\site_settings\models\entity\SiteSettings */

?>
<section class="site-settings">
    <h1 class="title">Настройки сайта</h1>
    <?= Html::a('Назад', '/admin/settings/'); ?>
    <div class="site-settings-wrap">
        <div class="site-settings-form">
            <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>
            <?= $this->render('_form', [
                'form' => $form,
                'model' => $model
            ]); ?>
            <?= Html::submitButton("Прменить", ['class' => 'btn-main']) ?>
            <?php ActiveForm::end(); ?>
        </div>
    </div>
</section>