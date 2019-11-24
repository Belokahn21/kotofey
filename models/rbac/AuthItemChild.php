<?php

namespace app\models\rbac;


use yii\db\ActiveRecord;

class AuthItemChild extends ActiveRecord
{
    public function rules()
    {
        return [
            [['parent', 'child'], 'required'],
            [['parent', 'child'], 'string'],
        ];
    }
}