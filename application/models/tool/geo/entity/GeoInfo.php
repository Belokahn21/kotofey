<?php

namespace app\models\tool\geo\entity;

class GeoInfo
{
    public function load($data)
    {
        if (is_object($data)) {
            $data = (array)$data;
        }

        if (is_array($data)) {
            foreach ($data as $key => $value) {
                $this->{$key} = $value;
            }
        }
    }
}