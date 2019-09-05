<?
/* @var $this yii\web\View */

/* @var $article \app\models\entity\Pages */

use app\models\tool\seo\Title;
use app\models\entity\Category;
use yii\widgets\ActiveForm;
use yii\helpers\Html;
use app\models\tool\System;
use app\widgets\reviews\Reviews;

$this->params['breadcrumbs'][] = ['label' => 'Статьи', 'url' => ['/articles/']];
$this->params['breadcrumbs'][] = ['label' => $article->title, 'url' => [$article->detailurl]];
$this->title = Title::showTitle($article->title);
?>

<section class="article-detail">
    <h1 class="article-detail__title"><?= $article->title; ?></h1>
    <? if (!empty($article->detail_image)): ?>
        <img class="article-detail-image" src="<?= $article->detail_image; ?>" alt="<?= $article->title ?>" title="<?= $article->title; ?>">
    <? else: ?>
        <img class="article-detail-image" src="<?= $article->preview_image; ?>" alt="<?= $article->title ?>" title="<?= $article->title; ?>">
    <? endif; ?>
    <div class="article-detail-text">
        <?= $article->detail; ?>
    </div>
</section>
