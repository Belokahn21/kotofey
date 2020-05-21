<?php

namespace app\models\tool\parser;


use app\models\tool\parser\providers\Lukas;
use app\models\tool\parser\providers\Purina;
use app\models\tool\parser\providers\SibagroTrade;

class ProviderFactory
{
    public static function getInstance()
    {
        return new ProviderFactory();
    }

    public function parse($url)
    {
        if ($this->compare('sat-altai.ru', $url)) {
            return new SibagroTrade();
        }
        if ($this->compare('lukasn.ru', $url)) {
            return new Lukas();
        }

        if ($this->compare('shop.purina.ru', $url) or count(explode('	', $url)) == 3) {
            return new Purina();
        }

        return false;
    }

    private function compare($key, $url)
    {
        $matches = array();
        preg_match('/' . $key . '/', $url, $matches, PREG_OFFSET_CAPTURE);

        if ($matches) {
            return true;
        }

        return false;
    }
}