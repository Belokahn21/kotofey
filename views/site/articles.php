<?php
/* @var $this yii\web\View */

use app\models\tool\seo\Title;
use app\models\entity\Category;
use yii\widgets\ActiveForm;
use yii\helpers\Html;
use app\models\tool\System;
use app\widgets\reviews\Reviews;

$this->params['breadcrumbs'][] = ['label' => 'Новости', 'url' => ['/news/']];
$this->title = Title::showTitle("Статьи");
?>

<section class="articles">
    <h1 class="articles__title">Статьи</h1>
    <div class="article-list">
<?php /* @var $new \app\models\entity\News */ ?>
<?php foreach ($news as $new): ?>
            <article class="article">
                <a href="<?=$new->detailurl?>" class="special-font">
                    <div class="article-image-wrap">
                        <img src="/web/upload/<?= $new->preview_image;?>" title="<?= $new->title; ?>" alt="<?= $new->title; ?>">
                    </div>
                    <div class="article-title-wrap">
                        <h2 class="article__title"><?= $new->title; ?></h2>
                    </div>
                </a>
            </article>
<?php endforeach; ?>
    </div>
</section>
