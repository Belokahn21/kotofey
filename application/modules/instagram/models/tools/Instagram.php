<?php

namespace app\modules\instagram\models\tools;


class Instagram
{
	const TOKEN = "IGQVJXZAGNxZA1ZAYOWVscDJHdzZAxLWlSeHhJeWNwX2ZAfMXdnTUtXYm9aWjdEWUJtMUl6bEM0dFlOWEZAUeDEyVjVDdUtOYkVneUtFWXlTQXhReDZAZAajYwNTZASRzhvN21sdDdDQ1JWSmV3U0xPT3FjV3NMRAZDZD";

	public static function getData()
	{
		$url = "https://graph.instagram.com/me/media?fields=id,media_type,media_url,caption,timestamp,thumbnail_url,permalink&access_token=" . self::TOKEN;
		$instagramCnct = curl_init(); // инициализация cURL подключения
		curl_setopt($instagramCnct, CURLOPT_URL, $url); // адрес запроса
		curl_setopt($instagramCnct, CURLOPT_RETURNTRANSFER, 1); // просим вернуть результат
		$media = json_decode(curl_exec($instagramCnct)); // получаем и декодируем данные из JSON
		curl_close($instagramCnct); // закрываем соединение

		return $media;
	}
}