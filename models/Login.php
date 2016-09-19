<?php

namespace app\models;

use Yii;
use yii\base\Model;


class Login extends Model
{
    public $account;
    public $password;
    public $mobile;
    public $SMS;
    public $rememberMe = true;
    public $smsid;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['account', 'password', 'mobile', 'SMS'], 'trim'],

            [['account', 'password'], 'required', 'on' => 'default'],
            ['password', 'validatePassword', 'on' => 'default'],

            [['mobile', 'SMS'], 'required', 'on' => 'mobile'],
            [['smsid'], 'integer', 'on' => 'mobile'],
            [['mobile'], 'match', 'pattern' => '/^1[34578]{1}\d{9}$/', 'message' => '手机号格式不正确', 'on' => 'mobile'],
            ['mobile', 'exist', 'targetClass' => '\app\models\User', 'message' => '手机号未注册,请注册后登录。', 'on' => 'mobile'],
            [['SMS'], 'string', 'min' => 4, 'max' => 4, 'message' => '{attribute}最少四位数。', 'on' => 'mobile'],
            ['SMS', 'validateSMS', 'on' => 'mobile'],

            ['rememberMe', 'boolean'],
        ];
    }

    public function validateSMS($attribute, $params)
    {
        if (!$this->hasErrors()) {

            $SMS = Sms::find()->where(['mobile' => $this->mobile, 'sms' => $this->SMS, 'id' => $this->smsid])->one();
            if (!$SMS){
                $this->addError($attribute, '验证码错误');
            }elseif (time() - $SMS->send_time > 300) {
                $this->addError($attribute, '验证码超过5分钟有效期');
            }
        }
    }

    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        return [
            'default' => ['account', 'password', 'rememberMe'],
            'mobile' => ['mobile', 'SMS', 'rememberMe', 'smsid'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'account' => '账号',
            'password' => '密码',
            'mobile' => '手机号',
            'SMS' => '动态密码',
            'rememberMe' => '下次自动登录',
        ];
    }

    public function validatePassword($attribute, $params)
    {
        if (!$this->hasErrors()) {
            $user = User::getUser($this->account);
            $password_hash = $user->password_hash;
            if (!$user || !Yii::$app->security->validatePassword($this->password, $password_hash)) {
                $this->addError($attribute, '账号或密码错误');
            }
        }
    }

    public function Login()
    {
        if ($this->validate()) {
            return Yii::$app->user->login(User::getUser($this->account), $this->rememberMe ? 3600 * 24 * 30 : 0);
        } else {
            return false;

        }
    }

    public function MobileLogin()
    {
        if ($this->validate()) {
            return Yii::$app->user->login(User::getUserByMobile($this->mobile), $this->rememberMe ? 3600 * 24 * 30 : 0);
        } else {
            return false;

        }
    }

}
