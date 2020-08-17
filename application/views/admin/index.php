<?php

use app\models\tool\seo\Title;
use app\modules\statistic\widgets\StatisticWidget;

/* @var $this yii\web\View
 * @var $last_search \app\modules\search\models\entity\SearchQuery[]
 */

$this->title = Title::showTitle("Главная страница");
?>
    <div class="statistic-wrap"></div>
<?= StatisticWidget::widget(); ?>