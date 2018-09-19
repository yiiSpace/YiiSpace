<?php

use yii\db\Migration;

/**
 * Class m180918_075908_create_table_content_album
 */
class m180918_075908_create_table_content_album extends Migration
{
    public function up()
    {
        // $this->down() ;

        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('content_album', [
            'id' => $this->primaryKey(),
            'owner_id' => $this->integer()->comment('所有者的id'), //'所附属的实体的id'

            'name' => $this->string()->notNull()->comment('相册名称'),
            'desc' => $this->string()->defaultValue('')->comment('相册描述'),
            'keywords' => $this->string()->defaultValue('')->comment('相册关键字'),

            'cover_uri' => $this->string()->comment('封面图片'),
            // 'mbr_count' => $this->integer()->defaultValue('0')->comment('成员数量'),
            // 'obj_count' => $this->integer()->defaultValue('0')->comment('成员数量'),
            //'last_obj_id' => $this->integer()->comment('最后一个成员的id'), //'最后一个成员对象的id'
            // 'views' => $this->integer()->notNull()->defaultValue('0')->comment('点击量'),
            'status' => $this->tinyInteger(1)->unsigned()->notNull()->defaultValue('1')->comment('状态'),
            // 'is_hot' => $this->tinyInteger()->notNull()->defaultValue('0')->comment('是否最热'),
            'created_at' => $this->integer()->unsigned()->comment('创建时间'),
            'updated_at' => $this->integer()->unsigned()->comment('更新时间'),

            'created_by' => $this->integer()->unsigned()->comment('创建者id'),
            'updated_by' => $this->integer()->unsigned()->comment('更新者id'),
            // 'privacy' => $this->tinyInteger()->comment('是否私有'),
            // 'privacy_data' => $this->text()->comment('访问策略数据'),
        ], $tableOptions);

        $this->createIndex('cTime', 'content_album', 'created_at');
        $this->createIndex('uid', 'content_album', 'owner_id');
        $this->createIndex('mTime', 'content_album', 'updated_at');
    }

    public function down()
    {
        $this->dropTable('content_album');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m180918_075908_create_table_content_album cannot be reverted.\n";

        return false;
    }
    */
}
