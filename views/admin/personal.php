<?php
/* @var $this \yii\web\View */

/* @var $managers \app\models\entity\UserSeller[] */

use app\models\helpers\PersonalHelper;
use yii\helpers\Html;
use yii\helpers\Url;

$this->title = \app\models\tool\seo\Title::showTitle('Сотрудники');

?>
    <h1>Сотрудники</h1>

<?php if ($managers): ?>
    <uL>

		<?php foreach ($managers as $user): ?>
			<?php if (PersonalHelper::issetScore($user->id)): ?>
                <li><?= $user->display; ?></li>
			<?php else: ?>
                <li><?= $user->display; ?> <?= Html::a('<i class="fas fa-tools"></i>', Url::to(['admin/personal', 'action' => 'repair', 'user_id' => $user->id])); ?></li>
			<?php endif; ?>
		<?php endforeach; ?>
    </uL>
<?php endif; ?>