<?php

use yii\db\Migration;

class m160919_021240_feedback_add_hot_grade_column extends Migration
{
    public $tableName = '{{%feedback}}';

    public function up()
    {
        $this->addColumn($this->tableName,'hot_grade',$this->smallInteger(3)->notNull()->defaultValue(0)->comment('是否热门'));
    }

    public function down()
    {
        $this->dropColumn($this->tableName,'hot_grade');
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
