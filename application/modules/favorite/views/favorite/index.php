<?php
/* @var $this yii\web\View */

use app\modules\seo\models\tools\Title;
use app\modules\site\models\tools\Price;
use app\modules\site\models\tools\Currency;
use app\modules\favorite\models\entity\Favorite;

$this->title = Title::show("Избранные товары");
$this->params['breadcrumbs'][] = ['label' => 'Избранные товары', 'url' => ['/favorite/']]; ?>
<h1 class="favorite__title">Избранные товары</h1>