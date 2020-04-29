<?php

namespace app\models\behaviors;

use yii\behaviors\AttributeBehavior;
use yii\db\BaseActiveRecord;
use yii\db\Expression;

class ArticleBehavior extends AttributeBehavior
{
    public $attributeArticle = 'article';

    public function init()
    {
        parent::init();

        if (empty($this->attributes)) {
            $this->attributes = [
                BaseActiveRecord::EVENT_BEFORE_INSERT => $this->attributeArticle
            ];
        }
    }

    protected function getValue($event)
    {
        if ($this->value instanceof Expression) {
            return $this->value;
        } else {
            return $this->value !== null ? call_user_func($this->value, $event) : $this->generateUniqueValue();
        }
    }

    public function generateUniqueValue()
    {
        return rand(0, 99999);
    }
}