<?
/**
 * Developer: Konstantin Vasin by PhpStorm
 * Company: Altasib
 * Time: 0:34
 */

namespace app\models\tool\delivery\calc;

use yii\helpers\Json;

class Dellin extends AbstractDellin
{
    private $appkey;
    private $login;
    private $password;
    private $sessionID;

    public function __construct()
    {
        if (empty($this->appkey)) {
            $this->setAppkey("65CC5FDE-C78B-47D3-B2E7-1F090049B2BF");
        }
        if (empty($this->login)) {
            $this->setLogin("popugau@gmail.com");
        }
        if (empty($this->password)) {
            $this->setPassword("123qweR%");
        }

        $this->authorize();
    }


    private function authorize()
    {
        $url = 'https://api.dellin.ru/v1/customers/login.json';
        $params = [
            "appkey" => $this->appkey,
            "login" => $this->login,
            "password" => $this->password
        ];

        $response = $this->curl($url, $params);

        $response = Json::decode($response);

        $this->setSessionID($response['sessionID']);

    }

    protected function curl($url, $params)
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $this->paramToJson($params));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $response = curl_exec($ch);
        curl_close($ch);

        return $response;
    }

    protected function paramToJson($params)
    {
        return Json::encode($params);
    }



    /*---------------------------------*/

    /**
     * @param string $appkey
     */
    public function setAppkey($appkey)
    {
        $this->appkey = $appkey;
    }

    /**
     * @param mixed $login
     */
    public function setLogin($login)
    {
        $this->login = $login;
    }

    /**
     * @param mixed $password
     */
    public function setPassword($password)
    {
        $this->password = $password;
    }

    /**
     * @return mixed
     */
    public function getAppkey()
    {
        return $this->appkey;
    }

    /**
     * @return mixed
     */
    public function getLogin()
    {
        return $this->login;
    }

    /**
     * @return mixed
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * @return mixed
     */
    public function getSessionID()
    {
        return $this->sessionID;
    }

    /**
     * @param mixed $sessionID
     */
    public function setSessionID($sessionID)
    {
        $this->sessionID = $sessionID;
    }
}