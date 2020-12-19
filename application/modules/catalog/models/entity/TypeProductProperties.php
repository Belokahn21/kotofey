<?php

namespace app\modules\catalog\models\entity;


class TypeProductProperties
{
    const TYPE_TEXT = 0;
    const TYPE_INFORMER = 1;

    public static function getInstance()
    {
        return new TypeProductProperties();
    }

    public function listType()
    {
        return [self::TYPE_TEXT => "Текст", self::TYPE_INFORMER => "Справочник"];
    }
}