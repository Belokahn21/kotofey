<?php
/* @var $this yii\web\View */

/* @var $article \app\models\entity\News */

use app\models\tool\seo\Title;
use app\models\entity\Category;
use yii\widgets\ActiveForm;
use yii\helpers\Html;
use app\models\tool\System;
use app\widgets\reviews\Reviews;

$this->params['breadcrumbs'][] = ['label' => 'Новости', 'url' => ['/news/']];
$this->params['breadcrumbs'][] = ['label' => $article->title, 'url' => [$article->detailurl]];
$this->title = Title::showTitle($article->title);
?>

<section class="article-detail">
    <h1 class="article-detail__title"><?= $article->title; ?></h1>
<?php if (!empty($article->detail_image)): ?>
        <img class="article-detail-image" src="<?= $article->detail_image; ?>" alt="<?= $article->title ?>" title="<?= $article->title; ?>">
<?php else: ?>
        <img class="article-detail-image" src="<?= $article->preview_image; ?>" alt="<?= $article->title ?>" title="<?= $article->title; ?>">
<?php endif; ?>
    <div class="article-detail-text">
        <?= $article->detail; ?>
    </div>
</section>
