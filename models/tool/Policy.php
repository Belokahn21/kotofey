<?php
/**
 * Developer: Konstantin Vasin by PhpStorm
 * Company: Altasib
 * Time: 10:48
 */

namespace app\models\tool;


class Policy
{
    public static function getInstance()
    {
        return new Policy();
    }

    public function getPath()
    {
        return "/policy.docx";
    }
}