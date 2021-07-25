<?php
/* @var $this \yii\web\View */
/* @var $model \app\modules\search\models\entity\SearchQuery */
/* @var $other_models \app\modules\search\models\entity\SearchQuery[] */

$this->title = \app\modules\seo\models\tools\Title::show('Поисковой запрос: ' . $model->text);

?>

<?php if ($other_models): ?>
    <?php foreach ($other_models as $other_model): ?>
        <?= date('d.m.Y', $other_model->created_at); ?>/<?= $other_model->text; ?>/<?= $other_model->ip; ?>
        <hr>
    <?php endforeach; ?>
<?php endif; ?>
