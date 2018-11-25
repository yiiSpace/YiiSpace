<?php

use yii\db\Migration;

/**
 * Class m180921_072906_create_table_article_category
 */
class m180921_072906_create_table_content_article_category extends Migration
{

protected  $tableName = 'content_article_category' ;
 
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
        $this->createTable($tableName , [
            'id' => $this->primaryKey()->unsigned(),
            // 'position_code' => $this->string()->comment('位置码id site_page_position.ref_code'),
            'parent_id' => $this->integer()->unsigned()->notNull()->defaultValue('0')->comment('上级分类'),
            'name' => $this->string()->notNull()->comment('名称'),
            // 'ref_alias' => $this->string()->notNull()->defaultValue('')->comment('程序识别名称'),
            // 'thumb_uri' => $this->string()->defaultValue('')->comment('缩略图'),
            'display_order' => $this->tinyInteger()->unsigned()->notNull()->defaultValue('0')->comment('显示顺序'),

            'mbr_count' => $this->integer()->unsigned()->notNull()->defaultValue('0')->comment('孩子数量'),
            'page_size' => $this->tinyInteger()->unsigned()->notNull()->defaultValue('10')->comment('每页显示数量'),
            'status' => $this->tinyInteger()->notNull()->defaultValue('1')->comment('状态 启用 关闭等'),
            'redirect_url' => $this->string()->notNull()->defaultValue('')->comment('跳转地址'),
            // 'display_type' => $this->string()->notNull()->defaultValue('list')->comment('显示方式'),
            //  'create_time' => $this->integer()->unsigned()->notNull()->defaultValue('0')->comment('录入时间'),

            // 'position' => $this->integer()->unsigned()->defaultValue(0)->comment('页面编码位置'), // 比如 左上 右下 左一 ...

            'created_at' => $this->integer()->unsigned()->comment('创建时间'),
            'updated_at' => $this->integer()->unsigned()->comment('更新时间'),

            'created_by' => $this->integer()->unsigned()->comment('创建者id'),
            'updated_by' => $this->integer()->unsigned()->comment('更新者id'),

            /**
             * TODO 有时间提取到其他表去  可以通用的逻辑
             */
//            'seo_keywords' => $this->string()->notNull()->defaultValue('')->comment('seo关键字'),
//            'seo_title' => $this->string()->notNull()->defaultValue('')->comment('seo标题'),
//            'seo_description' => $this->text()->comment('seo描述'),
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
        // return false means can't revert
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m180921_072906_create_table_article_category cannot be reverted.\n";

        return false;
    }
    */
}
