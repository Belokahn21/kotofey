<?php
/* @var $this yii\web\View */

use app\models\tool\seo\Title;
use app\models\tool\Price;
use app\models\tool\Currency;
use app\modules\favorite\models\entity\Favorite;

$this->title = Title::showTitle("Избранные товары");
$this->params['breadcrumbs'][] = ['label' => 'Избранные товары', 'url' => ['/favorite/']]; ?>
<h1 class="favorite__title">Избранные товары</h1>