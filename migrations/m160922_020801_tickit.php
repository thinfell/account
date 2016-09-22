<?php

use yii\db\Migration;

class m160922_020801_tickit extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB COMMENT="SSO用户通讯表"';
        }

        $this->createTable('tickit', [
            'id' => $this->primaryKey()->notNull()->comment('编号'),
            'webid' => $this->integer()->notNull()->comment('站点编号'),
            'value' => $this->string()->notNull()->comment('密钥'),
            'user_id' => $this->integer()->notNull()->comment('用户编号'),
            'creation_time' => $this->string()->notNull()->comment('生成毫秒时间'),
            'action' => $this->string()->notNull()->comment('使用场景'),
        ], $tableOptions);
    }

    public function down()
    {
        echo "m160922_020801_tickit cannot be reverted.\n";

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
