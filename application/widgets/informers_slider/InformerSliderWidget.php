<?php

namespace app\widgets\informers_slider;


use app\models\entity\InformersValues;
use yii\base\Widget;

class InformerSliderWidget extends Widget
{
    public $template = 'default';

    public function run()
    {
//        $providers = InformersValues::find()->where(['active' => true, 'informer_id' => 1])->orderBy(['sort' => SORT_DESC])->all();
        $providers = InformersValues::find()->where(['active' => true, 'informer_id' => 1])->orderBy(['sort' => SORT_DESC]);
        return $this->render($this->template, [
            'providers' => $providers
        ]);
    }
}