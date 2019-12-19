<?php

namespace app\models\tool;


use yii\helpers\Inflector;

class Text
{
	public static function toTraslit($word)
	{
		return Inflector::transliterate($word);
	}

	public static function existCyrilic($text)
	{
		return preg_match('/[А-Яа-яЁё]/u', $text);
	}
}