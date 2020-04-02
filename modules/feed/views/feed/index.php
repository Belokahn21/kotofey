<?php

use app\models\tool\seo\Title;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;

/* @var $searchProductModel \app\modules\feed\models\forms\SearchProductForm
 * @var $modifyProductModel \app\modules\feed\models\forms\ModifyProductForm
 * @var $products \yii\db\ActiveQuery
 */

$this->title = Title::showTitle("Поисковой контент");
?>
<h1>Поисковой контент</h1>

<div class="d-flex flex-row">
    <div class="w-50 px-1">
        <?php $searchProductForm = ActiveForm::begin() ?>
        <?= Html::submitButton('Найти', ['class' => 'btn-main']) ?>
        <nav>
            <div class="nav nav-tabs" id="nav-tab" role="tablist">
                <a class="nav-item nav-link active" id="nav-home-tab" data-toggle="tab" href="#nav-home" role="tab" aria-controls="nav-home" aria-selected="true">Основное</a>
            </div>
        </nav>
        <div class="tab-content" id="nav-tab-content-form">
            <div class="tab-pane fade show active" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab">

                <div class="form-element">
                    <?= $searchProductForm->field($searchProductModel, 'name')->textInput(['value' => $searchProductModel->name]); ?>
                </div>

                <div class="form-element">
                    <?= $searchProductForm->field($searchProductModel, 'feed')->textInput(['value' => $searchProductModel->feed]); ?>
                </div>

                <div>
                    <p>Найдено товаров: <?= $products->count(); ?></p>
                </div>
            </div>
        </div>
        <?php ActiveForm::end() ?>
    </div>

    <div class="w-50 px-1">
        <?php $modifyProductForm = ActiveForm::begin() ?>
        <?= Html::submitButton('Обновить', ['class' => 'btn-main']) ?>
        <nav>
            <div class="nav nav-tabs" id="nav-tab" role="tablist">
                <a class="nav-item nav-link active" id="nav-home-tab" data-toggle="tab" href="#nav-home" role="tab" aria-controls="nav-home" aria-selected="true">Основное</a>
            </div>
        </nav>
        <div class="tab-content" id="nav-tab-content-form">
            <div class="tab-pane fade show active" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab">
                <div class="form-element">
                    <?= $modifyProductForm->field($modifyProductModel, 'feed')->textInput(['value' => $modifyProductModel->feed]); ?>
                </div>
            </div>
        </div>
        <?php ActiveForm::end() ?>
    </div>
</div>

<?php if ($products instanceof \yii\db\ActiveQuery): ?>
    <ul class="feed-list">
        <?php foreach ($products->all() as $product): ?>
            <li class="feed-list__item">
                <div class="feed-list__id"><?= $product->id; ?></div>
                <div class="feed-list__group">
                    <div class="feed-list__name"><a href="<?= \yii\helpers\Url::to(['/admin/catalog', 'id' => $product->id]) ?>"><?= $product->name; ?></a></div>
                    <div class="feed-list__feed"><?= $product->feed; ?></div>
                </div>
            </li>
        <?php endforeach; ?>
    </ul>
<?php endif; ?>
