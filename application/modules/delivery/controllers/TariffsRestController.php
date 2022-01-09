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
                    'tariff_code' => '136',
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

                    $token = "eyJhbGciOiJSUzI1NiIsInR5cCI6IkpXVCJ9.eyJzY29wZSI6WyJvcmRlcjphbGwiLCJwYXltZW50OmFsbCJdLCJleHAiOjE2NDE3MDMxMDUsImF1dGhvcml0aWVzIjpbInNoYXJkLWlkOnJ1LTAxIiwiZnVsbC1uYW1lOtCi0LXRgdGC0LjRgNC-0LLQsNC90LjQtSDQmNC90YLQtdCz0YDQsNGG0LjQuCDQmNCcLCDQntCR0KnQldCh0KLQktCeINChINCe0JPQoNCQ0J3QmNCn0JXQndCd0J7QmSDQntCi0JLQldCi0KHQotCS0JXQndCd0J7QodCi0KzQriIsImFjY291bnQtbGFuZzpydXMiLCJjb250cmFjdDrQmNCcLdCg0KQt0JPQm9CTLTIyIiwiYWNjb3VudC11dWlkOmU5MjViZDBmLTA1YTYtNGM1Ni1iNzM3LTRiOTljMTRmNjY5YSIsImFwaS12ZXJzaW9uOjEuMSIsImNsaWVudC1pZC1lYzU6ZWQ3NWVjZjQtMzBlZC00MTUzLWFmZTktZWI4MGJiNTEyZjIyIiwiY2xpZW50LWlkLWVjNDoxNDM0ODIzMSIsImNvbnRyYWdlbnQtdXVpZDplZDc1ZWNmNC0zMGVkLTQxNTMtYWZlOS1lYjgwYmI1MTJmMjIiLCJzb2xpZC1hZGRyZXNzOmZhbHNlIiwiY2xpZW50LWNpdHk60J3QvtCy0L7RgdC40LHQuNGA0YHQuiwg0J3QvtCy0L7RgdC40LHQuNGA0YHQutCw0Y8g0L7QsdC7LiJdLCJqdGkiOiIxZDlkZGI0Zi02NzJkLTQ2NjEtYmZiNy05YmU3ZTA5NDVjZWQiLCJjbGllbnRfaWQiOiJFTXNjZDZyOUpuRmlRM2JMb3lqSlk2ZU03OEpySmNlSSJ9.Wl6eQcqjEiU1l2lQrtVFo-ytLIXrRwdZu0HchHbqlaFoaFileWZ2pzf440GixC-BIVmNAThDXrmRnceUE48ygC94AxzWxVP6cxmzvSgek_719J3zaf6Do9Hydee-wH53sOfVwPP_KVSJoMdUq9nC6ORweUh_zpbyQJZOtptvDaxeF59QgaUwAApclXZjJhxMWXGELMR8jRJAiAIsM0ajBs0j0k4hTlO2gNp91XXTItmaI84N-Bvkww1ohp0vt2jKpyxoeh4vGP-TTw32-jvjN-HBpM9TP44B49cds9dEaJpJYskZWXRNO_WFiUXCasAl4HsGxAxiesem2_A6pGpluQ";
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