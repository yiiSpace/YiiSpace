<?php

namespace my\migration\console\controllers;

use Yii;

use yii\console\Controller;
use yii\db\ColumnSchema;
use yii\db\Query;

class DbController extends Controller
{
    /**
     * @var string the directory that stores the migrations. This must be specified
     * in terms of a path alias, and the corresponding directory must exist.
     * Defaults to 'application.runtime' (meaning 'protected/runtime').
     * Copy the created migration into eg. application.migrations to activate it for your project.
     */
    public $migrationPath = '@app/runtime';
    /**
     * @var string database connection component
     */
    public $dbConnection = "db";
    /**
     * @var string wheter to dump a create table statement
     */
    public $createSchema = true;
    /**
     * @var string wheter to dump a insert data statements
     */
    public $insertData = true;
    /**
     * @var string wheter to add truncate table data statements
     */
    public $truncateTable = false;
    /**
     * @var string wheter to disable foreign key checks
     */
    public $foreignKeyChecks = true;
    /**
     * @var string dump only table with the given prefix
     */
    public $prefix = "";
    /**
     * @var string comma-separated list of tables to be excluded
     */
    public $excludeTables = "";
    /**
     * @var string wheter to ignore the migration table
     */
    public $ignoreMigrationTable = true;
    /**
     * @var bool whether to display the Foreign Keys warning
     */
    protected $_displayFkWarning = false;

    /**
     * @var string wheter to ignore autoincrement column values
     */
    public $insertAutoIncrementValues = true;

    /**
     * @param \yii\base\Action $action
     * @return bool
     */
    public function beforeAction($action)
    {
        // your custom code here, if you want the code to run before action filters,
        // wich are triggered on the [[EVENT_BEFORE_ACTION]] event, e.g. PageCache or AccessControl

        if (!parent::beforeAction($action)) {
            return false;
        }

        // other custom code here
        $path = \Yii::getAlias($this->migrationPath);
        if ($path === false || !is_dir($path)) {
            $this->stderr('Error: The migration directory does not exist: ' . $this->migrationPath . "\n");
            return (static::EXIT_CODE_ERROR);
        }
        $this->migrationPath = $path;

        return true; // or false to not run the action
    }

    public function getHelp()
    {
        /*
        $options =  \Yii::getObjectVars($this) ;
        var_dump(array_keys($options)) ;
        */
        echo <<<EOS
Usage: yiic {$this->uniqueId} <action>
Available options: {}
Available actions:
dump [<name>] [--prefix=<table_prefix,...>] [--dbConnection=<db>]
    [--createSchema=<1|0>] [--insertData=<1|0>] [--foreignKeyChecks=<1|0>]
    [--ignoreMigrationTable=<1|0>] [--truncateTable=<0|1>]
    [--insertAutoIncrementValues=<1|0>] [--migrationPath=<application.runtime>]
EOS;


    }

    /**
     * @param string $actionID
     * @return array
     */
    public function options($actionID)
    {
        return array_merge(
            parent::options($actionID),
            ['migrationPath'], // global for all actions
            ($actionID === 'xxx') ? ['templateFile'] : [] // action create
        );
    }

    /**
     * @return \yii\db\Connection
     */
    protected function getDb()
    {
        return \Yii::$app->get($this->dbConnection);
    }

    /**
     * @param $args
     */
    public function actionDump($args = [])
    {
        $db = $this->getDb();
        echo "Connecting to '" . $db->dsn . "'\n";
        $schema = $db->schema;
        $tables = $db->schema->tableSchemas;

        $code = '';
        $code .= $this->indent(2) . "if (\$this->dbConnection->schema instanceof CMysqlSchema) {\n";
        if ($this->foreignKeyChecks == false) {
            $code .= $this->indent(2) . "   \$this->execute('SET FOREIGN_KEY_CHECKS = 0;');\n";
        }
        $code .= $this->indent(2) . "   \$options = 'ENGINE=InnoDB DEFAULT CHARSET=utf8';\n";
        $code .= $this->indent(2) . "} else {\n";
        $code .= $this->indent(2) . "   \$options = '';\n";
        $code .= $this->indent(2) . "}\n";
        $migrationName = (isset($args[0])) ? $args[0] : 'dump';
        if (preg_match('/^[a-z_]\w+$/i', $migrationName) === 0) {
            exit("Invalid class name '$migrationName'\n");
        }
        $migrationClassName = 'm' . date('ymd_His') . "_" . $migrationName;
        $filename = $this->migrationPath . DIRECTORY_SEPARATOR . $migrationClassName . ".php";
        $prefixes = explode(",", $this->prefix);
        $codeTruncate = $codeSchema = $codeForeignKeys = $codeInserts = '';
        echo "Querying tables \n";
        foreach ($tables as $table) {
            $found = false;
            if ($this->ignoreMigrationTable && $table->name == "migration") {
                continue;
            }
            if (in_array($table->name, explode(",", $this->excludeTables))) {
                continue;
            }
            foreach ($prefixes AS $prefix) {
                if (substr($table->name, 0, strlen($prefix)) == $prefix) {
                    $found = true;
                    break;
                }
            }
            if (!$found) {
                continue;
            }
            echo " -> " . $table->name . "\n";
            if ($this->truncateTable == true) {
                $codeTruncate .= $this->generateTruncate($table, $schema);
            }
            if ($this->createSchema == true) {
                $codeSchema .= $this->generateSchema($table, $schema);
                $codeForeignKeys .= $this->generateForeignKeys($table, $schema);
            }
            if ($this->insertData == true) {
                $codeInserts .= $this->generateInserts($table, $schema);
            }
        }
        $code .= $codeTruncate . "\n" . $codeSchema . "\n" . $codeForeignKeys . "\n" . $codeForeignKeys . "\n" . $codeInserts;
        if ($this->foreignKeyChecks == false) {
            $code .= $this->indent(2) . "if (\$this->dbConnection->schema instanceof CMysqlSchema)\n";
            $code .= $this->indent(2) . "   \$this->execute('SET FOREIGN_KEY_CHECKS = 1;');\n";
        }
        $migrationClassCode = $this->renderFile(
            dirname(__DIR__) . '/views/db/migration.php',
            array(
                'migrationClassName' => $migrationClassName,
                'functionUp' => $code
            ),
            true);

        file_put_contents($filename, $migrationClassCode);
        echo "\n\nMigration class successfully created at \n$filename\n\n";
        if ($this->_displayFkWarning) {
            echo <<<EOS
WARNING
Your database include Foreign Keys definitions. Sadly Yii methods don't allow to know the details of the relation, precisely
ON DELETE and ON UPDATE conditions.
Please open the generated file, look for lines with "FIX RELATIONS" comment and adjust them according to your database.
For details about the addForeignKey definition please see here:
    http://www.yiiframework.com/doc/api/1.1/CDbMigration#addForeignKey-detail
EOS;
        }
    }

