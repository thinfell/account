<?php

namespace app\models;

use Yii;
use yii\base\Model;

class PasswordReset extends Model
{
    public $account;
    public $SMS;
    public $smsid;
    public $password;
    public $password_repeat;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['account', 'SMS', 'password', 'password_repeat'], 'trim'],

            [['account'], 'required', 'on' => 'index'],

            [['SMS'], 'required', 'on' => 'get'],
            [['smsid'], 'integer', 'on' => 'get'],
            [['SMS'], 'string', 'min' => 4, 'max' => 4, 'message' => '{attribute}最少四位数。', 'on' => 'get'],
            ['SMS', 'validateSMS', 'on' => 'get'],

            [['password', 'password_repeat'], 'required', 'on' => 'set'],
            [['password', 'password_repeat'], 'string', 'min' => 6, 'max' => 16, 'message' => '{attribute}位数为6至16位。', 'on' => 'set'],
            ['password_repeat', 'compare', 'compareAttribute' => 'password', 'operator' => '===', 'message' => '两次输入的密码不一致。', 'on' => 'set'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        return [
            'index' => ['account'],
            'get' => ['SMS', 'smsid'],
            'set' => ['password', 'password_repeat'],
        ];
    }

    public function validateSMS($attribute, $params)
    {
        if (!$this->hasErrors()) {
            $mobile = Yii::$app->session->get('mobile');
            $SMS = Sms::find()->where(['mobile' => $mobile, 'sms' => $this->SMS, 'id' => $this->smsid])->one();
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
    public function attributeLabels()
    {
        return [
            'account' => '账号',
            'mobile' => '手机号',
            'SMS' => '短信动态码',
            'password' => '新密码',
            'password_repeat' => '确认密码',
        ];
    }

    public function index()
    {
        if ($this->validate()) {
            $mobile = User::getUser($this->account);
            if (!$mobile){
                $this->addError('account', '账号不存在');
                return false;
            }else{
                Yii::$app->session->set('mobile', $mobile->mobile);
                Yii::$app->session->set('step', 1);
                return true;
            }
        }else{
            return false;
        }
    }

    public function get()
    {
        if ($this->validate()) {
            Yii::$app->session->set('step', 2);
            return true;
        }else{
            return false;
        }
    }

    public function set()
    {
        if ($this->validate()) {

            $mobile = Yii::$app->session->get('mobile');

            $user = new User();
            $user->setPassword($this->password);
            $user->generateAuthKey();

            $setPassWord = User::find()->where(['mobile' => $mobile])->one();
            $setPassWord->password_hash = $user->password_hash;
            $setPassWord->auth_key = $user->auth_key;
            if($setPassWord->save()){
                Yii::$app->session->remove('mobile');
                Yii::$app->session->set('step', 3);
                return true;
            }else{
                $this->addError('password', $setPassWord->errors);
                return false;
            }
        }else{
            return false;
        }
    }
}
