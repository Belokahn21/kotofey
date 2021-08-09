<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\GridView;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use app\modules\seo\models\tools\Title;
use app\modules\vendors\models\entity\Vendor;
use app\modules\catalog\models\entity\Product;
use app\modules\catalog\models\entity\ProductCategory;
use app\models\tool\parser\providers\SibagroTrade;
use app\modules\catalog\models\helpers\ProductHelper;
use app\modules\catalog\widgets\StockOut\StockOutWidget;
use app\modules\catalog\widgets\FillFromVendor\FillFromVendorWidget;

/* @var $this \yii\web\View
 * @var $model \app\modules\catalog\models\entity\ProductTransferHistory
 * @var $orders \app\modules\order\models\entity\Order[]
 * @var $products Product[]
 * @var $dataProvider \yii\data\ActiveDataProvider
 * @var $searchModel \app\modules\catalog\models\search\ProductTransferHistorySearch
 */

$this->title = Title::show($model->reason);
?>
    <div class="title-group">
        <h1><?= $model->reason; ?></h1>
        <?= Html::a("Удалить", Url::to(['delete', 'id' => $model->id]), ['class' => 'btn-main']) ?>
    </div>
<?php $form = ActiveForm::begin([
    'enableAjaxValidation' => true,
    'options' => ['enctype' => 'multipart/form-data']
]); ?>
<?= $this->render('_form', [
    'model' => $model,
    'form' => $form,
]) ?>
<?= Html::submitButton('Обновить', ['class' => 'btn-main']) ?>
<?php ActiveForm::end(); ?>