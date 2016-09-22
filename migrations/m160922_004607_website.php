<?php

use yii\db\Migration;

class m160922_004607_website extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB COMMENT="站点表"';
        }

        $this->createTable('website', [
            'id' => $this->primaryKey()->comment('站点编号'),
            'name' => $this->string()->notNull()->comment('名称'),
            'url' => $this->string()->notNull()->comment('网址'),
            'secret' => $this->string()->notNull()->comment('密钥'),
        ], $tableOptions);
    }

    public function down()
    {
        echo "m160922_004607_website cannot be reverted.\n";

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
