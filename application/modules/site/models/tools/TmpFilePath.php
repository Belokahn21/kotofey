<?php

namespace app\modules\site\models\tools;


class TmpFilePath
{
    public static function buildFilePath($file_name)
    {
        return \Yii::getAlias("@app/tmp/$file_name");
    }
}