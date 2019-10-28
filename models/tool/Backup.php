<?php

namespace app\models\tool;


use app\models\entity\SiteSettings;

class Backup
{
    private $db_user = "cd91333_shop";
    private $db_name = "cd91333_shop";
    private $db_password = "123qweR%";
    private $db_host = "localhost";

    private $dirSize;
    private $name_dir_dumps = "/backup/";

    public function __construct()
    {
        $this->config();
    }

    public function config()
    {
        if (YII_ENV == 'dev') {
            $this->setDbUser(\Yii::$app->db->username);
            $this->setDbPassword(\Yii::$app->db->password);
            $this->setDbName('kotofey_shop');
        }
    }

    /**
     * @param string $db_host
     */
    public function setDbHost($db_host)
    {
        $this->db_host = $db_host;
    }

    /**
     * @param string $db_name
     */
    public function setDbName($db_name)
    {
        $this->db_name = $db_name;
    }

    /**
     * @param string $db_password
     */
    public function setDbPassword($db_password)
    {
        $this->db_password = $db_password;
    }

    /**
     * @param string $db_user
     */
    public function setDbUser($db_user)
    {
        $this->db_user = $db_user;
    }

    /**
     * @param mixed $dirSize
     */
    public function setDirSize($dirSize)
    {
        $this->dirSize = $dirSize;
    }

    /**
     * @param string $name_dir_dumps
     */
    public function setNameDirdumps($name_dir_dumps)
    {
        $this->name_dir_dumps = $name_dir_dumps;
    }

    public function createDumpDatabase()
    {
        $fileName = date('d_m_Y');
        $pathToSave = \Yii::getAlias('@app') . "/backup/dump_" . $fileName . ".sql";

        $command = sprintf("mysqldump -u%s -p%s %s > %s", $this->db_user, $this->db_password, $this->db_name,
            $pathToSave);
        exec($command);
    }


    public function isOverSize()
    {
        $dump_size = Converter::mbyteToKbyte(System::getInstance()->folderSize(\Yii::getAlias('@app') . '/backup/')) / 1024;
        if ($dump_size > SiteSettings::getValueByCode('backup_catalog_size')) {
            return true;
        }

        return false;
    }

    public function getSizeDirectoryDatabaseDumps()
    {
        $allBackupList = $this->getDumpList();

        if (!empty($allBackupList)) {

            foreach ($allBackupList as $backupFile) {
                $size = $this->getDumpSize($backupFile);
                if ($size > 0) {
                    $this->dirSize += $size;
                }
            }

        }
    }

    public function getDumpSize($backupFileName)
    {
        return filesize(\Yii::getAlias('@app') . $this->name_dir_dumps . $backupFileName);
    }

    public function getDumpList()
    {
        return scandir(\Yii::getAlias('@app') . $this->name_dir_dumps);
    }

    public function chmodFilss()
    {
        return array_map('chmod(0777)', glob(\Yii::getAlias('@app') . $this->name_dir_dumps));
    }


    public function clearDumpCatalog()
    {
        $files = scandir(\Yii::getAlias('@app') . '/backup/');
        foreach ($files as $file) {
            $file = \Yii::getAlias('@app') . '/backup/' . $file;

            if (is_file($file)) {
                unlink($file);
            }
        }
    }

    /**
     * @return mixed
     */
    public function getDirSize()
    {
        return $this->dirSize;
    }
}