<?php

use yii\helpers\Html;

/* @var $images \app\models\entity\SlidersImages[] */
/* @var $use_carousel boolean */

?>
<?php if ($images): ?>
    <div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
        <ol class="carousel-indicators">
            <li data-target="#carouselExampleIndicators" data-slide-to="0" class="active"></li>
            <li data-target="#carouselExampleIndicators" data-slide-to="1"></li>
            <li data-target="#carouselExampleIndicators" data-slide-to="2"></li>
        </ol>
        <div class="carousel-inner">
			<?php $iterator = 1; ?>
			<?php foreach ($images as $image): ?>
                <div class="carousel-item <?= ($iterator == 1 ? 'active' : ''); ?>">
                    <img class="d-block w-100 h-100" src="/web/upload/<?= $image->image; ?>" alt="<?= $image->text; ?>">
                </div>
				<?php $iterator++; ?>
			<?php endforeach; ?>
        </div>
        <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="sr-only">Previous</span>
        </a>
        <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="sr-only">Next</span>
        </a>
    </div>
<?php endif; ?>
