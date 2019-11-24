<?

namespace app\models\rbac;

use Yii;
use yii\behaviors\TimestampBehavior;

/**
 * AuthItem model
 *
 * @property string $name
 * @property string $type
 * @property string $description
 * @property string $rule_name
 * @property string $data
 * @property integer $created_at
 * @property integer $updated_at
 */
class AuthItem extends \yii\db\ActiveRecord
{
    const TYPE_ROLE = 1;
    const TYPE_PERMISSION = 2;

    public $parent;

    public function attributeLabels()
    {
        return [
            'name' => 'Название',
            'description' => 'Описание',
            'parent' => 'Родительская группа',
        ];
    }

    public function behaviors()
    {
        return [
            TimestampBehavior::className()
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