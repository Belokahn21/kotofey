<?

use yii\widgets\ActiveForm;
use yii\helpers\Html;

/* @var $model \app\models\entity\ProductReviews */
/* @var $product \app\models\entity\Product */

?>
<section class="reviews-product">
    <h1>Отзывы клиентов</h1>
    <div class="reviews-product-list">
        <? if (empty($reviews)): ?>
            Пока никто не оставил отзыв
        <? else: ?>
            <? foreach ($reviews as $review): ?>
                <div class="reviews-product-list__item">
                    <div class="reviews-product-list__item-author"><?= $review->user->name; ?></div>
                    <div class="reviews-product-list__item-date"><?= date("d.m.Y", $review->created_at); ?></div>
                    <div class="reviews-product-list__item-text"><?= $review->text; ?></div>
                </div>
            <? endforeach; ?>
        <? endif; ?>
    </div>
    <h2>Оставить отзыв</h2>
    <div class="reviews-product-form">
        <? if ($model->canCreateReview($product)): ?>
            <? $form = ActiveForm::begin(); ?>
            <?= $form->field($model, 'text')->textarea(); ?>
            <?= Html::submitButton('Добавить', ['class' => 'btn-main']) ?>
            <? ActiveForm::end(); ?>
        <? else: ?>
            <? if ($product->isCommented()): ?>
                Вы уже оставляли комментарии
            <? else: ?>
                Чтобы оставить отзыв к этому товару вы должны купить данный продукт. <?= Html::a('Узнать почему?',
                    "/faq/#new-comment"); ?>
            <? endif; ?>
        <? endif; ?>
    </div>
</section>
