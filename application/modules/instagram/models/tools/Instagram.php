<?php

namespace app\modules\instagram\models\tools;


class Instagram
{
	const TOKEN = "IGQVJYcGQ0UDdGVUNMdTRLX09UM0dlR3hWWjZAsVFVRUUN5SHRQbUpaVWlGMG1zWDlxblJBbVJSMDRGWUYyVUhMandycDFCMWJPX0xQQ19WdjBjeWFMNWY0M3JjQzVPaDNEczBncVNjWDNWNFZApOWxGSgZDZD";

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