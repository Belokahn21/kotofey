<?

use yii\widgets\ActiveForm;
use yii\helpers\Html;
use app\models\tool\seo\Title;
use yii\bootstrap\Modal;
use app\models\tool\Policy;

/* @var $reviews \app\models\entity\SiteReviews */

$this->title = Title::showTitle("Отзывы");
$this->params['breadcrumbs'][] = ['label' => 'Отзывы', 'url' => ['/reviews/']];?>
<section class="site-more-reviews">
    <h1 class="site-more-reviews__title">Отзывы
        <? if (Yii::$app->user->isGuest): ?>
            <img src="/web/upload/images/good-review.png" class="site-more-reviews__image">
        <? else: ?>
            <div class="pulse" data-target='#new-reviews' data-toggle='modal'>
                <img src="/web/upload/images/good-review.png" class="site-more-reviews__image">
            </div>
        <? endif; ?>
    </h1>
    <? foreach ($reviews as $review): ?>
        <div class="site-more-reviews__item">
            <div class="site-more-reviews__avatar">
                <img src="<?= (!empty($review->user->avatar)) ? $review->user->avatar : "/web/upload/images/man.png"; ?>">
            </div>
            <div class="site-more-reviews__content">
                <h4 class="site-more-reviews__name"><?= $review->user->name; ?></h4>
                <?= $review->text; ?>
            </div>
            <div class="clearfix"></div>
        </div>
    <? endforeach; ?>
    <div class="clearfix"></div>
</section>
<?
Modal::begin([
    'header' => '<h2>Добавить отзыв</h2>',
    'id' => 'new-reviews',
    'footer' => Html::a('Политика обработки персональных данных', Policy::getPath()),
]);
?>

<? $form = ActiveForm::begin(); ?>
<?= $form->field($user, 'name')->textInput((!$user->name ?[]: ['readonly' => true])); ?>
<?= $form->field($model, 'text')->textarea(); ?>
<?= Html::submitButton('Добавить', ['class' => 'btn-main']); ?>
<? ActiveForm::end(); ?>

<? Modal::end(); ?>
