<?php
use yii\helpers\Inflector;
use yii\helpers\StringHelper;

/**
 * @var yii\web\View $this
 * @var string $tableName full table name
 * @var string $className class name
 * @var yii\db\TableSchema $tableSchema
 * @var string[] $labels list of attribute labels (name => label)
 * @var string[] $rules list of validation rules
 * @var array $relations list of relations (name => relation declaration)
 *
 * @var $properties array list of properties (property => [type, name. comment])
 * @var $labels string[] list of attribute labels (name => label)
 * @var $rules string[] list of validation rules
 *
 * @var $generator year\gii\goodmall\generators\repository\Generator
 */
/**
 * type User struct {
 *      Id          int    `json:"id"` // int32
 *      Created     int    `json:"created"`
 *      Status      string `json:"status"`
 *      // 依赖Repo
 *      repo TodoRepo `json:"-" form:",omitempty"` // 注释啦
 * }
 */

// FIXME  这里先写死 需要从类型路径中解析： github.com/goodmall/goodmall/pods/hello/domain.UserRepo
$pkgName = 'domain' ; // domain|usecase|podID

$pkgPaths = [] ;

$repoInterfaceType = $generator->repositoryInterfaceType ; // pkgPath/pkgName.TypeName

$repoPackagePath = $generator->getPackagePath($repoInterfaceType) ;
//$repoInterfaceType =  substr($repoInterfaceType,strrpos($repoInterfaceType,'.')+1);
$repoInterfaceType =  $generator->resolveType($repoInterfaceType);

$modelType = $generator->modelType ;                // pkgName.TypeName
$searchModelType = $generator->searchModelType ;  // pkgName.TypeName

$modelPackagePath = $generator->getPackagePath($modelType) ;
if($repoPackagePath != $modelPackagePath){
    $pkgPaths[] = $modelPackagePath ;
}
$searchModelPackagePath = $generator->getPackagePath($searchModelType) ;
if( $repoPackagePath != $searchModelPackagePath ){
    $pkgPaths[] = $searchModelPackagePath ;
}

$modelType = $generator->resolveType($modelType) ;
$searchModelType = $generator->resolveType($searchModelType) ;

if(StringHelper::startsWith($modelType, $pkgName)){
    // 代表在同一个包 那么去掉这个包名吧
    $modelType = end(explode('.',$modelType));
}
if(StringHelper::startsWith($searchModelType, $pkgName)){
    // 代表在同一个包 那么去掉这个包名吧
    $searchModelType = end(explode('.',$searchModelType));
}


?>
package <?= $pkgName ?>

<?php if( !empty($pkgPaths)): ?>
import(
    <?= implode("\n",array_unique($pkgPaths)) ?>
    )
<?php endif ; ?>

// <?= $repoInterfaceType ?> manager the entity <?=  $modelType ?> as a collection
type <?= $repoInterfaceType ?> interface {

    //
    Create(m *<?=  $modelType ?>) error

    //
    Update(id int, m *<?=  $modelType ?>) error

    //
    Remove(id int) error

//              ## Query methods: ###
// ##  finder methods (eg:  findByXxx() , latestItems(since) )

    //
    Load(id int) (*<?=  $modelType ?>, error)

    // Query
    Query(sm <?= $searchModelType ?>, fields []string , offset, limit int, sort string) ([]<?= $modelType?>, error)

// ## Extra Behavior

    // Count return size by search model
    Count(sm <?= $searchModelType?>) (int, error)
}