<?php

namespace app\modules\site\models\behaviors;

use yii\base\Behavior;
use yii\db\ActiveRecord;

class UserEntityBehavior extends Behavior
{
    public $attr_at_save;
    public $attr_at_update;

    public function events()
    {
        return [
            ActiveRecord::EVENT_BEFORE_INSERT => 'apply_user_id_when_save',
            ActiveRecord::EVENT_BEFORE_UPDATE => 'apply_user_id_when_update',
        ];
    }

    public function apply_user_id_when_save($event)
    {
        $user_component = \Yii::$app->user;
        if (!$user_component->isGuest) {
            $this->owner->{$this->attr_at_save} = $user_component->identity->id;
        }
    }


    public function apply_user_id_when_update($event)
    {
        $user_component = \Yii::$app->user;
        if (!$user_component->isGuest) {
            $this->owner->{$this->attr_at_update} = $user_component->identity->id;
        }
    }
}