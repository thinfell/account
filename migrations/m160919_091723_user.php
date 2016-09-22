<?php

use yii\db\Migration;

class m160919_091723_user extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB COMMENT="用户信息"';
        }

        $this->createTable('user', [
            'id' => $this->primaryKey()->comment('用户编号'),
            'name' => $this->string()->unique()->notNull()->comment('用户名'),
            'avatar' => $this->string()->defaultValue('')->comment('头像'),
            'mobile' => $this->string(11)->unique()->notNull()->comment('手机号'),
            'email' => $this->string()->defaultValue('')->comment('邮箱'),
            'password_hash' => $this->string()->defaultValue('')->comment('密码'),
            'status' => $this->smallInteger(6)->defaultValue(1)->comment('状态'),
            'auth_key' => $this->string(32)->defaultValue('')->comment('Auth Key'),
        ], $tableOptions);
    }

    public function down()
    {
        echo "m160919_091723_user cannot be reverted.\n";

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
