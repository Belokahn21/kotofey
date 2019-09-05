<?
/**
 * Developer: Konstantin Vasin by PhpStorm
 * Company: Altasib
 * Time: 23:13
 */

namespace app\models\rbac;

use app\models\tool\Debug;
use Yii;

class AuthItem extends \yii\db\ActiveRecord
{
    const TYPE_ROLE = 1;
    const TYPE_PERMISSION = 2;

//    public $name;
//    public $description;
    public $parent;

    public function attributeLabels()
    {
        return [
            'name' => 'Название',
            'description' => 'Описание',
            'parent' => 'Родительская группа',
        ];
    }

    public function rules()
    {
        return [
            ['name', 'required', 'message' => '{attribute} должно быть заполнено'],

            ['description', 'string'],

            ['parent', 'string'],
        ];
    }

    public function createPermission()
    {
        $permission = Yii::$app->authManager->createPermission($this->name);
        $permission->description = $this->description;
        Yii::$app->authManager->add($permission);

        return true;
    }

    public function createRole()
    {
        $auth = \Yii::$app->authManager;

        $role = $auth->createRole($this->name);
        $role->description = $this->description;
        $auth->add($role);

        if(!empty($this->parent)){

            $parentRole = $auth->getRole($this->parent);
            $auth->addChild($parentRole, $role);

        }


        return true;
    }
}