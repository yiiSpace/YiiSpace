<?php

use yii\db\Migration;

/**
 * Class m181220_063124_dept_init
 */
class m181220_063124_dept_init extends Migration
{
    /**
     * 部门表
     *
     * @var string
     */
    protected  $tableName = 'org_dept' ;

    public function safeUp()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable($this->tableName, [
            'id' => $this->primaryKey()->unsigned(),
            'parent_id' => $this->integer()->unsigned()
                ->notNull()->defaultValue('0')->comment('上级分类'),

            'name' => $this->string()->notNull()->comment('部门名称'),
            'description' => $this->string()->notNull()->comment('部门描述'),

            // 'thumb_uri' => $this->string()->defaultValue('')->comment('缩略图'),
            'display_order' => $this->tinyInteger()->unsigned()
                ->notNull()->defaultValue('0')->comment('显示顺序'),

            'status' => $this->tinyInteger()->notNull()
                ->defaultValue('1')->comment('状态'),
            // todo 是否需要 tree_path?

            'created_at' => $this->integer()->unsigned()->comment('创建时间'),
            'updated_at' => $this->integer()->unsigned()->comment('更新时间'),

            'created_by' => $this->integer()->unsigned()->comment('创建者id'),
            'updated_by' => $this->integer()->unsigned()->comment('更新者id'),

        ], $tableOptions);

        $this->createIndex('cTime', $this->tableName, 'created_at');
        $this->createIndex('mTime', $this->tableName, 'updated_at');

        $this->createIndex('updater', $this->tableName, 'updated_by');
        $this->createIndex('author', $this->tableName, 'created_by');
    }

    public function safeDown()
    {
        $this->dropTable($this->tableName);
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m181220_063124_dept_init cannot be reverted.\n";

        return false;
    }
    */
}
