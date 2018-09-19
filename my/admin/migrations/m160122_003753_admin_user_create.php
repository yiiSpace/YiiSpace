<?php

use yii\db\Migration;

class m160122_003753_admin_user_create extends Migration
{

    public $table = 'ys_admin'; // 表名可配置 从module获取

    public function down()
    {
        echo "m160122_003753_admin_user_create cannot be reverted.\n";

        return false;
    }


    // Use safeUp/safeDown to run migration code within a transaction
    public function safeUp()
    {
        $this->createTable($this->table,[
           'id'=>$this->primaryKey(),
            'name'=>$this->string(60)->unique()->notNull(),
            'email'=>$this->string(255),
            'password'=>$this->string(64) ,// md5
            'salt'=>$this->string(255),
            'last_ip'=>$this->string(64),
            'last_time'=>$this->integer(),
            'created_at'=>$this->integer(),
        ]);

    }

    public function safeDown()
    {
        $this->dropTable($this->table) ;
    }

}
