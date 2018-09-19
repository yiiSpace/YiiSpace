<?php

use yii\db\Migration;

class m160203_020156_lang_init extends Migration
{

    public $table = 'language' ;

    public function up()
    {
        $this->createTable($this->table,[
           'id'=>$this->primaryKey(),
            'name'=>$this->string(80),
            'description'=>$this->text(),
            'paradigm'=>$this->string(20), // enum: OOP | Functional
            'created_at'=>$this->integer()->defaultValue(0),
            'updated_at'=>$this->integer()->defaultValue(0),
        ]);
    }

    public function down()
    {
        /*
        echo "m160203_020156_lang_init cannot be reverted.\n";

        return false;
        */
        $this->dropTable($this->table) ;
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
