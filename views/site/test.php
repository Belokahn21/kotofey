<?php


use VK\Client\VKApiClient;
use VK\OAuth\Scopes\VKOAuthUserScope;
use VK\OAuth\VKOAuth;
use VK\OAuth\VKOAuthDisplay;
use VK\OAuth\VKOAuthResponseType;

$oauth = new VKOAuth();
$client_id = 7209302;
$redirect_uri = 'http://local.shop-kotofey.ru';
$display = VKOAuthDisplay::PAGE;
$scope = array(VKOAuthUserScope::WALL, VKOAuthUserScope::GROUPS, VKOAuthUserScope::MARKET, VKOAuthUserScope::PHOTOS);
$state = 'secret_state_code';
$revoke_auth = true;

$browser_url = $oauth->getAuthorizeUrl(VKOAuthResponseType::TOKEN, $client_id, $redirect_uri, $display, $scope, $state, null, $revoke_auth);


echo \yii\helpers\Html::a('click', $browser_url);

$access_token = '445c6e32c40949c9ebae2b1dd9f193f823ba7128320b5644b4baf85109a9b4f52df298910e9689225d29d';
$vk = new VKApiClient();
if ($access_token) {
    $response = $vk->photos()->getMarketUploadServer($access_token, [
        'group_id' => 185683081,
        'main_photo' => 1,
    ]);
    if ($curl = curl_init()) {

        $filename = realpath('G:\projects\local.shop-kotofey.ru\views\site\product.png');
        $finfo = new \finfo(FILEINFO_MIME_TYPE);
        $mimetype = $finfo->file($filename);


        curl_setopt($curl, CURLOPT_URL, $response['upload_url']);
        curl_setopt($curl, CURLOPT_HTTPHEADER, array("Content-type: multipart/form-data"));
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_POST, true);
        curl_setopt($curl, CURLOPT_POSTFIELDS, [
            'file' => curl_file_create($filename, $mimetype, basename($filename))
        ]);
        $out = curl_exec($curl);
        $obj = \yii\helpers\Json::decode($out);
        curl_close($curl);


        $answer = $vk->photos()->saveMarketPhoto($access_token, [
            'group_id' => 185683081,
            'photo' => $obj['photo'],
            'server' => $obj['server'],
            'hash' => $obj['hash'],
            'crop_data' => $obj['crop_data'],
            'crop_hash' => $obj['crop_hash'],
        ]);


//        \app\models\tool\Debug::p($answer);


        $response = $vk->market()->add($access_token, [
            'owner_id' => -185683081,
            'name' => 'test',
            'description' => 'test description',
            'category_id' => '1',
            'main_photo_id' => $answer[0]['id'],
            'price' => '100500',
            'url' => 'https://kotofey.store/test/'
        ]);

        \app\models\tool\Debug::p($response);

    }
}

