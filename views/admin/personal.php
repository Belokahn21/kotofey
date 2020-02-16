<?php
/* @var $this \yii\web\View */

use yii\widgets\ActiveForm;
use yii\helpers\Html;

$this->title = \app\models\tool\seo\Title::showTitle('Сотрудники');

?>
    <h1>Сотрудники</h1>

<?php if ($users): ?>
    <uL>

        <?php foreach ($users as $user): ?>
            <li><?= $user->display; ?></li>
        <?php endforeach; ?>
    </uL>
<?php endif; ?>