<?

use yii\helpers\ArrayHelper;
use app\models\entity\PagesCategory;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\models\tool\seo\Title;
use yii\grid\GridView;
use yii\helpers\Url;
use mihaildev\ckeditor\CKEditor;

/* @var $model \app\models\entity\Pages */

$this->title = Title::showTitle("Страницы");
?>
<section>
    <h1 class="title">Страницы</h1>
    <div class="product-form">
        <? $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>
        <div class="tabs-container">
            <ul class="tabs">
                <li class="tab-link current" data-tab="tab-1">Основное</li>
                <li class="tab-link" data-tab="tab-2">Краткий обзор</li>
                <li class="tab-link" data-tab="tab-3">Дательное описание</li>
                <li class="tab-link" data-tab="tab-4">SEO</li>
            </ul>

            <div id="tab-1" class="tab-content current">
                <?= $form->field($model, 'title'); ?>
                <?= $form->field($model, 'category')->dropDownList(ArrayHelper::map(PagesCategory::find()->all(), 'id',
                    'name'), ['prompt' => 'Выбрать рубрику']); ?>
            </div>
            <div id="tab-2" class="tab-content">
                <?= $form->field($model, 'preview_image_file')->fileInput(); ?>
                <?= $form->field($model, 'preview')->widget(CKEditor::className(), [
                    'editorOptions' => [
                        'preset' => 'full',
                        'inline' => false,
                    ],
                ]); ?>
            </div>
            <div id="tab-3" class="tab-content">
                <?= $form->field($model, 'detail_image_file')->fileInput(); ?>
                <?= $form->field($model, 'detail')->widget(CKEditor::className(), [
                    'editorOptions' => [
                        'preset' => 'full',
                        'inline' => false,
                    ],
                ]); ?>
            </div>
            <div id="tab-4" class="tab-content">
                <?= $form->field($model, 'seo_keywords')->textInput(); ?>
                <?= $form->field($model, 'seo_description')->textarea(); ?>
            </div>
            <?= Html::submitButton('Добавить'); ?>
            <? ActiveForm::end(); ?>
        </div>
</section>
<div class="clearfix"></div>
<h2>Список страницы</h2>
<?= GridView::widget([
    'dataProvider' => $dataProvider,
    'filterModel' => $searchModel,
    'emptyText' => 'Страницы отсутствуют',
    'columns' => [
        [
            'attribute' => 'id',
        ],
        [
            'attribute' => 'title',
            'format' => 'raw',
            'value' => function ($model) {
                return Html::a($model->title, "/admin/pages/" . $model->id . "/");
            }
        ],
        [
            'attribute' => 'created_at',
            'value' => function ($model) {
                return date("d.m.Y", $model->created_at);
            }
        ],
        [
            'attribute' => 'category',
            'format' => 'raw',
            'value' => function ($model) {
                return Html::a(PagesCategory::findOne($model->category)->name, "/admin/pagesections/" . $model->category . "/", ['target' => '_blank']);
            }
        ],
        [
            'attribute' => 'seo_optimized',
            'label' => 'Сео оптимизация',
            'format' => 'raw',
            'value' => function ($model) {

                $fullComplete = 3;
                $countStepsTrue = 0;
                $reasons = [];

                /* @var @model Pages */
                if (count(explode(",", $model->seo_keywords)) < 8) {
                    $reasons[] = "Количество ключей меньше 8 штук";
                } else {
                    $countStepsTrue++;
                }

                if (strlen($model->seo_keywords) < 120) {
                    $reasons[] = "Количество символов SEO описания меньше 120 символа";
                } else {
                    $countStepsTrue++;
                }


                if ($countStepsTrue >= $fullComplete) {
                    return '<i class="fas fa-check-circle" style="color: green;"></i>';
                }

                if ($countStepsTrue < $fullComplete) {
                    return '<i class="fas fa-exclamation-triangle" style="color: orange;" title="' . implode("\n",
                            $reasons) . '"></i>';
                }
            }
        ],
        [
            'class' => 'yii\grid\ActionColumn',
            'buttons' => [
                'view' => function ($url, $model, $key) {
//                    return Html::img('/images/eye.png', ['class' => 'grid-view-img feedback-view']);
                },
                'update' => function ($url, $model, $key) {
                    return Html::a('<i class="far fa-eye"></i>', Url::to(["/admin/pages/$key"]));
                },
                'delete' => function ($url, $model, $key) {
                    return Html::a('<i class="fas fa-trash-alt"></i>',
                        Url::to(["/admin/pages/", 'id' => $key, 'action' => 'delete']));
                },
            ]
        ],
    ],
]); ?>
