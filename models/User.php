<?php

namespace app\models;

use Yii;
use yii\base\NotSupportedException;
use yii\db\ActiveRecord;
use yii\validators\EmailValidator;
use yii\web\IdentityInterface;

/**
 * This is the model class for table "user".
 *
 * @property integer $id
 * @property string $name
 * @property string $avatar
 * @property string $mobile
 * @property string $email
 * @property string $password_hash
 * @property integer $status
 * @property string $auth_key
 */
class User extends ActiveRecord implements IdentityInterface
{
    const STATUS_DELETED = 0;
    const STATUS_ACTIVE = 1;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'user';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'mobile'], 'required'],
            [['status'], 'integer'],
            [['name', 'avatar', 'email', 'password_hash'], 'string', 'max' => 255],
            [['mobile'], 'string', 'max' => 11],
            [['auth_key'], 'string', 'max' => 32],
            [['name'], 'unique'],
            [['mobile'], 'unique'],
            [['email'], 'unique'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => '用户ID',
            'name' => '用户名',
            'avatar' => '头像',
            'mobile' => '手机号',
            'email' => '邮箱',
            'password_hash' => '密码',
            'status' => '状态',
            'auth_key' => 'Auth Key',
        ];
    }

    public function setPassword($password)
    {
        $this->password_hash = Yii::$app->security->generatePasswordHash($password);
    }

    public function generateAuthKey()
    {
        $this->auth_key = Yii::$app->security->generateRandomString();
    }

    public static function getUser($account)
    {
        $type = self::getAccountType($account);
        switch ($type) {
            case 'name' :
                $UserData = User::find()->where(['name' => $account])->one();
                break;
            case 'email' :
                $UserData = User::find()->where(['email' => $account])->one();
                break;
            case 'mobile' :
                $UserData = User::find()->where(['mobile' => $account])->one();
                break;
            default :
                $UserData = User::find()->where(['name' => $account])->one();
                break;
        }
        return $UserData;
    }

    public function getUserByMobile($mobile)
    {
        return $UserData = User::find()->where(['mobile' => $account])->one();
    }

    public static function getAccountType($account)
    {
        $EmailValidator = new EmailValidator();
        if (preg_match('/^1[34578]{1}\d{9}$/', $account)) {
            $type = 'mobile';
        } elseif ($EmailValidator->validate($account)) {
            $type = 'email';
        } else {
            $type = 'name';
        }
        return $type;
    }

    //下面是登录五件套

    public static function findIdentity($id)
    {
        return static::findOne(['id' => $id, 'status' => self::STATUS_ACTIVE]);
    }

    public static function findIdentityByAccessToken($token, $type = null)
    {
        throw new NotSupportedException('"findIdentityByAccessToken" is not implemented.');
    }

    public function getId()
    {
        return $this->id;
    }

    public function getAuthKey()
    {
        return $this->auth_key;
    }

    public function validateAuthKey($authKey)
    {
        return $this->getAuthKey() === $authKey;
    }

}
