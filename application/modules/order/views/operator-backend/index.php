<?php

use app\modules\seo\models\tools\Title;
use app\modules\user\models\helpers\UserHelper;
use app\modules\order\widgets\OperatorAdmin\OperatorAdminWidget;

/* @var $this \yii\web\View
 * @var $modelQuery \yii\db\ActiveQuery
 * @var $user \app\modules\user\models\entity\User
 */

$this->title = Title::show('Кабинет оператора');
?>
<?= OperatorAdminWidget::widget(); ?>
<h1>Добро пожаловать, <?= UserHelper::getFullName($user); ?></h1>
<ul>
    <li>Всего обработано заказов: <?= $modelQuery->count(); ?></li>
</ul>
