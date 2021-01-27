<?php

namespace app\modules\search\widges\SearchMessage;


use yii\base\Widget;

class SearchMessageWidget extends Widget
{
    public $view = 'default';
    public $q;

    public function run()
    {
        $message = "";
        $data = [
            [
                'words' => 'acana акана orijen ориджен',
                'message' => "Уважаемые посетители, если вы ищите Акану/Ориджен, то у нас она отсутсвует в связи с запретом на ввоз в Россию. Есть два варианта решения - искать дальше по магазинам либо обратиться к нам за альтернативой кормления."
            ]
        ];

        foreach ($data as $datum) {
            $words = explode(" ", $datum['words']);
            foreach ($words as $word) {
                if (mb_strpos($this->q, $word) !== false) {
                    $message = $datum['message'];
                    break;
                }
            }
        }

        if (empty($message)) return false;

        return $this->render($this->view, [
            'message' => $message
        ]);
    }
}