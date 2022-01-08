<?php


namespace app\modules\delivery\controllers;

use app\modules\site\models\tools\Debug;
use yii\helpers\Json;
use yii\rest\Controller;


class TariffsRestController extends Controller
{
    public function actionCreate()
    {
        $post_data = \Yii::$app->request->post();


        // список сервисов доставок
        // товары


        $cdek_class = new class {

            public function tariff()
            {
                return $this->execute('https://api.edu.cdek.ru/v2/calculator/tariff', [
                    "type" => 1,
                    "date" => date('Y-m-d\Th:i:s+0700'),
                    "currency" => 1,
                    'tariff_code' => '234',
                    "lang" => "rus",
                    'from_location' => [
                        'postal_code' => '656000',
                    ],
                    'to_location' => [
                        'postal_code' => '650000',
                    ],
                    'packages' => [
                        [
                            'width' => 20,
                            'height' => 20,
                            'length' => 20,
                            'weight' => 20000,
                        ]
                    ],
                ]);
            }

            private function execute($url, array $params)
            {
                $response = false;
                $headers = [];
                if ($curl = curl_init()) {

                    $token = "eyJhbGciOiJSUzI1NiIsInR5cCI6IkpXVCJ9.eyJzY29wZSI6WyJvcmRlcjphbGwiLCJwYXltZW50OmFsbCJdLCJleHAiOjE2NDE2MzU4NTgsImF1dGhvcml0aWVzIjpbInNoYXJkLWlkOnJ1LTAxIiwiZnVsbC1uYW1lOtCi0LXRgdGC0LjRgNC-0LLQsNC90LjQtSDQmNC90YLQtdCz0YDQsNGG0LjQuCDQmNCcLCDQntCR0KnQldCh0KLQktCeINChINCe0JPQoNCQ0J3QmNCn0JXQndCd0J7QmSDQntCi0JLQldCi0KHQotCS0JXQndCd0J7QodCi0KzQriIsImNvbnRyYWN0OtCY0Jwt0KDQpC3Qk9Cb0JMtMjIiLCJhY2NvdW50LWxhbmc6cnVzIiwiYWNjb3VudC11dWlkOmU5MjViZDBmLTA1YTYtNGM1Ni1iNzM3LTRiOTljMTRmNjY5YSIsImFwaS12ZXJzaW9uOjEuMSIsImNsaWVudC1pZC1lYzU6ZWQ3NWVjZjQtMzBlZC00MTUzLWFmZTktZWI4MGJiNTEyZjIyIiwiY2xpZW50LWlkLWVjNDoxNDM0ODIzMSIsImNvbnRyYWdlbnQtdXVpZDplZDc1ZWNmNC0zMGVkLTQxNTMtYWZlOS1lYjgwYmI1MTJmMjIiLCJzb2xpZC1hZGRyZXNzOmZhbHNlIiwiY2xpZW50LWNpdHk60J3QvtCy0L7RgdC40LHQuNGA0YHQuiwg0J3QvtCy0L7RgdC40LHQuNGA0YHQutCw0Y8g0L7QsdC7LiJdLCJqdGkiOiIxOGQzZGVhOS1lYzVmLTQ1OTktYWIzZS1hOWZlMzgzNDg1ZjkiLCJjbGllbnRfaWQiOiJFTXNjZDZyOUpuRmlRM2JMb3lqSlk2ZU03OEpySmNlSSJ9.lbdFbCS_56E22h2ND_iII79sBBcYAhJSWMdCLajC2zFe9Cvrb-rnLR4evGSOjISSE0yTOQYCxfTceP-vwtPwobJ0G08xYhENuNntYYybBbmUKSvtibHXjFJyOSlhd81f2OGMZ1AFfdiQdtb05rCgwD-GSMHDeyBs68ko-_p0dbZpfIoVXNDt_2xm0QBxafqJStpptGPxWv6mAJmkpPs6gJ8MwLV_xFA4WJ3kYJ2bdnp3XZHv_5hKifsmW1puI8BwO4Vegn7G-pkvfmBw-5Rn_FaiVqZK5kESrkao5NX9hdcobOKKHlRE1eiDr1IIA02sfa_gjUZiHQsPryr30dcaqg";
                    $headers[] = "Authorization: Bearer {$token}";
                    $headers[] = "Content-Type: application/json";

                    if ($headers) curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
                    curl_setopt($curl, CURLOPT_URL, $url);
                    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
                    curl_setopt($curl, CURLOPT_POST, true);
                    curl_setopt($curl, CURLOPT_POSTFIELDS, Json::encode($params));
                    $response = curl_exec($curl);
                    curl_close($curl);
                }

                return Json::decode($response);
            }
        };

        Debug::p($cdek_class->tariff());


        /*
         * response => [
         *  cdek=>[
         *      0=>[
         *          name:'название',
         *          price:'1500',
         *      ]
         *  ]
         * ]
         * */

//        return rand();
    }
}