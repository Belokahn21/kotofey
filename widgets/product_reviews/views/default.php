<?php

use yii\widgets\ActiveForm;
use yii\helpers\Html;

/* @var $reviews \app\models\entity\ProductReviews[] */
/* @var $model \app\models\entity\ProductReviews */
?>
<div class="product-attributes__title">Отзывы покупателей</div>
<div class="product-review-wrap">
    <?php if ($reviews): ?>
        <ul class="review-list">
            <?php foreach ($reviews as $review): ?>
                <li class="review-item">
                    <div class="review-item__author-wrap">
                        <div class="review-item__image-wrap">
                            <?php if ($review->user_id): ?>
                                <img class="review-item__image" src="/upload/avatar/<?= $review->user->avatar; ?>">
                            <?php else: ?>
                                <img class="review-item__image" src="/upload/images/no-image.png">
                            <?php endif; ?>
                        </div>
                        <div>
                            <?php if ($review->author): ?>
                                <div class="review-item__author"><?= $review->author; ?></div>
                            <?php else: ?>
                                <div class="review-item__author"><?= $review->user->name; ?></div>
                            <?php endif; ?>
                            <!--                        <div class="review-item__verify">Товар был куплен</div>-->
                        </div>
                    </div>
                    <div class="review-item__description">
                        <?= $review->text; ?>
                    </div>
                </li>
            <?php endforeach; ?>
        </ul>
    <?php else: ?>
        <div class="review-disable">
            Никто не оставил отзывов
        </div>
    <?php endif; ?>

    <?php if (Yii::$app->user->isGuest): ?>
        <div class="review-disable">
            Чтобы оставить отзыв войдите на сайт
        </div>
    <?php else: ?>
        <div class="review-form-wrap">
            <?php $form = ActiveForm::begin(['options' => ['class' => 'review-form']]); ?>
            <div class="review-form__element">
                <?= $form->field($model, 'author')->textInput(['placeholder' => 'Представьтесь'])->label(false); ?>
            </div>
            <div class="review-form__element">
                <?= $form->field($model, 'rate')->dropDownList([
                    '1' => 1,
                    '2' => 2,
                    '3' => 3,
                    '4' => 4,
                    '5' => 5,
                ], ['prompt' => 'Выбрать оценку'])->label(false); ?>
            </div>
            <div class="review-form__element">
                <?= $form->field($model, 'text')->textarea(['placeholder' => 'Ваш отзыв'])->label(false); ?>
            </div>
            <div class="review-form__element">
                <button class="btn-main">Отправить</button>
            </div>
            <?php ActiveForm::end(); ?>
        </div>
    <?php endif; ?>
</div>