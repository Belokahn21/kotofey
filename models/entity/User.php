<?
/**
 * Developer: Konstantin Vasin by PhpStorm
 * Company: Altasib
 * Time: 2:25
 */

namespace app\models\entity;

use app\models\entity\user\Billing;
use app\models\tool\Debug;
use mohorev\file\UploadBehavior;
use Yii;
use yii\behaviors\TimestampBehavior;
use yii\data\ActiveDataProvider;
use yii\rbac\Assignment;
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
 * @property string $last_name
 * @property string $vk_link
 * @property integer $created_at
 * @property integer $updated_at
 *
 * @property Assignment $roles
 * @property Billing $billing
 * @property Discount $discount
 */
class User extends \yii\db\ActiveRecord implements IdentityInterface
{
	const SCENARIO_INSERT = 'insert';
	const SCENARIO_UPDATE = 'update';
	const SCENARIO_LOGIN = 'login';
	const SCENARIO_CHECKOUT = 'checkout';

	public function scenarios()
	{
		return [
			self::SCENARIO_INSERT => ['phone', 'email', 'password'],
			self::SCENARIO_UPDATE => ['phone', 'email', 'password'],
			self::SCENARIO_LOGIN => ['phone', 'email', 'password'],
			self::SCENARIO_CHECKOUT => ['phone', 'email', 'password'],
		];
	}

	public function behaviors()
	{
		return [
			TimestampBehavior::className(),
			[
				'class' => UploadBehavior::class,
				'attribute' => 'avatar',
				'scenarios' => ['insert', 'update'],
				'path' => '@webroot/upload/avatar/',
				'url' => '@web/upload/avatar/',
			],
		];
	}

	public function rules()
	{
		return [
			[['email', 'password','phone'], 'required', 'on' => [self::SCENARIO_INSERT, self::SCENARIO_CHECKOUT], 'message' => '{attribute} не может быть пустым'],
			[['email', 'password'], 'required', 'on' => self::SCENARIO_LOGIN, 'message' => '{attribute} не может быть пустым'],

			['password', 'string', 'min' => 5, 'max' => 16],

			['phone', 'integer'],
			['phone', 'default', 'value' => null],
			['phone', 'unique', 'targetClass' => User::className(), 'except' => self::SCENARIO_LOGIN, 'message' => 'Номер телефона {value} уже занят'],

			['email', 'email'],
			['email', 'unique', 'targetClass' => User::className(), 'except' => self::SCENARIO_LOGIN, 'message' => 'Почта {value} уже занята'],

		];
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
		];
	}

	public function afterSave($insert, $changedAttributes)
	{
		parent::afterSave($insert, $changedAttributes);

		if ($insert) {
			$billing = new Billing();
			$billing->user_id = $this->id;
			if ($billing->validate()) {
				$billing->save();
			}

			if (!Discount::findOne($this->id)) {
				$discount = new Discount();
				$discount->user_id = $this->id;
				$discount->count = 0;
				if ($discount->validate()) {
					$discount->save();
				}
			}
		}
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

	public function search($params)
	{
		$query = static::find();

		$dataProvider = new ActiveDataProvider([
			'query' => $query,
		]);

		if (!($this->load($params) && $this->validate())) {
			return $dataProvider;
		}

		$query->andFilterWhere(['like', 'email', $this->email]);

		return $dataProvider;
	}
}