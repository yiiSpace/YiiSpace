## 添加列 并指定列顺序

自： [yii2-comments](https://github.com/rmrevin/yii2-comments)

>
    use yii\db\Migration;
    class m151005_165040_comment_from extends Migration
    {
        public function up()
        {
            $this->addColumn('{{%comment}}', 'from', $this->string() . ' AFTER [[entity]]');
        }
        
        
        
## 一个迁移中涉及多个表 表名处理：

自：[yii2-eav demo](https://github.com/yarcode/yii2-eav/blob/master/examples/m140423_034003_object.php)
>
        <?php
        use yii\db\Schema;
        class m140423_034003_object extends \yii\db\Migration
        {
            public $tables;
            public function init()
            {
                $entityName = 'object';
                $this->tables = [
                    'category' => "{{%{$entityName}_category}}",
                    'entity' => "{{%{$entityName}}}",
                    'attribute' => "{{%{$entityName}_attribute}}",
                    'attribute_type' => "{{%{$entityName}_attribute_type}}",
                    'value' => "{{%{$entityName}_attribute_value}}",
                    'option' => "{{%{$entityName}_attribute_option}}",
                ];
            }
            public function up()
            {
                $options = $this->db->driverName == 'mysql' ? 'ENGINE=InnoDB' : null;
                $this->createTable($this->tables['entity'], [
                    'id' => Schema::TYPE_PK,
                    'categoryId' => Schema::TYPE_INTEGER,
                ], $options);
                $this->createTable($this->tables['category'], [
                    'id' => Schema::TYPE_PK,
                    'seoName' => Schema::TYPE_STRING,
                    'name' => Schema::TYPE_STRING,
                ], $options);
            ...