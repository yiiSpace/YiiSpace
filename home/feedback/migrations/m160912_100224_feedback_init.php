<?php

use yii\db\Migration;

class m160912_100224_feedback_init extends Migration
{
    public $tableName = '{{%feedback}}';

    public function up()
    {
        $this->createTable($this->tableName,[
            // 基本信息
            'id'=>$this->primaryKey(),

            // 类别:
            'cate_id'=>$this->smallInteger(4)->notNull()->defaultValue(0)->comment('类别'),
            // 类型: 咨询 投诉 建议 向局长反映问题
            'type_id'=>$this->smallInteger(4)->notNull()->comment('类型'),

            'username'=>$this->string(32)->notNull()->comment('反映人姓名'),
            'id_card'=>$this->string(20)->notNull()->comment('身份证号'),
            'tel'=>$this->string(20)->notNull()->comment('联系电话'),
            'contact_address'=>$this->string(255)->notNull()->comment('联系地址'),

            'subject'=>$this->string(120)->notNull()->comment('来信主题'),
            // 'body'=>$this->string(1024)->notNull()->comment('来信主题'),
            'body'=>$this->text()->notNull()->comment('来信内容'),

            'reply_department'=>$this->string(32)->comment('答复部门'),
            'reply_at'=>$this->integer()->comment('答复时间'),
            'reply_content'=>$this->text()->comment('答复结果'),

            'admin_updated_by'=>$this->integer()->notNull()->defaultValue(0)->comment('管理员修改者id'),

            'created_at'=>$this->integer()->notNull()->defaultValue(0)->comment('创建时间'),
            'updated_at'=>$this->integer()->notNull()->defaultValue(0)->comment('最后修改时间'),

            'status'=>$this->smallInteger(1)->notNull()->defaultValue(0)->comment('状态'),
        ]);
    }

    public function down()
    {
        $this->dropTable($this->tableName) ;
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
