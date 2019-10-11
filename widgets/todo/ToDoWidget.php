<?

namespace app\widgets\todo;

use app\models\tool\System;
use app\models\entity\TodoList;

class ToDoWidget extends \yii\base\Widget
{

    // mysql

    private $tableName = 'todo_list';

    private $init = false;

    private function needInit()
    {
        if ($this->checkExistTable() === false) {
            $this->init = true;
        }

        if ($_GET['run'] == "y") {
            $this->createNewTable();

            if ($this->checkExistTable() === true) {
                \Yii::$app->controller->redirect(System::protocol() . '://' . $_SERVER['HTTP_HOST'] . explode('?', $_SERVER['REQUEST_URI'], 2)[0]);
            }
        }
    }

    private function checkExistTable()
    {
        $queryCheckTable = \Yii::$app->db->createCommand("SHOW TABLES LIKE 'todo_list'");
        $resultCheckTable = $queryCheckTable->execute();
        if ($resultCheckTable == 0) {
            return false;
        }

        return true;
    }

    private function createNewTable()
    {
        \Yii::$app->db->createCommand("
CREATE TABLE todo_list (
`id` INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
name varchar(256) not null,
description text null,
close tinyint(1) not null,
created_at int not null,
updated_at int not null
)ENGINE=MyISAM;
            ")->execute();
    }

    public function run()
    {
        $this->needInit();

        $model = new TodoList();
        $items = TodoList::find()->orderBy(['created_at' => SORT_DESC])->where(['close' => false])->all();

        if (\Yii::$app->request->isPost) {
            if ($model->create()) {
                \Yii::$app->controller->refresh();
            }
        }

        return $this->render('default', [
            'init' => $this->init,
            'items' => $items,
            'model' => $model,
        ]);
    }
}