<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "tickit".
 *
 * @property integer $id
 * @property string $value
 * @property integer $user_id
 * @property string $creation_time
 * @property string $action
 */
class Tickit extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'tickit';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['value', 'user_id', 'creation_time', 'action'], 'required'],
            [['user_id'], 'integer'],
            [['value', 'creation_time', 'action'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => '编号',
            'value' => '密钥',
            'user_id' => '用户编号',
            'creation_time' => '生成毫秒时间',
            'action' => '使用场景',
        ];
    }
}
