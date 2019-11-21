<?php

use VK\OAuth\Scopes\VKOAuthUserScope;
use VK\OAuth\VKOAuth;
use VK\OAuth\VKOAuthDisplay;
use VK\OAuth\VKOAuthResponseType;

$oauth = new VKOAuth();
$client_id = 7209302;
$redirect_uri = 'https://kotofey.store';
$display = VKOAuthDisplay::PAGE;
$scope = array(VKOAuthUserScope::WALL, VKOAuthUserScope::GROUPS, VKOAuthUserScope::MARKET, VKOAuthUserScope::PHOTOS, VKOAuthUserScope::OFFLINE);
$state = 'secret_state_code';
$revoke_auth = true;

$browser_url = $oauth->getAuthorizeUrl(VKOAuthResponseType::TOKEN, $client_id, $redirect_uri, $display, $scope, $state, null, $revoke_auth);

echo \yii\helpers\Html::a('click', $browser_url);

$access_token = '9a59bee577bfac9297aaab387a5d22ca36b847e5b414823b33f7c53f0e214d4ee828f1e8755004c99c515';
$vk = new \VK\Client\VKApiClient();
if ($access_token) {
	\app\models\tool\Debug::p($vk->market()->getCategories($access_token, [
		'count' => 1000
	]));
}