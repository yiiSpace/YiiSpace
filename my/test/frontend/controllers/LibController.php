<?php
/**
 * Created by PhpStorm.
 * User: yiqing
 * Date: 2015/5/24
 * Time: 22:29
 */

namespace my\test\frontend\controllers;


use my\test\services\SampleService;
use phpDocumentor\Reflection\FileReflector;
use yii\apidoc\models\ClassDoc;
use yii\web\Controller;

class LibController extends Controller{

    public function actionReflection()
    {

            $rc = new \ReflectionClass(SampleService::className());
            $fileName = $rc->getFileName() ;

        $reflection = new FileReflector($fileName, true);


        $reflection->process();
        foreach ($reflection->getClasses() as $class) {

            $class = new ClassDoc($class, null, ['sourceFile' => $fileName]);

            echo $class->shortDescription ,'<br/>' .$class->description ;

            $class->getPublicMethods() ;

            print_r($class->getPublicMethods());

        }
           /*
                foreach ($reflection->getClasses() as $class) {
                    $class = new ClassDoc($class, $this, ['sourceFile' => $fileName]);
                    $this->classes[$class->name] = $class;
                }
                foreach ($reflection->getInterfaces() as $interface) {
                    $interface = new InterfaceDoc($interface, $this, ['sourceFile' => $fileName]);
                    $this->interfaces[$interface->name] = $interface;
                }
                foreach ($reflection->getTraits() as $trait) {
                    $trait = new TraitDoc($trait, $this, ['sourceFile' => $fileName]);
                    $this->traits[$trait->name] = $trait;
                }
                */
    }

    /**
     * TODO 添加额外的库 IDE智能提示功能添加  官方驱动中有api 桩方法 （这里我手动拷贝到目录：/docs/3rd/cassandra/doc）
     * 
     * php cassandra driver test
     * @see https://github.com/datastax/php-driver
     */
    public function actionCassandra()
    {
        $cluster   = \Cassandra::cluster()                 // connects to localhost by default
        ->build();
        // $keyspace  = 'system';
        $keyspace  = 'system_schema';
        $session   = $cluster->connect($keyspace);        // create session, optionally scoped to a keyspace
        $statement = new \Cassandra\SimpleStatement(       // also supports prepared and batch statements
            // 'SELECT keyspace_name, columnfamily_name FROM schema_columnfamilies'
            'SELECT * FROM keyspaces'
        );
        $future    = $session->executeAsync($statement);  // fully asynchronous and easy parallel execution
        $result    = $future->get();                      // wait for the result, with an optional timeout

        foreach ($result as $idx => $row) {                       // results and rows implement Iterator, Countable and ArrayAccess
            // printf("The keyspace %s has a table called %s\n", $row['keyspace_name'], $row['columnfamily_name']);
            // printf("The keyspace %s has a table called %s\n", $row['keyspace_name'], $row['columnfamily_name']);
            print 'index:'.$idx .PHP_EOL;
            foreach ($row as $col=>$cell){
                // print " {$col} => {$cell} ";
                print_r($cell) ;
            }
            print '<br/>';
        }
    }

}