<?php

use yii\db\Migration;

/**
 * Class m181220_071422_org_init
 */
class m181220_071422_org_init extends Migration
{
    /**
     * organization
     *
     * 组织机构表|企业表
     *
     * @see https://www.cnblogs.com/pingkeke/archive/2010/05/28/1746441.html
     * @see https://blog.csdn.net/wangpeng047/article/details/7280800
     * @see https://apexplained.wordpress.com/2013/04/20/the-emp-and-dept-tables-in-oracle/
     *
     * todo: 职位表 | 岗位表   区别？ （position job|title？）
     * @see https://github.com/lock-upme/OPMS/blob/master/models/users/positions.go
     *
     * @var string
     */
    protected  $tableName = 'org' ; // organization

    public function safeUp()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable($this->tableName, [
            'id' => $this->primaryKey()->unsigned(),

            'name' => $this->string()->notNull()->comment('部门名称'),
            'description' => $this->string()->notNull()->comment('部门描述'),


            'status' => $this->tinyInteger()->notNull()
                ->defaultValue('1')->comment('状态'),
            // todo：location(lan lat 企业地址)

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
        echo "m181220_071422_org_init cannot be reverted.\n";

        return false;
    }
    */
}
