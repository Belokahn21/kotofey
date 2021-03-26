<?php

/* @var $this \yii\web\View
 * @var $content string
 */

use yii\helpers\Html;
use app\assets\AdminAsset;
use app\modules\user\models\entity\User;
use app\widgets\notification\Alert;

AdminAsset::register($this);
$this->beginPage();
$user = User::findOne(Yii::$app->user->identity->id);
?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.3/css/all.css" integrity="sha384-UHRtZLI+pbxtHCWp1t77Bi1L4ZtiqrqD80Kn4Z8NTSRyMA2Fd33n5dQ8lWUE00s/" crossorigin="anonymous">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <script src="https://api-maps.yandex.ru/2.1/?apikey=<?= Yii::$app->params['yandex']['geocode']; ?>&lang=ru_RU" type="text/javascript"></script>
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body>
<?php $this->beginBody() ?>
<div class="page-container">
    <?= Alert::widget([
        'template' => 'backend'
    ]); ?>
    <div class="left-sidebar-react"></div>
    <div class="content">
        <?= $content; ?>
    </div>
</div>
<script src="/js/backend.js"></script>
<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
