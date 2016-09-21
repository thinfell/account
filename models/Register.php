<?php

namespace app\models;

use Yii;
use yii\base\Model;

class Register extends Model
{
    public $mobile;
    public $SMS;
    public $password;
    public $password_repeat;
    public $agreeLicence = true;
    public $smsid;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['mobile', 'password', 'password_repeat', 'SMS'], 'required'],
            [['mobile', 'password', 'password_repeat', 'SMS'], 'trim'],

            [['agreeLicence'], 'boolean'],
            [['agreeLicence'], 'compare', 'compareValue' => true, 'operator' => '==', 'message' => '必须同意注册协议。'],

            [['password', 'password_repeat'], 'string', 'min' => 6, 'max' => 16, 'message' => '{attribute}位数为6至16位。'],
            ['password_repeat', 'compare', 'compareAttribute' => 'password', 'operator' => '===', 'message' => '两次输入的密码不一致。'],

            [['mobile'], 'match', 'pattern' => '/^1[34578]{1}\d{9}$/', 'message' => '手机号格式不正确。'],
            ['mobile', 'unique', 'targetClass' => '\app\models\User', 'message' => '手机号已被注册。'],

            [['SMS'], 'string', 'min' => 4, 'max' => 4, 'message' => '{attribute}最少四位数。'],
            ['SMS', 'validateSMS'],

            [['smsid'], 'integer'],
        ];
    }

    public function validateSMS($attribute, $params)
    {
        if (!$this->hasErrors()) {

            $SMS = Sms::find()->where(['mobile' => $this->mobile, 'sms' => $this->SMS, 'id' => $this->smsid])->one();
            if (!$SMS){
                $this->addError($attribute, '验证码错误。');
            }elseif (time() - $SMS->send_time > 300) {
                $this->addError($attribute, '验证码超过5分钟有效期。');
            }
        }
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'mobile' => '手机号',
            'password' => '密码',
            'password_repeat' => '确认密码',
            'SMS' => '短信动态码',
            'agreeLicence' => '同意注册协议',
        ];
    }

    public function signup()
    {
        if (!$this->validate()) {
            return null;
        }

        $user = new User();
        $user->status = 1;
        $user->name = 'clt'.$this->mobile;
        $user->mobile = $this->mobile;
        $user->setPassword($this->password);
        $user->generateAuthKey();

        return $user->save() ? true : null;
    }
}
