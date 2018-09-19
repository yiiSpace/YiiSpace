<?php

use yii\db\Migration;

/**
 * Class m180918_085154_create_table_content_photo
 */
class m180918_085154_create_table_content_photo extends Migration
{

    public function safeUp()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('content_photo', [
            'id' => $this->primaryKey()->unsigned(),
            'owner_id' => $this->integer()->comment('所有者的id'),
            'album_id' => $this->integer()->defaultValue('0')->comment('相册id'),
            // 'use_for' => $this->string(),
            'title' => $this->string()->defaultValue('')->comment('图片标题'),
            'desc' => $this->text()->comment('图片描述'),
            'uri' => $this->string()->notNull()->comment('original uploaded image'),
            'ext' => $this->string()->notNull()->defaultValue('')->comment('图片扩展名'),
            'size' => $this->string()->defaultValue('')->comment('图片大小'),
           // 'tags' => $this->string()->notNull()->defaultValue(''),
           // 'is_featured' => $this->tinyInteger()->notNull()->defaultValue('0'),
           // 'status' => $this->string()->notNull()->defaultValue('pending'),
            'hash' => $this->string(32)->notNull()->defaultValue('')->comment('图片哈希'),

            'created_at' => $this->integer()->unsigned()->comment('创建时间'),
            'updated_at' => $this->integer()->unsigned()->comment('更新时间'),

            'created_by' => $this->integer()->unsigned()->comment('创建者id'),
            'updated_by' => $this->integer()->unsigned()->comment('更新者id'),

        ], $tableOptions);

        $this->createIndex('Hash', 'content_photo', 'hash', true);
        $this->createIndex('cTime', 'content_photo', 'created_at');
        $this->createIndex('uid', 'content_photo', 'owner_id');
        $this->createIndex('mTime', 'content_photo', 'updated_at');

        $this->createIndex('updater', 'content_photo', 'updated_by');
        $this->createIndex('author', 'content_photo', 'created_by');
    }

    public function safeDown()
    {
        $this->dropTable('content_photo');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m180918_085154_create_table_content_photo cannot be reverted.\n";

        return false;
    }
    */
}
