<?php

namespace app\modules\instagram\models\tools;


class Instagram
{
	const TOKEN = "IGQVJVS1FXVXVESnRHaXdwV1UzQlRnN3IxRk9XUDAyT0cybUxnX24wdUNtSlFXR25OY2U3eEZAiOTR6REh6dmJKc1JhR1dwdk05SVFxRk5md3pFUGc0ZAlNmMmpqS2s3b29QUTFBRjZAQOVhyRWtzRTl2TQZDZD";

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