<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "website".
 *
 * @property integer $id
 * @property string $name
 * @property string $url
 * @property string $secret
 */
class Website extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'website';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'url'], 'required'],
            [['name', 'url', 'secret'], 'string', 'max' => 255],
            ['url', 'url'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => '站点编号',
            'name' => '名称',
            'url' => '网址',
            'secret' => '密钥',
        ];
    }
}
