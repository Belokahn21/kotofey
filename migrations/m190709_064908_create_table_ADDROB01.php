<?php

use yii\db\Migration;

class m190709_064908_create_table_ADDROB01 extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%ADDROB01}}', [
            'ACTSTATUS' => $this->integer(),
            'AOGUID' => $this->string(),
            'AOID' => $this->string(),
            'AOLEVEL' => $this->integer(),
            'AREACODE' => $this->string(),
            'AUTOCODE' => $this->string(),
            'CENTSTATUS' => $this->integer(),
            'CITYCODE' => $this->string(),
            'CODE' => $this->string(),
            'CURRSTATUS' => $this->integer(),
            'ENDDATE' => $this->date(),
            'FORMALNAME' => $this->string(),
            'IFNSFL' => $this->string(),
            'IFNSUL' => $this->string(),
            'NEXTID' => $this->string(),
            'OFFNAME' => $this->string(),
            'OKATO' => $this->string(),
            'OKTMO' => $this->string(),
            'OPERSTATUS' => $this->integer(),
            'PARENTGUID' => $this->string(),
            'PLACECODE' => $this->string(),
            'PLAINCODE' => $this->string(),
            'POSTALCODE' => $this->string(),
            'PREVID' => $this->string(),
            'REGIONCODE' => $this->string(),
            'SHORTNAME' => $this->string(),
            'STARTDATE' => $this->date(),
            'STREETCODE' => $this->string(),
            'TERRIFNSFL' => $this->string(),
            'TERRIFNSUL' => $this->string(),
            'UPDATEDATE' => $this->date(),
            'CTARCODE' => $this->string(),
            'EXTRCODE' => $this->string(),
            'SEXTCODE' => $this->string(),
            'LIVESTATUS' => $this->integer(),
            'NORMDOC' => $this->string(),
            'PLANCODE' => $this->string(),
            'CADNUM' => $this->string(),
            'DIVTYPE' => $this->integer(),
        ], $tableOptions);

    }

    public function down()
    {
        $this->dropTable('{{%ADDROB01}}');
    }
}
