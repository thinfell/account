<?php

use yii\db\Migration;

class m160919_091334_sms extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB COMMENT="短信动态码"';
        }

        $this->createTable('sms', [
            'id' => $this->primaryKey()->comment('短信编号'),
            'mobile' => $this->string(11)->notNull()->comment('手机号'),
            'sms' => $this->string(6)->notNull()->comment('验证码'),
            'send_time' => $this->integer(20)->notNull()->comment('发送时间'),
            'action' => $this->string()->notNull()->comment('使用场景'),
        ], $tableOptions);
    }

    public function down()
    {
        echo "m160919_091334_sms cannot be reverted.\n";

        return false;
    }

    /*
    // Use safeUp/safeDown to run migration code within a transaction
    public function safeUp()
    {
    }

    public function safeDown()
    {
    }
    */
}
