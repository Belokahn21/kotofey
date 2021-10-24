<?php

use app\modules\seo\models\tools\Title;
use app\modules\statistic\widgets\StatisticWidget;
use app\modules\site\widgets\ModuleMenu\ModuleMenuWidget;

/* @var $this yii\web\View
 * @var $last_search \app\modules\search\models\entity\SearchQuery[]
 */

$this->title = Title::show("Главная страница");
?>
<?= StatisticWidget::widget(); ?>
<?php if (Yii::$app->user->id == 1): ?>
    <div id="todo-react"></div>
<?php endif; ?>
