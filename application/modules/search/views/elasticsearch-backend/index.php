<?php

use yii\helpers\Html;
use yii\helpers\Url;
use app\modules\seo\models\tools\Title;

/* @var $this \yii\web\View
 * @var $model \app\modules\catalog\models\entity\Product
 * @var $properties \app\modules\catalog\models\entity\Properties[]
 * @var $modelDelivery \app\modules\catalog\models\entity\ProductOrder
 * @var $stocks \app\modules\stock\models\entity\Stocks[]
 * @var $compositions \app\modules\catalog\models\entity\Composition[]
 */

$this->title = Title::show('Elasticsearch элементы');
?>
<div class="title-group">
    <h1>Elasticsearch элементы</h1>
    <?= Html::a('Обновить индекс', Url::to(['/admin/search/elasticsearch-backend/re-index']), ['class' => 'btn-main']); ?>
</div>
