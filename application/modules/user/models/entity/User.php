<?php

namespace app\modules\user\models\entity;

use app\modules\bonus\models\entity\Discount;
use app\modules\rbac\models\entity\AuthAssignment;
use app\modules\rbac\models\entity\AuthItem;
use mohorev\file\UploadBehavior;
use Yii;
use yii\behaviors\TimestampBehavior;
use yii\web\IdentityInterface;

/**
 * User model
 *
 * @property integer $id
 * @property string $auth_key
 * @property string $access_token
 * @property string $email
 * @property string $password
 * @property string $avatar
 * @property integer $vk_uid
 * @property integer $birthday
 * @property integer $sex
 * @property string $first_name
 * @property string $name
 * @property string $phone
 * @property string $last_name
 * @property string $vk_link
 * @property integer $created_at
 * @property integer $updated_at
 *
 * @property AuthItem $group
 * @property Billing $billing
 * @property \app\modules\bonus\models\entity\Discount $discount
 */
class User extends \yii\db\ActiveRecord implements IdentityInterface
{
    const SCENARIO_INSERT = 'insert';
    const SCENARIO_UPDATE = 'update';
    const SCENARIO_LOGIN = 'login';
    const SCENARIO_CHECKOUT = 'checkout';
    const SCENARIO_PROFILE_UPDATE = 'profile';

    public $groups;
    public $new_password;

    public function scenarios()
    {
        return [
            self::SCENARIO_INSERT => ['phone', 'email', 'password', 'groups', 'new_password'],
            self::SCENARIO_UPDATE => ['phone', 'email', 'password', 'groups', 'new_password'],
            self::SCENARIO_LOGIN => ['phone', 'email', 'password'],
            self::SCENARIO_CHECKOUT => ['phone', 'email', 'password'],
            self::SCENARIO_PROFILE_UPDATE => ['email', 'sex', 'avatar'],
        ];
    }

    public function behaviors()
    {
        return [
            TimestampBehavior::className(),
            [
                'class' => UploadBehavior::className(),
                'attribute' => 'avatar',
                'scenarios' => ['profile'],
                'path' => '@webroot/upload/avatar/',
                'url' => '@web/upload/avatar/',
            ],
        ];
    }

    public function rules()
    {
        return [
            [['email', 'password', 'phone'], 'required', 'on' => [self::SCENARIO_INSERT, self::SCENARIO_CHECKOUT], 'message' => '{attribute} не может быть пустым'],
            [['email', 'password'], 'required', 'on' => self::SCENARIO_LOGIN, 'message' => '{attribute} не может быть пустым'],

            ['password', 'string'],
            ['groups', 'string'],

            [['phone'], 'string', 'max' => 25],
            ['phone', 'default', 'value' => null],
            ['phone', 'uniquePhoneLogin', 'on' => self::SCENARIO_INSERT],
            [
                ['phone'],
                'filter',
                'filter' => function ($value) {
                    $value = str_replace('+7', '8', $value);
                    $value = str_replace([' ', '(', ')', '-'], '', $value);
                    return $value;
                }
            ],

            ['email', 'email'],
            ['email', 'unique', 'targetClass' => User::className(), 'except' => self::SCENARIO_LOGIN, 'message' => 'Почта {value} уже занята'],

        ];
    }

    public function uniquePhoneLogin($attribute, $params)
    {
        $value = str_replace('+7', '8', $this->phone);
        $value = str_replace([' ', '(', ')', '-'], '', $value);

        if (self::findOne(['phone' => $value])) {
            $this->addError($attribute, 'Указанный телефон уже занят.');
        }

    }


    public function attributeLabels()
    {
        return [
            'phone' => "Телефон",
            'first_name' => "Фамилия",
            'name' => "Имя",
            'last_name' => "Отчество",
            'email' => "E-Mail",
            'password' => "Пароль",
            'birthday' => "День рождения",
            'sex' => "Пол",
            'avatar' => "Аватар",
            'roleName' => "Группа",
            'created_at' => "Дата регистрации",
            'groups' => "Группа",
        ];
    }

    public static function findByEmail($email)
    {
        return static::findOne(['email' => $email]);
    }

    public function getDiscount()
    {
        return Discount::findByUserId($this->id);
    }

    public static function isRole($roleName)
    {
        if (empty($roleName)) {
            throw new \InvalidArgumentException("Не указана роль для проверки");
        }

        if (Yii::$app->user->isGuest) {
            return false;
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

    public function getGroup()
    {
        /* ругается что не приходит объект, надо бы исправить*/
        // TODO: repair
        try {
            return AuthItem::findOne(['name' => AuthAssignment::findOne(['user_id' => $this->id])->item_name]);
        } catch (\ErrorException $exception) {
            return null;
        }
    }

    public function getDisplay()
    {
        $display_name = null;

        foreach (['first_name', 'name', 'last_name'] as $attr) {
            if (!empty($this->{$attr})) {
                $display_name .= $this->{$attr} . " ";
            }
        }

        if ($display_name === null) {
            $display_name = $this->email;
        }

        return $display_name;
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

    public static function calcCurrentAge($birthday = "17-10-1985")
    {
        $dateOfBirth = $birthday;
        $today = date("Y-m-d");
        $diff = date_diff(date_create($dateOfBirth), date_create($today));
        return $diff->format('%y год и %m месяца');
    }
}