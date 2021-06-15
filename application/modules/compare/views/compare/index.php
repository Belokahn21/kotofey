<?php

use yii\helpers\Json;
use app\modules\seo\models\tools\Title;
use app\modules\compare\models\helpers\CompareHelper;
use app\modules\catalog\models\helpers\ProductHelper;
use app\modules\catalog\models\helpers\PropertiesHelper;
use app\modules\catalog\models\helpers\ProductPropertiesValuesHelper;

/* @var $this \yii\web\View */
/* @var $models array */
/* @var $avail_properties array */

$this->title = Title::show("Сравните выбранные товары");

$this->params['breadcrumbs'][] = ['label' => 'Сравнение твоаров', 'url' => ['site/compare']];
?>
    <h1>Сравнение товаров</h1>
    <a class="btn-main" href="<?= \yii\helpers\Url::to(['compare/clean']) ?>">Очистить выбор</a>

    <div class="compare-list">
        <div class="compare-list__row">
            <div class="compare-list__col"></div>
            <?php foreach ($models as $product_id => $data): ?>
                <div class="compare-list__col compare-list__product">
                    <a class="compare-list__link" href="<?= $data['detail_link'] ?>">
                        <img class="compare-list__image" src="<?= $data['detail_image'] ?>">
                    </a>
                </div>
            <?php endforeach; ?>
        </div>

        <?php $props = []; ?>

        <?php foreach ($avail_properties as $property_id => $properties_data): ?>
            <?php foreach ($models as $product_id => $data): ?>
                <?php if ($value = PropertiesHelper::extractPropertyById($data['product'], $property_id)): ?>
                    <?php $props[$property_id][$product_id] = ProductPropertiesValuesHelper::getFinalValue($value); ?>
                <?php else: ?>
                    <?php $props[$property_id][$product_id] = '-'; ?>
                <?php endif; ?>

                <?php $props[$property_id]['is_ident'] = CompareHelper::findIdent($props[$property_id]); ?>

            <?php endforeach; ?>
        <?php endforeach; ?>

        <?php foreach ($avail_properties as $property_id => $properties_data): ?>
            <div class="compare-list__row <?= $props[$property_id]['is_ident'] === true ? 'is-ident' : ''; ?>">
                <div class="compare-list__col compare-list__property"><?= $properties_data['property']->name; ?></div>

                <?php foreach ($models as $product_id => $data): ?>
                    <div class="compare-list__col">
                        <?= $props[$property_id][$product_id]; ?>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endforeach; ?>
    </div>


<?php if (Yii::$app->user->id == 1): ?>
    <div class="compare-list compare-list-react"</div>
<?php endif; ?>