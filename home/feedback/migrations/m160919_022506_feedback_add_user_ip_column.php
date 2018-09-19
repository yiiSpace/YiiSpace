<?php

use yii\db\Migration;

class m160919_022506_feedback_add_user_ip_column extends Migration
{
    public $tableName = '{{%feedback}}';

    public function up()
    {
        // Yii::$app->request->getUserIP() // ip v6 128位
        $this->addColumn($this->tableName,'user_ip',$this->string(130)->notNull()->defaultValue('127.0.0.1')->comment('用户ip地址'));
    }

    public function down()
    {
        $this->dropColumn($this->tableName,'user_ip');
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
