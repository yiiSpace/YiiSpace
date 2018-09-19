<?php

use yii\db\Schema;
use yii\db\Migration;

class m140731_162607_init_status_module extends Migration
{
    use year\helpers\MigrationTrait;

    public function up()
    {
        $tableOptions = $this->getTableOptions() ;

        $this->createTable('{{%status}}', [
            'id'            => Schema::TYPE_BIGPK,
            'content'      => Schema::TYPE_TEXT . self::$NOT_NULL,
            'type'         => Schema::TYPE_STRING . '(120)'.self::$NOT_NULL,
            'creator_id' => Schema::TYPE_INTEGER. self::$NOT_NULL,
            'create_at'      => Schema::TYPE_INTEGER . self::$NOT_NULL,

            'profile_id' => Schema::TYPE_INTEGER . self::$NOT_NULL,
            'approved' => Schema::TYPE_SMALLINT.self::$NOT_NULL .' default 1 '
        ], $tableOptions);

        $this->createIndex('idx_status_create_at', '{{%status}}', 'create_at', false);

        $this->createTable('{{%status_plugin}}', [
            'id'        => Schema::TYPE_STRING . '(120)',
            'name'           => Schema::TYPE_STRING . '(255)',
            'active'   => Schema::TYPE_SMALLINT .self::$NOT_NULL. 'default 1 ',
            'handler' => Schema::TYPE_STRING . '(255)'. self::$NOT_NULL,

            // TODO need description ，from_module .. db field !!!
            'is_core'    => Schema::TYPE_SMALLINT . self::$NOT_NULL.' default 1 ',
        ], $tableOptions);

        $this->addPrimaryKey('pk_status_plugin_id', '{{%status_plugin}}', 'id');
    }

    public function down()
    {
        $this->dropTable('{{%status}}');
        $this->dropTable('{{%status_plugin}}');
    }
}
