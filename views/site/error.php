<?
/* @var $this yii\web\View */
/* @var $name string */
/* @var $message string */

/* @var $exception Exception */

use yii\helpers\Html;
use app\widgets\notify_about_error\NotifyAboutError;

$this->title = $name;
?>
<div class="site-error">

    <h1><?= Html::encode($this->title) ?></h1>

    <div class="alert alert-danger">
        <?= nl2br(Html::encode($message)) ?>
    </div>


    <?= NotifyAboutError::widget(); ?>
</div>