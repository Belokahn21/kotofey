<?php

use app\models\tool\seo\Title;
use yii\widgets\ActiveForm;
use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;
use app\models\entity\Category;
use app\models\entity\InformersValues;
use app\models\entity\Stocks;
use app\models\entity\SiteSettings;


/* @var $model \app\models\entity\Product
 * @var $modelDelivery \app\models\entity\ProductOrder
 * @var $properties \app\models\entity\ProductProperties[]
 */

$this->title = Title::showTitle("Товары"); ?>
<section>
    <h1 class="title">Товары</h1>

    <div class="catalog-control">
		<?= Html::a("Экспорт товаров в YML", "?export=yml", ['class' => 'btn-main']); ?>

        <div class="pre-load-catalog-wrap">
            <input type="text" name="url" placeholder="Ссылка на подгрузку" class="pre-load-catalog">
            <svg width="20" height="30" class="backend-preloader hide">
                <rect width="10%" x="5%" rx="5%">
                    <animate attributeName="height" values="20%; 70%; 20%" dur="0.7s" repeatCount="indefinite"></animate>
                    <animate attributeName="y" values="40%; 15%; 40%" dur="0.7s" repeatCount="indefinite"></animate>
                </rect>

                <rect width="10%" x="25%" rx="5%">
                    <animate attributeName="height" values="20%; 70%; 20%" dur="0.7s" begin="0.15s" repeatCount="indefinite"></animate>
                    <animate attributeName="y" values="40%; 15%; 40%" dur="0.7s" begin="0.15s" repeatCount="indefinite"></animate>
                </rect>

                <rect width="10%" x="45%" rx="5%">
                    <animate attributeName="height" values="20%; 70%; 20%" dur="0.7s" begin="0.3s" repeatCount="indefinite"></animate>
                    <animate attributeName="y" values="40%; 15%; 40%" dur="0.7s" begin="0.3s" repeatCount="indefinite"></animate>
                </rect>

                <rect width="10%" x="65%" rx="5%">
                    <animate attributeName="height" values="20%; 70%; 20%" dur="0.7s" begin="0.45s" repeatCount="indefinite"></animate>
                    <animate attributeName="y" values="40%; 15%; 40%" dur="0.7s" begin="0.45s" repeatCount="indefinite"></animate>
                </rect>

                <rect width="10%" x="85%" rx="5%">
                    <animate attributeName="height" values="20%; 70%; 20%" dur="0.7s" begin="0.6s" repeatCount="indefinite"></animate>
                    <animate attributeName="y" values="40%; 15%; 40%" dur="0.7s" begin="0.6s" repeatCount="indefinite"></animate>
                </rect>
            </svg>
        </div>
    </div>
<?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>
	<?= $this->render('_forms/_catalog', [
		'model' => $model,
		'form' => $form,
		'modelDelivery' => $modelDelivery,
		'properties' => $properties
	]); ?>
	<?= Html::submitButton('Добавить', ['class' => 'btn-main']); ?>
<?php ActiveForm::end(); ?>
</section>
<div class="clearfix"></div>
<h2>Список товаров</h2>
<?= GridView::widget([
	'dataProvider' => $dataProvider,
	'filterModel' => $searchModel,
	'emptyText' => 'Товары отсутствуют',
	'columns' => [
		'id',
		'article',
		'code',
		[
			'attribute' => 'active',
			'format' => 'raw',
			'value' => function ($model) {
				if ($model->active == 1) {
					return Html::tag('div', 'Активен', ['style' => 'color: green;']);
				} else {
					return Html::tag('div', 'Неактивен', ['style' => 'color: red;']);
				}
			}
		],
		[
			'attribute' => 'name',
			'format' => 'raw',
			'value' => function ($model) {
				return Html::a($model->name, '/admin/catalog/' . $model->id . '/');
			}
		],
		[
			'attribute' => 'price',
			'format' => 'raw',
			'value' => function ($model) {
				if (!empty($model->purchase) && !empty($model->price)) {
					return sprintf("%s (%s%%)", $model->price, ceil(($model->price - $model->purchase) / $model->purchase * 100));
				}
				return $model->price;
			}
		],
		'purchase',
		[
			'attribute' => 'category',
			'format' => 'raw',
			'filter' => ArrayHelper::map((new Category())->categoryTree(), 'id', 'name'),
			'value' => function ($model) {
				$category = Category::findOne($model->category);
				if ($category) {
					return Html::a($category->name, '/admin/category/' . $model->id . '/', ['target' => '_blank']);
				}
				return "Без категории";
			}
		],
		'count',
		[
			'attribute' => 'image',
			'format' => 'raw',
			'value' => function ($model) {
				return Html::img('/web/upload/' . $model->image, ['width' => 70]);
			}
		],
		[
			'attribute' => 'created_at',
			'format' => ['date', 'dd.MM.YYYY'],
			'options' => ['width' => '200']
		],
		[
			'class' => 'yii\grid\ActionColumn',
			'buttons' => [
				'view' => function ($url, $model, $key) {
					return Html::a('<i class="fas fa-copy"></i>', "/admin/catalog/$key/?action=copy");
				},
				'update' => function ($url, $model, $key) {
					return Html::a('<i class="far fa-eye"></i>', Url::to(["/admin/catalog/$key"]));
				},
				'delete' => function ($url, $model, $key) {
					return Html::a('<i class="fas fa-trash-alt"></i>',
						Url::to(["/admin/catalog/", 'id' => $key, 'action' => 'delete']));
				},
			]
		],
	],
]); ?>