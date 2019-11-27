<?php

namespace app\models\tool\parser\providers;


interface ProviderInterface
{
    public function info($url);
}