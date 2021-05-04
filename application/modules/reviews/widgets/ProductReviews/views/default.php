<?php
/* @var $models \app\modules\reviews\models\entity\Reviews[] */
?>


<?php if ($models): ?>

    <div class="product-reviews">
        <?php foreach ($models as $model): ?>
            <div class="product-reviews-card">
                <div class="product-reviews-card__group __row">
                    <div class="product-reviews-card__author">
                        <?= $model->author->email; ?>
                    </div>
                    <div class="product-reviews-card__rate">
                        <?= $model->rate; ?>
                    </div>
                </div>

                <div class="product-reviews-card__line-text">
                    <div class="product-reviews-card__line-title">Приемущества</div>
                    <?= $model->pluses; ?>
                </div>
                <div class="product-reviews-card__line-text">
                    <div class="product-reviews-card__line-title">Недостатки</div>
                    <?= $model->minuses; ?>
                </div>
                <div class="product-reviews-card__line-text">
                    <div class="product-reviews-card__line-title">Отзыв</div>
                    <?= $model->text; ?>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
<?php else: ?>
    Отзывы отсуствуют
<?php endif; ?>
