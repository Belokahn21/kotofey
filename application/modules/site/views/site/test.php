<?php

echo \app\modules\content\widgets\informers_slider\model\helper\FilterBuildHelper::buildSearchQuery(\app\modules\catalog\models\entity\PropertiesVariants::findOne(1));

echo \yii\helpers\Html::a('asd','?'.\app\modules\content\widgets\informers_slider\model\helper\FilterBuildHelper::buildSearchQuery(\app\modules\catalog\models\entity\PropertiesVariants::findOne(1)));