    private function indent($level = 0)
    {
        return str_repeat("    ", $level);
    }

    private function generateSchema($table, $schema)
    {
        $options = "ENGINE=InnoDB DEFAULT CHARSET=utf8";
        $code = "\n\n\n" . $this->indent(2) . "// Schema for table '" . $table->name . "'\n";
        $code .= $this->indent(2) . '$this->createTable("' . $table->name . '", ';
        $code .= "\n";
        $code .= $this->indent(3) . 'array(' . "\n";
        foreach ($table->columns as $col) {
            $code .= $this->indent(3) . '"' . $col->name . '"=>"' . $this->resolveColumnType($col) . '",' . "\n";
        }
        // special case for non-auto-increment PKs
        $code .= $this->generatePrimaryKeys($table->columns);
        $code .= $this->indent(3) . '), ' . "\n";
        $code .= $this->indent(2) . '$options);';
        return $code;
    }

    private function generatePrimaryKeys($columns)
    {
        foreach ($columns as $col) {
            if ($col->isPrimaryKey && !$col->autoIncrement) {
                return $this->indent(3) . '"PRIMARY KEY (' . $col->name . ')"' . "\n";
            }
        }
    }

    private function generateForeignKeys($table, $schema)
    {
        if (count($table->foreignKeys) == 0) {
            return "";
        }
        $code = "\n\n\n" . $this->indent(2) . "// Foreign Keys for table '" . $table->name . "'\n";
        $code .= $this->indent(2) . "if ((\$this->dbConnection->schema instanceof CSqliteSchema) == false):\n";
        foreach ($table->foreignKeys as $name => $foreignKey) {
            $code .= $this->indent(3) . "\$this->addForeignKey('fk_{$table->name}_{$foreignKey[0]}_{$name}', '{$table->name}', '{$name}', '{$foreignKey[0]}', '{$foreignKey[1]}', null, null); // FIX RELATIONS \n";
        }
        $code .= $this->indent(2) . "endif;\n";
        $this->_displayFkWarning = TRUE;
        return $code;
    }

    private function generateInserts($table, $schema)
    {
        $query = (new Query())
            ->from($table->name);
        $data = $query->createCommand($this->getDb())->query();

        $code = "\n\n\n" . $this->indent(2) . "// Data for table '" . $table->name . "'\n";
        foreach ($data AS $row) {
            $code .= $this->indent(2) . '$this->insert("' . $table->name . '", array(' . "\n";
            foreach ($row AS $column => $value) {
                if ($this->insertAutoIncrementValues == false && $table->columns[$column]->autoIncrement === true) {
                    $value = null;
                }
                $code .= $this->indent(3) . '"' . $column . '"=>' . (($value === null) ? 'null' :
                        '"' . addcslashes($value, '"\\$') . '"') . ',' . "\n";
            }
            $code .= $this->indent(2) . ') );' . "\n\n";
        }
        return $code;
    }

    private function generateTruncate($table)
    {
        $code = "";
        $code .= $this->indent(2) . '$this->truncateTable("' . $table->name . '");' . "\n";
        return $code;
    }

    /**
     * @param ColumnSchema $col
     * @return string
     */
    private function resolveColumnType(ColumnSchema $col)
    {
        $result = $col->dbType;
        if (!$col->allowNull) {
            $result .= ' NOT NULL';
        }
        if ($col->defaultValue != null) {
            $result .= " DEFAULT '{$col->defaultValue}'";
        }
        if ($col->isPrimaryKey) {
            $result .= " PRIMARY KEY";
        }
        if ($col->autoIncrement) {
            $result .= " AUTO_INCREMENT";
        }
        return $result;
    }

    public function actionIndex()
    {
        $this->stdout('hi  ' . __METHOD__);
    }
}
