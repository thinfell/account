<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "sms".
 *
 * @property integer $id
 * @property string $mobile
 * @property string $sms
 * @property integer $send_time
 */
class Sms extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'sms';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['mobile', 'sms', 'send_time', 'action'], 'required'],
            [['send_time'], 'integer'],
            [['mobile'], 'string', 'max' => 11],
            [['mobile'], 'match', 'pattern' => '/^1[34578]{1}\d{9}$/', 'message' => '手机号格式不正确。'],
            [['sms'], 'string', 'max' => 6],
            [['action'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => '短信编号',
            'mobile' => '手机号',
            'sms' => '验证码',
            'send_time' => '发送时间',
            'action' => '使用场景',
        ];
    }
}
