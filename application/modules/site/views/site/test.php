<?php

use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use app\modules\marketplace\models\api\OzonApi;

$category_id = Yii::$app->request->post('category_id');
?>

<?= Html::beginForm(); ?>
<?= Html::input('text', 'category_id', $category_id); ?>
<?= Html::submitButton('Получить') ?>
<?= Html::endForm(); ?>


<?php

if ($category_id) {
    $ozon = new OzonApi();
//\app\modules\site\models\tools\Debug::p($ozon->categoryTree(\yii\helpers\ArrayHelper::getValue(Yii::$app->request->post(), 'category_id', 0)));
    $_data = $ozon->listCategoryCharacteristic([
        $category_id
    ]);

    $attributes = ArrayHelper::getValue($_data, '0.attributes');

    foreach ($attributes as $attribute) {
        if ($attribute['is_required']) {
            \app\modules\site\models\tools\Debug::p($attribute);
            \app\modules\site\models\tools\Debug::p($ozon->attributeValues($attribute['id'], $category_id));
        }
    }
}
?>
