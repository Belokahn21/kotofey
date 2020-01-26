<?php

namespace app\models\entity;

use app\models\services\ReferalService;
use Yii;
use yii\base\UnknownPropertyException;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "users_referal".
 *
 * @property int $id
 * @property int $is_active
 * @property int $user_id
 * @property string $key
 * @property string $key_called
 * @property int $has_rewarded
 * @property int $count_reward
 * @property int $created_at
 * @property int $updated_at
 */
class UsersReferal extends \yii\db\ActiveRecord
{
    public function behaviors()
    {
        return [
            TimestampBehavior::className()
        ];
    }

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'users_referal';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['is_active', 'user_id', 'created_at', 'updated_at'], 'integer'],
            [['user_id', 'key'], 'required'],
            [['key'], 'string', 'max' => 255],
            [['key'], 'unique', 'targetClass' => UsersReferal::className()],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'is_active' => 'Is Active',
            'user_id' => 'User ID',
            'key' => 'Key',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    public function createRefreal($user_id)
    {

        try {
            $referal_called = ReferalService::getInstance()->getCookieValue();
            if ($referal_called !== false) {
                $this->key_called = $referal_called;
            }
        } catch (UnknownPropertyException $exception) {
        }

        $this->user_id = $user_id;
        $this->generateKey();

        if ($this->validate()) {
            if ($this->save()) {
                try {
                    ReferalService::getInstance()->destroyKeyGuest();
                } catch (UnknownPropertyException $exception) {
                }
                return true;
            }
        }

        return false;
    }

    public static function findOneByUserId($user_id)
    {
        return static::findOne(['user_id' => $user_id]);
    }

    public static function findOneByKey($key)
    {
        return static::findOne(['key' => $key]);
    }

    public function generateKey()
    {
        $this->key = substr(md5(time() . rand()), 0, 20);
    }

    public function isOwner($key)
    {
        return $this->key === $key;
    }

    public function getCalled()
    {
        return static::findOneByKey($this->key_called);
    }
}
