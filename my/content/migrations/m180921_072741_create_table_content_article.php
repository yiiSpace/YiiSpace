<?php

use yii\db\Migration;

/**
 * Class m180921_072741_create_table_article
 */
class m180921_072741_create_table_content_article extends Migration
{
    protected  $tableName = 'content_article' ;
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $tableName = $this->tableName ;
        $this->createTable($tableName, [
            'id' => $this->primaryKey()->unsigned(),
            'cate_id' => $this->integer()->notNull()->comment('分类id'),
            'title' => $this->string()->notNull()->comment('标题'),
           // 'title_alias' => $this->char()->notNull()->comment('标题别名'),
            'intro' => $this->text()->comment('简单描述 tease'),
            'content' => $this->text()->notNull()->comment('内容'),

            'rep_thumb' => $this->string()->notNull()->defaultValue('')->comment('代表性小图片'),
            'display_order' => $this->tinyInteger()->unsigned()->notNull()->defaultValue('0')->comment('排序'),
            'view_count' => $this->integer()->unsigned()->notNull()->defaultValue('0')->comment('查看次数'),
            'status' => $this->tinyInteger()->notNull()->defaultValue('1')->comment('状态'),

            // 'creator_id' => $this->integer()->notNull()->defaultValue('0')->comment('创建者id  一般是管理员的id'),
            'created_at' => $this->integer()->unsigned()->comment('创建时间'),
            'updated_at' => $this->integer()->unsigned()->comment('更新时间'),

            'created_by' => $this->integer()->unsigned()->comment('创建者id'),
            'updated_by' => $this->integer()->unsigned()->comment('更新者id'),

//            'seo_title' => $this->string()->notNull()->defaultValue('')->comment('SEO标题'),
//            'seo_keywords' => $this->string()->notNull()->defaultValue('')->comment('SEO KEYWORDS'),
//            'seo_description' => $this->text()->comment('SEO DESCRIPTION'),
        ], $tableOptions);

        $this->createIndex('cTime', $tableName, 'created_at');
        $this->createIndex('uid', $tableName, 'created_by');
        $this->createIndex('mTime', $tableName, 'updated_at');
        $this->createIndex('ordering', $tableName, 'display_order');
    }

    /**
     * {@inheritdoc}
     */
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
        echo "m180921_072741_create_table_article cannot be reverted.\n";

        return false;
    }
    */
}
