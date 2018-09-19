<?php

use yii\db\Migration;

class m160203_020739_lang_type_operator_init extends Migration
{
    /*
    public function up()
    {

    }

    public function down()
    {
        echo "m160203_020739_lang_type_operator_init cannot be reverted.\n";

        return false;
    }

      */

    public $table = 'lang_type_operator';
    // Use safeUp/safeDown to run migration code within a transaction
    public function safeUp()
    {
        $this->createTable($this->table,
            [
               'id'=>$this->primaryKey(),
                'type_id'=>$this->integer(),
                'name'=>$this->string(80),
                'example'=>$this->string(1024),

            ]);
    }

    public function safeDown()
    {
        $this->dropTable($this->table);
    }

}
