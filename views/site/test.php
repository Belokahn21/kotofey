<?php


use VK\Client\VKApiClient;
use VK\OAuth\Scopes\VKOAuthUserScope;
use VK\OAuth\VKOAuth;
use VK\OAuth\VKOAuthDisplay;
use VK\OAuth\VKOAuthResponseType;


$access_token = '445c6e32c40949c9ebae2b1dd9f193f823ba7128320b5644b4baf85109a9b4f52df298910e9689225d29d';
$vk = new VKApiClient();
if ($access_token) {
	\app\models\tool\Debug::p($vk->market()->getCategories($access_token, [
		'count' => 1000
	]));
}