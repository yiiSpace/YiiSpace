<?php

use yii\db\Schema;
use yii\db\Migration;

class m140728_070134_create_user_table extends Migration
{

    /**
     * not null specification
     * see communitiyii/yii2-user
     */
    const NN = ' NOT NULL';
    // default timestamp
    const DT = " DEFAULT '0000-00-00 00:00:00'";

    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = ' CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB';
        }

        // Table # 1: User
        $this->createTable('{{%user}}', [
            'id' => Schema::TYPE_BIGPK,
            'username' => Schema::TYPE_STRING . self::NN,
            'email' => Schema::TYPE_STRING . self::NN,
            // 'icon_url' => Schema::TYPE_STRING . self::NN,
            'icon_url' => Schema::TYPE_STRING,
            'password' => Schema::TYPE_STRING . self::NN,
            'salt' => Schema::TYPE_STRING . self::NN,
            'status' => Schema::TYPE_SMALLINT . self::NN . ' DEFAULT 0',
            'last_login_ip' => Schema::TYPE_STRING . '(50)',
            'last_active_at' => Schema::TYPE_INTEGER . self::NN . ' DEFAULT 0',
            // 'created_at' => Schema::TYPE_TIMESTAMP . self::NN . self::DT,
            'created_at' => Schema::TYPE_INTEGER . self::NN,
        ], $tableOptions);
        $this->createIndex('{{%user_UK1}}', '{{%user}}', 'username', true);
        $this->createIndex('{{%user_UK2}}', '{{%user}}', 'email', true);
        $this->createIndex('{{%user_NU1}}', '{{%user}}', 'status');


    }

    public function down()
    {
        $this->dropTable('{{%user}}');
        echo 'user table dropped successfully ';
    }
}
