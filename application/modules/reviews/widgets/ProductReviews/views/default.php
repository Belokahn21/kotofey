<?php
/* @var $models \app\modules\reviews\models\entity\Reviews[] */
?>


<?php if ($models): ?>

    <div class="product-reviews">
        <?php foreach ($models as $model): ?>
            <div class="product-reviews-card">
                <div class="product-reviews-card__group">
                    <div class="product-reviews-card__author">
                        <?= $model->author->email; ?>
                    </div>
                    <div class="product-reviews-card__rate">
                        <div id="half-stars-example">
                            <div class="rating-group">
                                <input class="rating__input rating__input--none" checked name="rating2" id="rating2-0" value="0" type="radio">
                                <label aria-label="0 stars" class="rating__label" for="rating2-0">&nbsp;</label>

                                <?php if ($model->rate): ?>
                                    <?php for ($i = 1; $i <= 10; $i++): ?>
                                        <?php $realRate = $i / 2; ?>
                                        <?php if ($i % 2 == 0): ?>
                                            <label aria-label="<?= $realRate; ?> star" class="rating__label" for="rating2-<?= $realRate; ?>"><i class="rating__icon rating__icon--star fa fa-star"></i></label>
                                            <input class="rating__input" name="rating2" id="rating2-<?= $realRate; ?>" value="<?= $realRate; ?>" type="radio">
                                        <?php else: ?>
                                            <label aria-label="<?= $realRate; ?> stars" class="rating__label rating__label--half" for="rating2-<?= $realRate; ?>"><i class="rating__icon rating__icon--star fa fa-star-half"></i></label>
                                            <input class="rating__input" name="rating2" id="rating2-<?= $realRate; ?>" value="<?= $realRate; ?>" type="radio">
                                        <?php endif; ?>
                                    <?php endfor; ?>
                                <?php endif; ?>
                            </div>
                        </div>
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
