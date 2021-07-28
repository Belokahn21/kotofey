<?php

namespace app\modules\delivery\models\service\delivery\response;

interface IResponse
{
    public function getTotal();

    public function getDate();
}