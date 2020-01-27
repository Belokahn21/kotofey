<?php

use app\models\tool\seo\Title;
use yii\widgets\ActiveForm;
use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;
use app\models\entity\Category;
use app\models\entity\InformersValues;
use app\models\entity\Stocks;
use app\models\entity\SiteSettings;

/* @var \app\models\entity\Providers $model */
/* @var \yii\web\View $this */

$this->title = Title::showTitle("Поставщики"); ?>
<section>
    <h1 class="title">Поставщики</h1>
	<?= Html::a('Назад', ['admin/vendor-group'], ['class' => 'btn-main']) ?>
    <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>
    <?= $this->render('../_forms/_vendor-group', [
        'model' => $model,
        'form' => $form
    ]); ?>
    <?= Html::submitButton('Добавить', ['class' => 'btn-main']); ?>
    <?php ActiveForm::end(); ?>
</section>