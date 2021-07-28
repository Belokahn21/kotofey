<?php

namespace app\modules\delivery\models\service\delivery\response;


use app\modules\site\models\tools\Debug;
use yii\helpers\ArrayHelper;

class CdekResponse implements IResponse
{
    private $data;

    public function __construct($data)
    {
        $this->data = $data;
    }

    public function getFulInfo()
    {
        return [
            'total' => $this->getTotal()
        ];
    }

    public function getTotal()
    {
        return ArrayHelper::getValue($this->data, 'total_sum');
    }

    public function getDate()
    {
    }
}