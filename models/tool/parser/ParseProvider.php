<?php

namespace app\models\tool\parser;

use app\models\tool\parser\providers\ProviderInterface;

/**
 *
 * @var $provider ProviderInterface
 *
 * */
class ParseProvider
{
    private $url;
    private $provider;

    public function __construct($url)
    {
        $this->url = $url;
    }

    public function contract()
    {
        $this->provider = ProviderInfo::getInstance()->parse($this->url);
    }

    public function getInfo()
    {
        return $this->provider->info($this->url);
    }
}