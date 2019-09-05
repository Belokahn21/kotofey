<?
/**
 * Developer: Konstantin Vasin by PhpStorm
 * Company: Altasib
 * Time: 12:06
 */

namespace app\models\tool\vk;

use app\models\entity\User;
use app\models\tool\System;
use app\models\tool\vk\entity\VKUser;
use yii\log\SyslogTarget;

class VKWeb
{

    private $authorizeUrl = 'http://oauth.vk.com/authorize';

    private $client_id = '6839842'; // ID приложения
    private $client_secret = 'BalhK2Q430Vchd0cuA5T'; // Защищённый ключ
    private $redirect_uri; // Адрес сайта

    public function __construct()
    {
        $this->setRedirectUri((new System())->getCurrentUrl());
    }

    public function setRedirectUri($redirect_uri)
    {
        $this->redirect_uri = $redirect_uri;
    }

    public function authLink()
    {
        $params = array(
            'client_id' => $this->client_id,
            'redirect_uri' => $this->redirect_uri,
            'response_type' => 'code'
        );

        return $this->authorizeUrl . '?' . (http_build_query($params));
    }

    public function getVKUser()
    {
        if (isset($_GET['code'])) {
            $params = array(
                'client_id' => $this->client_id,
                'client_secret' => $this->client_secret,
                'code' => $_GET['code'],
                'redirect_uri' => $this->redirect_uri
            );

            try {
                $token = json_decode(file_get_contents('http://oauth.vk.com/access_token' . '?' . (http_build_query($params))), true);
            } catch (\Exception $exception) {
            }

            if (isset($token['access_token'])) {
                $params = array(
                    'uids' => $token['user_id'],
                    'v' => '5.92',
                    'fields' => 'id,first_name,last_name,screen_name,sex,bdate,photo_big',
                    'access_token' => $token['access_token']
                );

                $userInfo = json_decode(file_get_contents('https://api.vk.com/method/users.get' . '?' . (http_build_query($params))),true);

                if (isset($userInfo['response'][0]['id'])) {
                    $userInfo = $userInfo['response'][0];
                    $vkUser = new VKUser();
                    $vkUser->setAttributes($userInfo);
                    return $vkUser;
                }
            }
        }
        return false;
    }
}


