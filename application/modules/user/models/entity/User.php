<?php

namespace app\modules\user\models\entity;

use Yii;
use ErrorException;
use yii\db\ActiveRecord;
use InvalidArgumentException;
use yii\web\IdentityInterface;
use mohorev\file\UploadBehavior;
use yii\behaviors\TimestampBehavior;
use app\modules\rbac\models\entity\AuthItem;
use app\modules\rbac\models\entity\AuthAssignment;

/**
 * User model
 *
 * @property integer $id
 * @property string $login
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
 * @property UserBilling $billing
 */
class User extends ActiveRecord implements IdentityInterface
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
            self::SCENARIO_UPDATE => ['phone', 'email', 'password', 'groups', 'new_password', 'name', 'first_name', 'last_name', 'sex', 'login'],
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

            ['login', 'string'],
            ['login', 'unique'],

            ['password', 'string'],
            ['groups', 'safe'],

            [['phone'], 'string', 'max' => 25],
            ['phone', 'default', 'value' => null],
            [
                ['phone'],
                'filter',
                'filter' => function ($value) {
                    $value = str_replace('+7', '8', $value);
                    return str_replace([' ', '(', ')', '-'], '', $value);
                },
                'on' => self::SCENARIO_INSERT
            ],

            ['email', 'email'],
            ['email', 'unique', 'targetClass' => User::className(), 'except' => self::SCENARIO_LOGIN, 'message' => 'Почта {value} уже занята'],

        ];
    }

    public function attributeLabels()
    {
        return [
            'login' => "Логин/Ник нейм",
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

    public static function findByPhone($phone)
    {
        return static::findOne(['phone' => $phone]);
    }

    public static function isRole($roleName)
    {
        if (Yii::$app->user->isGuest) {
            return false;
        }

        $user_id = Yii::$app->user->identity->id;
        $roles = Yii::$app->authManager->getRolesByUser($user_id);

        if (!empty($roles)) {
            foreach ($roles as $key => $role) {
                if (strcasecmp($role->name, $roleName) == 0) {
                    return true;
                }
            }
        }

        return false;
    }

//    public function getBilling()
//    {
//        return UserBilling::findByUser($this->id);
//    }

    public function getGroup()
    {
        return AuthItem::find()->where(['name' => AuthAssignment::findOne(['user_id' => $this->id])->item_name])->all();
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
        return static::findOne(['access_token' => $token]);
    }

    public static function findByUsername($username)
    {
        return static::findOne(['username' => $username]);
    }

    public function generateAccessToken($expireInSeconds)
    {
        $this->access_token = Yii::$app->security->generateRandomString() . '_' . (time() + $expireInSeconds);
    }

    public function isAccessTokenValid()
    {
        if (!empty($this->access_token)) {
            $timestamp = (int)substr($this->access_token, strrpos($this->access_token, '_') + 1);
            return $timestamp > time();
        }
        return false;
    }
}