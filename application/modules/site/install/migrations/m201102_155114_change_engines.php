<?php

use yii\db\Migration;

class m201102_155114_change_engines extends Migration
{
    public function safeUp()
    {
//        ALTER TABLE table_name ENGINE = InnoDB;
        $this->execute("
        SET @DATABASE_NAME = 'kotofey_store';

SELECT  CONCAT('ALTER TABLE `', table_name, '` ENGINE=InnoDB;') AS sql_statements
FROM    information_schema.tables AS tb
WHERE   table_schema = @DATABASE_NAME
AND     `ENGINE` = 'MyISAM'
AND     `TABLE_TYPE` = 'BASE TABLE'
ORDER BY table_name DESC;
        ");
    }

    public function safeDown()
    {
    }
}
