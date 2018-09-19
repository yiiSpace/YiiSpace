<?php

use yii\db\Migration;

class m160203_015637_type_init extends Migration
{
    /*
    public function up()
    {

    }

    public function down()
    {
        echo "m160203_015637_type_init cannot be reverted.\n";

        return false;
    }
   */
    public $table = 'lang_type';
    // Use safeUp/safeDown to run migration code within a transaction
    public function safeUp()
    {
        $this->createTable(
          $this->table,
            [
                'id'=>$this->primaryKey(),
                'lang_id'=>$this->integer()->notNull(),
                'name'=>$this->string(120)->notNull(),
                'memory_usage_info'=>$this->string(512),
                'related_modules'=>$this->string(512), // 相关模块
            ]
        );
    }

    public function safeDown()
    {
        $this->dropTable($this->table);
    }
}
