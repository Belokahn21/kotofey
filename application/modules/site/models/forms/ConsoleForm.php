<?php

namespace app\modules\site\models\forms;

use yii\base\Model;

class ConsoleForm extends Model
{
    public $code;
    public $output;

    public function rules()
    {
        return [
            ['code', 'string']
        ];
    }

    public function run()
    {
        $this->output = eval("return " . $this->blockCode($this->code));
    }

    public function blockCode($code)
    {
        return str_replace('echo', '', $code);
    }
}