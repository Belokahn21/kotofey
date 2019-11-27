<?php

namespace app\models\tool\parser\providers;


use app\models\tool\parser\CatalogInfo;

class Provider implements ProviderInterface
{
    public function info($url)
    {
        $page = file_get_contents($url);

        $product = new CatalogInfo();
        $product->setName('');

    }
}