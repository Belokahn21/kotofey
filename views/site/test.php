<?php


use VK\Client\VKApiClient;

$items = new \app\models\entity\OrdersItems();
$items->saveItems();

//$oauth = new \VK\OAuth\VKOAuth();
//$client_id = 7209302;
//$redirect_uri = 'https://oauth.vk.com/blank.html';
//$display = \VK\OAuth\VKOAuthDisplay::PAGE;
//$scope = array(\VK\OAuth\Scopes\VKOAuthUserScope::MESSAGES, \VK\OAuth\Scopes\VKOAuthUserScope::WALL, \VK\OAuth\Scopes\VKOAuthUserScope::GROUPS, \VK\OAuth\Scopes\VKOAuthUserScope::MARKET, \VK\OAuth\Scopes\VKOAuthUserScope::PHOTOS);
//$state = 'secret_state_code';
//$revoke_auth = true;
//$browser_url = $oauth->getAuthorizeUrl(\VK\OAuth\VKOAuthResponseType::TOKEN, $client_id, $redirect_uri, $display, $scope, $state, null, $revoke_auth);
//echo \yii\helpers\Html::a('get access token', $browser_url);

//$access_token = \app\models\entity\SiteSettings::getValueByCode('access_token');
//$access_token = '9b20f6f75e3d6afce2cfa6b16024dad5fadfbdc83cf92e57c7897a3310b4a5f17b7e0ce4ccd708fec1674';
//$group_id = 185683081;
//$vk = new VKApiClient();
//if ($access_token) {
//
//	try {
//
//		$message_response = $vk->messages()->send($access_token, [
//			'user_id' => Yii::$app->params['vk']['adminVkontakteId'],
//			'random_id' => rand(1, 999999),
//			'peer_id' => Yii::$app->params['vk']['adminVkontakteId'],
//			'message' => 'test',
//
//		]);
//		\app\models\tool\Debug::p($message_response);
//	} catch (\VK\Exceptions\Api\VKApiAccessException $exception) {
//		echo $exception->getMessage();
//	}
//
//}