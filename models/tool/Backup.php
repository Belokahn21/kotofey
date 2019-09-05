<?
/**
 * Developer: Konstantin Vasin by PhpStorm
 * Company: Altasib
 * Time: 22:09
 */

namespace app\models\tool;


use app\models\entity\SiteSettings;

class Backup
{
    private $db_user = "cd91333_shop";
    private $db_name = "cd91333_shop";
    private $db_password = "123qweR%";
    private $db_host = "localhost";

    private $dirSize;
    private $nameDirDumps = "/backup/";

    public function createDumpDatabase()
    {
        $fileName = date('d_m_Y');
        $pathToSave = \Yii::getAlias('@app') . "/backup/dump_" . $fileName . ".sql";

        $command = sprintf("mysqldump -u%s -p%s %s > %s", $this->db_user, $this->db_password, $this->db_name, $pathToSave);
        exec($command);
    }


    public function checkLimitSize()
    {
        if (Converter::mbyteToKbyte($this->getDirSize()) > SiteSettings::getValueByCode('backup_catalog_size')) {
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
        return filesize(\Yii::getAlias('@app') . $this->nameDirDumps . $backupFileName);
    }

    public function getDumpList()
    {
        return scandir(\Yii::getAlias('@app') . $this->nameDirDumps);
    }

    public function clearDumpCatalog()
    {
        return rmdir(\Yii::getAlias('@app') . $this->nameDirDumps);
    }

    /**
     * @return mixed
     */
    public function getDirSize()
    {
        return $this->dirSize;
    }
}