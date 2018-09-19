<?php

use yii\db\Migration;

class m160203_022414_lang_type_casting_init extends Migration
{

    /*
    public function up()
    {

    }

    public function down()
    {
        echo "m160203_022414_lang_type_casting_init cannot be reverted.\n";

        return false;
    }
    */

    public $table = 'lang_type_casting'; // alias type converting

    // Use safeUp/safeDown to run migration code within a transaction
    public function safeUp()
    {
        $this->createTable(
            $this->table,
            [
                'id'=>$this->primaryKey(),
                'from_type_id'=>$this->integer(),
                'to_type_id'=>$this->integer(),
                'example'=>$this->text(),
            ]
        );
    }

    public function safeDown()
    {
        $this->dropTable($this->table);
    }

}
