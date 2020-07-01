<?php

use app\models\helpers\OrderHelper;
use yii\helpers\StringHelper;
use app\models\tool\Backup;
use app\models\tool\Currency;
use app\models\tool\Price;
use app\models\tool\seo\Title;
use app\modules\order\models\entity\Order;
use app\widgets\todo\ToDoWidget;
use app\models\entity\User;
use app\models\entity\SearchQuery;
use app\models\tool\statistic\OrderStatistic;
use app\models\tool\statistic\ProductStatistic;
use app\models\entity\ProductSync;

/* @var $this yii\web\View
 * @var $last_search \app\models\entity\SearchQuery[]
 */

$this->title = Title::showTitle("Главная страница");
?>
<div class="statistic-wrap"></div>