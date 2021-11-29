<?php

namespace app\modules\site\models\traits;

trait ErrorTrait
{
    private $errors = array();

    public function setErrors(array $errors)
    {
        $this->errors = $errors;
    }

    public function setError(string $attribute, string $text)
    {
        $this->errors[$attribute] = $text;
    }

    public function getErrors(): array
    {
        return $this->errors;
    }
}