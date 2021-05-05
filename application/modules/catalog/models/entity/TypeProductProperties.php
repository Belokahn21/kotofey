<?php

namespace app\modules\catalog\models\entity;


class TypeProductProperties
{
    const TYPE_TEXT = 0;
    const TYPE_INFORMER = 1;
    const TYPE_CATALOG = 2;
    const TYPE_FILE = 3;

    public static function getInstance()
    {
        return new TypeProductProperties();
    }

    public function listType()
    {
        return [
            self::TYPE_TEXT => "Текст",
            self::TYPE_INFORMER => "Справочник",
            self::TYPE_CATALOG => "Товары",
            self::TYPE_FILE => "Файл"
        ];
    }
}