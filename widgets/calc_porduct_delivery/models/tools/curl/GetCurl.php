<?

namespace app\widgets\calc_porduct_delivery\models\tools\curl;


class GetCurl extends Curl
{

    function exec($url, $params=array())
    {
        $response = null;

        if ($params) {
            $requestUrl = $url . "?" . http_build_query($params);
        } else {
            $requestUrl = $url;
        }

        if ($curl = curl_init()) {
            curl_setopt($curl, CURLOPT_URL, $requestUrl);
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
            $response = curl_exec($curl);
            curl_close($curl);
        }

        return $response;
    }
}