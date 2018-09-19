<?php
/**
 * Template for migrations.
 * Property named `MigrateController.templateView` controls what
template to use.
 */
echo "<?php\n";
?>
/**
 * TODO: Migration explanation.
 */
class <?= $className ?> extends \yii\db\Migration
{
    public function safeUp()
    {
    // TODO: migration routine contents.
    }

    public function safeDown()
    {
    // TODO: migration rollback contents.
    }
}