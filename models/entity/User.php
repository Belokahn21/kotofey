<?
/**
 * Developer: Konstantin Vasin by PhpStorm
 * Company: Altasib
 * Time: 2:25
 */

namespace app\models\entity;

use app\models\entity\user\Billing;
use Yii;
use yii\behaviors\TimestampBehavior;
use yii\rbac\Assignment;
use yii\web\IdentityInterface;
use yii\web\UploadedFile;

/**
 * User model
 *
 * @property integer $id
 * @property string $auth_key
 * @property string $access_token
 * @property string $email
 * @property string $password
 * @property string $new_password
 * @property string $avatar
 * @property integer $vk_uid
 * @property integer $birthday
 * @property integer $sex
 * @property string $first_name
 * @property string $name
 * @property string $last_name
 * @property string $vk_link
 * @property integer $created_at
 * @property integer $updated_at
 *
 * @property Assignment $roles
 * @property Billing $billing
 */
class User extends \yii\db\ActiveRecord implements IdentityInterface
{
    const SCENARIO_REGISTER = 1;
    const SCENARIO_REGISTER_WITH_VK = 2;
    const SCENARIO_LOGIN = 3;
    const SCENARIO_LOGIN_WITH_VK = 4;
    const SCENARIO_NEW_REVIEW = 5;
    const SCENARIO_REGISTER_IN_CHECKOUT = 6;
    const SCENARIO_USER_UPDATE = 7;

    const EVENT_NEW_DISCOUNT = "new_discount";

    public $new_password;
    public $avatarFile;
    public $roleName;

    public function createDiscount()
    {
        $existDiscount = Discount::findByUserId($this->id);
        if (!$existDiscount instanceof Discount) {
            $discount = new Discount();
            $discount->user_id = $this->id;
            $discount->count = 0;
            if ($discount->save() !== false) {
                return true;
            }
        }

        return false;
    }

    public function behaviors()
    {
        return [
            TimestampBehavior::className()
        ];
    }

    public function scenarios()
    {
        return [
            self::SCENARIO_REGISTER => [
                'email',
                'new_password',
                'first_name',
                'name',
                'last_name',
                'sex',
                'roleName',
                'birthday',
                'avatarFile'
            ],
            self::SCENARIO_REGISTER_WITH_VK => ['email', 'new_password', 'vk_uid'],
            self::SCENARIO_REGISTER_IN_CHECKOUT => ['email', 'new_password'],
            self::SCENARIO_LOGIN => ['email', 'password', 'new_password'],
            self::SCENARIO_LOGIN_WITH_VK => ['email', 'new_password'],
            self::SCENARIO_NEW_REVIEW => ['name'],
            self::SCENARIO_USER_UPDATE => [
                'email',
                'new_password',
                'first_name',
                'name',
                'last_name',
                'sex',
                'roleName',
                'birthday',
                'avatarFile'
            ],
        ];
    }

    public function rules()
    {
        return [
            [
                ['email', 'new_password'],
                'required',
                'message' => 'Поле {attribute} должно быть заполнено',
                'except' => self::SCENARIO_USER_UPDATE
            ],
            [['vk_uid'], 'integer', 'message' => 'Поле {attribute} должно содержать цифры'],

            [['first_name', 'name', 'last_name'], 'string'],

            [['sex', 'birthday'], 'string'],

            [['email'], 'unique', 'except' => self::SCENARIO_LOGIN, 'message' => 'Данный {attribute} уже используется'],
            ['email', 'email', 'message' => 'Неккоректный формат электронной почты'],

            [['avatarFile'], 'file', 'skipOnEmpty' => true, 'extensions' => 'png, jpg'],

        ];
    }

    public function attributeLabels()
    {
        return [
            'first_name' => "Фамилия",
            'name' => "Имя",
            'last_name' => "Отчество",
            'email' => "E-Mail",
            'password' => "Пароль",
            'new_password' => "Пароль",
            'birthday' => "День рождения",
            'sex' => "Пол",
            'avatarFile' => "Загрузить аватар",
            'roleName' => "Группа",
            'created_at' => "Дата регистрации",
        ];
    }

