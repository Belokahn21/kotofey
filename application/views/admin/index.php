<?php

use app\modules\order\models\helpers\OrderHelper;
use yii\helpers\StringHelper;
use app\models\tool\Backup;
use app\models\tool\Currency;
use app\models\tool\Price;
use app\models\tool\seo\Title;
use app\modules\order\models\entity\Order;
use app\widgets\todo\ToDoWidget;
use app\modules\user\models\entity\User;
use app\modules\search\models\entity\SearchQuery;
use app\models\tool\statistic\OrderStatistic;
use app\models\tool\statistic\ProductStatistic;
use app\modules\catalog\models\entity\ProductSync;

/* @var $this yii\web\View
 * @var $last_search \app\modules\search\models\entity\SearchQuery[]
 */

$this->title = Title::showTitle("Главная страница");
?>
<div class="statistic-wrap"></div>