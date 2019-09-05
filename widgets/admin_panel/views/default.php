<?

use app\models\entity\Category;
use app\models\entity\PagesCategory;
use yii\widgets\ActiveForm;
use yii\helpers\Html;
use app\models\entity\User;
use app\models\entity\Product;
use app\models\entity\Order;
use yii\bootstrap\Modal;
use yii\helpers\ArrayHelper;
use app\models\entity\Pages;
use mihaildev\ckeditor\CKEditor;

/* @var string $slug */
/* @var Product $model */
/* @var \app\models\entity\Category $categories */
?>
<div class="admin-panel-wrap">
    <ul class="admin-panel-list">
        <li class="admin-panel-list__item link"><a href="/">Сайт</a></li>
        <li class="admin-panel-list__item link"><a href="/admin/">Панель управления</a></li>
        <li class="admin-panel-list__item link"><a href="/admin/order/">Зказы <span class="actual-count"><?= Order::find()->count(); ?></span></a></li>
        <li class="admin-panel-list__item link"><a href="/admin/catalog/">Товары <span class="actual-count"><?= Product::find()->count(); ?></span></a></li>
        <li class="admin-panel-list__item"><a href="#"><span onclick="copyText(document.getElementsByClassName('admin-panel-list__item-ts')[0]);">TS: <span class="admin-panel-list__item-ts"><?= time(); ?></span></span></a></li>
        <li class="admin-panel-list__item"><a href="#">Сегодня: <?= date('d.m.Y'); ?></a></li>
        <? if (User::isRole('Developer')): ?>
            <li class="admin-panel-list__item">
                <a>
                    <?
                    if (Yii::$app->controller->action->id === "product") {
                        $product = Product::findBySlug($slug);
                        if ($product) {
                            Modal::begin([
                                'header' => '<h2 class="edit-product-modal__title">Редактировать: ' . $product->name . '</h2>',
                                'footer' => '<a class="edit-product-modal__link-to-admin" href="/admin/catalog/'.$product->id.'/">Перейти в админ-панель</a>',
                                'toggleButton' => ['label' => 'Редактировать', 'class' => 'button-edit-product'],
                            ]); ?>
                            <div class="edit-product-modal">
                                <? $form = ActiveForm::begin(); ?>
                                <?= $form->field($model, 'name')->textInput(); ?>
                                <?= $form->field($model, 'description')->textarea(['rows' => 7]); ?>
                                <?= $form->field($model, 'category')->dropDownList(ArrayHelper::map(Category::find()->all(), 'id',
                                    'name'), ['prompt' => 'Выбрать категорию']); ?>
                                <?= $form->field($model, 'price')->textInput(); ?>
                                <?= $form->field($model, 'purchase')->textInput(); ?>
                                <?= $form->field($model, 'count')->textInput(); ?>
                                <?= $form->field($model, 'vitrine')->radioList(["Нет", "Да"]); ?>
                                <?= $form->field($model, 'seo_description')->textarea(); ?>
                                <?= $form->field($model, 'seo_keywords')->textInput(); ?>
                                <?= Html::submitButton('Обновить', ['class' => 'btn-main-admin']) ?>
                                <? ActiveForm::end(); ?>
                            </div>
                            <?
                            Modal::end();
                        }
                        echo "";
                    }elseif(Yii::$app->controller->action->id === "article"){
                        $article = Pages::findBySlug($slug);
                        if ($article) {
                            Modal::begin([
                                'header' => '<h2 class="edit-product-modal__title">Редактировать: ' . $article->title . '</h2>',
                                'toggleButton' => ['label' => 'Редактировать', 'class' => 'button-edit-product'],
                            ]); ?>
                            <div class="edit-product-modal">
                                <? $form = ActiveForm::begin(); ?>

                                <?= $form->field($model, 'title')->textInput(); ?>
                                <?= $form->field($model, 'preview')->widget(CKEditor::className(), [
                                    'editorOptions' => [
                                        'preset' => 'full',
                                        'inline' => false,
                                    ],
                                ]); ?>
                                <?= $form->field($model, 'category')->dropDownList(ArrayHelper::map(PagesCategory::find()->all(), 'id', 'name'), ['prompt' => 'Выбрать рубрику']); ?>
                                <?= $form->field($model, 'detail')->widget(CKEditor::className(), [
                                    'editorOptions' => [
                                        'preset' => 'full',
                                        'inline' => false,
                                    ],
                                ]); ?>
                                <?= $form->field($model, 'seo_description')->textarea(); ?>
                                <?= $form->field($model, 'seo_keywords')->textInput(); ?>

                                <?=Html::submitButton('Обновить', ['class' => 'btn-main-admin'])?>
                                <? ActiveForm::end(); ?>
                            </div>
                            <?
                            Modal::end();
                        }
                    }
                    ?>
                </a>
            </li>
        <? endif; ?>
    </ul>
    <div class="clearfix"></div>
</div>