    public function createUser()
    {
        if ($this->load(Yii::$app->request->post())) {
            $this->setPassword($this->new_password);
            $this->generateAuthKey();
            if ($this->validate()) {
                if ($this->save() !== false) {

                    if ($this->createDiscount() === false) {
                        return false;
                    }
                    return $this;

                }
            }
        }
        return false;
    }

    public function login()
    {
        $user = static::findByEmail($this->email);
        if ($user instanceof User) {
            if ($user->validatePassword($this->new_password)) {
                return Yii::$app->user->login($user);
            }
        }

        return false;
    }

    public function loginVk()
    {
        $user = self::findByVKUid($this->vk_uid);
        if ($user instanceof User) {
            return Yii::$app->user->login($user);
        }

        return false;
    }

    public function uploadAvatar()
    {
        $this->avatarFile = UploadedFile::getInstance($this, 'avatarFile');
        if (!empty($this->avatarFile)) {

            // удалить старое фото
            $this->removeOldImage();

            $fileName = substr(md5($this->avatarFile->baseName), 0, 32) . '.' . $this->avatarFile->extension;
            $path = \Yii::getAlias('@app') . '/web/upload/' . $fileName;

            $this->avatarFile->saveAs($path, false);
            $this->avatar = "/web/upload/" . $fileName;
        }

        return true;
    }

    public function removeOldImage()
    {
        if (!empty($this->avatar)) {
            if (file_exists(\Yii::getAlias('@app') . $this->avatar)) {
                unlink(\Yii::getAlias('@app') . $this->avatar);
            }
        }
    }

    public static function findByEmail($email)
    {
        return static::findOne(['email' => $email]);
    }


    public static function findByVKUid($vkuid)
    {
        return static::findOne(['vk_uid' => $vkuid]);
    }

    public function getDiscount()
    {
        return Discount::findByUserId($this->id);
    }

    public function getRoles()
    {
        return Yii::$app->authManager->getAssignments($this->id);
    }

    public static function isRole($roleName)
    {
        if (empty($roleName)) {
            throw new \InvalidArgumentException("Не указана роль для проверки");
        }

        $user_id = Yii::$app->user->identity->id;
        $roles = \Yii::$app->authManager->getRolesByUser($user_id);

        if (!empty($roles)) {
            foreach ($roles as $key => $role) {
                if (strcasecmp($role->name, $roleName) == 0) {
                    return true;
                }
            }
        }

        return false;
    }

    public function getBilling()
    {
        return Billing::findByUser($this->id);
    }

    //---------------------------------

    public function getId()
    {
        return $this->getPrimaryKey();
    }

    public function getAuthKey()
    {
        return $this->auth_key;
    }

    public function validateAuthKey($authKey)
    {
        return $this->getAuthKey() === $authKey;
    }

    public function validatePassword($password)
    {
        return Yii::$app->security->validatePassword($password, $this->password);
    }

    public function setPassword($password)
    {
        $this->password = Yii::$app->security->generatePasswordHash($password);
    }

    public function generateAuthKey()
    {
        $this->auth_key = Yii::$app->security->generateRandomString();
    }

    public static function findIdentity($id)
    {
        return static::findOne(['id' => $id]);
    }

    public static function findIdentityByAccessToken($token, $type = null)
    {
        throw new NotSupportedException('"findIdentityByAccessToken" is not implemented.');
    }

    public static function findByUsername($username)
    {
        return static::findOne(['username' => $username, 'status' => self::STATUS_ACTIVE]);
    }

    public function calcCurrentAge($birthday = "17-10-1985")
    {
        $dateOfBirth = $birthday;
        $today = date("Y-m-d");
        $diff = date_diff(date_create($dateOfBirth), date_create($today));
        return $diff->format('%y год и %m месяца');
    }
}