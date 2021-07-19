<?php
/* @var $this \yii\web\View */
/* @var $model \app\modules\search\models\entity\SearchQuery */
/* @var $other_models \app\modules\search\models\entity\SearchQuery[] */

$this->title = \app\modules\seo\models\tools\Title::show('Поисковой запрос: ' . $model->text);

?>

<?php if ($other_models): ?>
    <?php foreach ($other_models as $other_model): ?>
    <?php endforeach; ?>
<?php endif; ?>
