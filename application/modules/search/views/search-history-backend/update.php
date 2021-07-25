<?php

/* @var $this \yii\web\View */
/* @var $model \app\modules\search\models\entity\SearchQuery */

/* @var $other_models \app\modules\search\models\entity\SearchQuery[] */

use yii\helpers\Html;
use yii\helpers\Url;

$this->title = \app\modules\seo\models\tools\Title::show('Поисковой запрос: ' . $model->text);

?>
<div class="title-group">
    <h1>Информация по IP запросам</h1>
    <?= Html::a('Назад', Url::to(['index']), ['class' => 'btn-main']); ?>
</div>
<?php if ($other_models): ?>
    <?php foreach ($other_models as $other_model): ?>
        <?= date('d.m.Y', $other_model->created_at); ?>/<?= $other_model->text; ?>/<?= $other_model->ip; ?>/<span class="green"><?= $model->count; ?></span>
        <hr>
    <?php endforeach; ?>
<?php endif; ?>
