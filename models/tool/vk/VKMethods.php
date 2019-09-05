<?
/**
 * Developer: Konstantin Vasin by PhpStorm
 * Company: Altasib
 * Time: 10:49
 */

namespace app\models\tool\vk;


use app\models\tool\Debug;

class VKMethods
{
    const VK_API_VERSION = "5.50";
    const VK_API_ACCESS_TOKEN = "5e0c5c367dafbfb626d6782397b879f1bd1954d7e8d45ba2dc1d1ff6ad39230ce4c63c54c9f7e55eaa71f";
    const VK_API_ENDPOINT = "https://api.vk.com/method/";

    private function executeMethod($method, $params = array())
    {
        $params['access_token'] = self::VK_API_ACCESS_TOKEN;
        $params['v'] = self::VK_API_VERSION;

        $query = http_build_query($params);
        $url = self::VK_API_ENDPOINT . $method . '?' . $query;

        $curl = curl_init($url);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        $json = curl_exec($curl);
        $error = curl_error($curl);
        if ($error) {
            Debug::printFile($error);
            throw new Exception("Failed {$method} request");
        }

        curl_close($curl);

        $response = json_decode($json, true);
        if (!$response || !isset($response['response'])) {
            Debug::printFile($json);
            throw new Exception("Invalid response for {$method} request");
        }

        return $response['response'];
    }

    public function sendUserMessage($userId, $message, $attach = false)
    {
        $this->executeMethod("messages.send", [
            'peer_id' => $userId,
            'message' => $message,
        ]);
    }
}