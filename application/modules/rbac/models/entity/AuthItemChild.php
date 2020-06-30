<?php

namespace app\modules\rbac\models\entity;


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