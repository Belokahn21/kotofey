<?
/**
 * Developer: Konstantin Vasin by PhpStorm
 * Company: Altasib
 * Time: 9:53
 */

namespace app\models\tool\delivery\calc;


use yii\helpers\Json;

class CalculateDelllin extends AbstractDellin
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
    }


    public function calc($filter = array())
    {
        $url = "https://api.dellin.ru/v1/public/calculator.json";
        $params = [
            'appkey' => $this->appkey,
            'sessionID' => $this->sessionID,
//            'derivalPoint' => '2200000100000000000000000',
            'derivalPoint' => '7800000000000000000000000',
//            'derivalPoint' => '2200000100000000000000000',
            'derivalDoor' => true,
            'arrivalPoint' => '5200000100000000000000000',
            'arrivalDoor' => false,
            'sizedVolume' => 33,
            'sizedWeight' => 15.5,
            'oversizedVolume' => 0.8,
            'oversizedWeight' => 11.1,
            'length' => 0.5,
            'width' => 1.1,
            'height' => 0.9,
            'freight_uid' => '0x9c2acaea110d75ba48fdc7a83c976269',
            'statedValue' => 1000.5,
        ];

        if (count($filter) > 0) {

            if(isset($filter['derivalPoint']) && !empty($filter['derivalPoint'])){
                if (strlen($filter['derivalPoint']) < 25) {
                    $filter['derivalPoint'] = $filter['derivalPoint'] . str_repeat("0", 25 - strlen($filter['derivalPoint']));
                }
            }

            $params = array_merge($params, $filter);
        }

        $response = $this->curl($url, $params);


        return Json::decode($response);
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
     * @param mixed $sessionID
     */
    public function setSessionID($sessionID)
    {
        $this->sessionID = $sessionID;
    }

    /**
     * @return mixed
     */
    public function getSessionID()
    {
        return $this->sessionID;
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


    protected function curl($url, $params)
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_HTTPHEADER,
            array('Content-Type: application/json', 'Content-Accept: application/json'));
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
}