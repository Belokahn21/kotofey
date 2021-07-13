<?php


namespace app\modules\catalog\widgets\CatalogSliders\Recomended;


use app\modules\catalog\models\entity\Offers;
use app\modules\catalog\models\entity\Properties;
use app\modules\catalog\models\entity\TypeProductProperties;
use app\modules\catalog\widgets\CatalogSliders\RenderSlider\RenderSliderWidget;
use app\modules\site\models\tools\Debug;
use yii\base\Widget;


/**
 * @var $product Offers
 * @var $property_id integer
 */
class RecomendedWidget extends Widget
{
    public $view = 'default';
    public $property_id;
    public $product;

    public function run()
    {
        if (empty($this->property_id)) return false;

        $listIdRelatedItems = [];
        foreach ($this->product->propsValues as $propsValue) {
            if ($propsValue->property_id == $this->property_id) $listIdRelatedItems[] = (int)$propsValue->value;
        }

        $models = \Yii::$app->cache->getOrSet('recomended:' . $this->product->id, function () use ($listIdRelatedItems) {
            return $models = Offers::find()->where(['in', 'id', $listIdRelatedItems])->all();
        });

        return RenderSliderWidget::widget([
            'models' => $models,
            'uniqKey' => $this->property_id . $this->product->id,
            'title' => 'Рекомендуемые товары'
        ]);
    }
}