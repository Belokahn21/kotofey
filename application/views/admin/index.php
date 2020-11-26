<?php

use app\models\tool\seo\Title;
use app\modules\statistic\widgets\StatisticWidget;
use app\modules\site\widgets\ModuleMenu\ModuleMenuWidget;

/* @var $this yii\web\View
 * @var $last_search \app\modules\search\models\entity\SearchQuery[]
 */

$this->title = Title::showTitle("Главная страница");
?>
<?= StatisticWidget::widget(); ?>
<?= ModuleMenuWidget::widget(); ?>
<div id="todo-react"></div>
