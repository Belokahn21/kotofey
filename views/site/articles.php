<?
/* @var $this yii\web\View */

use app\models\tool\seo\Title;
use app\models\entity\Category;
use yii\widgets\ActiveForm;
use yii\helpers\Html;
use app\models\tool\System;
use app\widgets\reviews\Reviews;

$this->params['breadcrumbs'][] = ['label' => 'Статьи', 'url' => ['/articles/']];
$this->title = Title::showTitle("Статьи");
?>

<section class="articles">
    <h1 class="articles__title">Статьи</h1>
    <div class="article-list">
        <? /* @var $page \app\models\entity\Pages */ ?>
        <? foreach ($pages as $page): ?>
            <article class="article">
                <a href="<?=$page->detailurl?>" class="special-font">
                    <div class="article-image-wrap">
                        <img src="<?= $page->preview_image ?>" title="<?= $page->title; ?>" alt="<?= $page->title; ?>">
                    </div>
                    <div class="article-title-wrap">
                        <h2 class="article__title"><?= $page->title; ?></h2>
                    </div>
                </a>
            </article>
        <? endforeach; ?>
    </div>
</section>
