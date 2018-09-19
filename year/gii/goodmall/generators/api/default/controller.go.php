<?php
/**
 * This is the template for generating a CRUD controller class file.
 *
 * User: yiqing
 * Date: 2018/4/19
 * Time: 7:22
 */
?>
<?php

use yii\db\ActiveRecordInterface;
use yii\helpers\StringHelper;

/* @var $this yii\web\View */
/* @var $generator year\gii\goodmall\generators\api\Generator */

//$interactorName = $generator->interactorName ;
//$interactorType = $generator->interactorName.'Interactor' ;
//$interactorImplType = lcfirst($interactorType) ; // interactor implement type name
//

$pkgName = 'controller' ;
$imports = [] ;

$controllerType = $generator->controllerType ;
$interactorType = $generator->interactorType ;  // 'usecase.SomeInteractor' ;

$modelType =  $generator->modelType ; // 'demo.Todo' ;
$searchModelType =  $generator->searchModelType ; //  'demo.TodoSearch' ;

?>

package <?= $pkgName ?>


import (
    "fmt"
    "log"
    "net/http"
    "strconv"
    "time"

    "github.com/gin-gonic/gin"

    "github.com/goodmall/goodmall/pods/demo"
    // "github.com/goodmall/goodmall/pods/demo/usecase"
    // "github.com/goodmall/goodmall/pods/demo/usecase"
    // "github.com/goodmall/goodmall/base"

    "github.com/goodmall/goodmall/base/api"

    "github.com/gorilla/schema"
)

// TODO 所有的错误 需要分情况处理  要区分是客户输入错误 逻辑验证错误 还是服务器内部错误！

// TodoHandler represent a Todo-Resource ,we can also named it TodoResource.(for restful)
type <?= $controllerType ?> struct {

    interactor <?= $interactorType ." \n" ?>
}

func (ctrl *<?= $controllerType ?>) Get(c *gin.Context) {
    // 注意Params 和 Query的 区别
    // idStr := c.Params.ByName("id")
    idStr := c.Query("id")
    idInt, _ := strconv.Atoi(idStr)

    var todo *demo.Todo

    todo, err := ctrl.interactor.Get(idInt)
    if err != nil {
         c.JSON(404, gin.H{"error": "not found " + strconv.Itoa(idInt)})
         return
    }
    c.JSON(http.StatusFound, todo)

}

func (ctrl *<?= $controllerType ?>) Query(c *gin.Context) {
    // create a search model
    sm := <?= $searchModelType ?>{}

    decoder := schema.NewDecoder()
    if err := decoder.Decode(&sm, c.Request.URL.Query()); err != nil {
         fmt.Println(err)
        // return
    }
    log.Printf("%#v \n", sm)

    // 构造分页
    cnt, err := ctrl.interactor.Count(sm)
    if err != nil {
        panic(err)
    }
    paginatedList := api.GetPaginatedListFromRequest(c.Request.URL, cnt)

    // 提取排序字段 形如：&sort=foo , bar desc
    sortStr := c.Query("sort")
    fmt.Println("\n sort from query: ", sortStr)

    items, err := ctrl.interactor.Query(sm, paginatedList.Page, paginatedList.PerPage, sortStr)
    if err != nil {
      panic(err)
    }
    log.Printf("%#v \n", paginatedList)

    paginatedList.Items = items

    // c.JSON(200, items)
    c.JSON(200, paginatedList)
}

func (ctrl *<?= $controllerType ?>) Create(c *gin.Context) {

    var model <?= $modelType  ?>

    c.Bind(&model)

    result , err :=  ctrl.interactor.Create(&model)
    if err != nil {
        // 创建时一般会做业务 领域约束验证的 错误可能就是这些验证没通过 或者其他更深的错误了
        // 如果是验证错误 那么需要抛给客户端的 其他错误可以考虑记录日志 打印到控制台
        panic(err) // TODO log to error log
    }
    c.JSON(201, result)
}



func (ctrl *<?= $controllerType ?>) Update(c *gin.Context) {
    // 注意Params 和 Query的 区别
    // idStr := c.Params.ByName("id")
    idStr := c.Query("id")
    idInt, _ := strconv.Atoi(idStr)


    var model *<?= $modelType ?>

    todo, err := ctrl.interactor.Get(idInt)
    if err != nil {
          c.JSON(404, gin.H{"error": "not found " + strconv.Itoa(idInt)})
          return
    }

    c.Bind(&model)

    rslt, err2 := tdh.ts.Update(idInt, todo)

    if err2 != nil {
        c.JSON(http.StatusFound, err2)
    }

    c.JSON(http.StatusAccepted, gin.H{"error": "nil", "result": rslt})

}


func (ctrl *<?= $controllerType ?>) Delete(c *gin.Context) {
    // idStr := c.Params.ByName("id")
    idStr := c.Query("id")
    idInt, err := strconv.Atoi(idStr)
    if err != nil {
         // 输入有问题！
         panic(err)
    }

    _, err := ctrl.interactor.Delete(idInt)
    if err != nil {
          c.JSON(404, gin.H{"error": err})
         return
    }
    c.JSON(http.StatusFound, "ok")
}


<?php /*
type APIError struct {
ErrorCode    int
ErrorMessage string
}
 */ ?>

func (ctrl *<?= $controllerType ?>) Count(c *gin.Context) {

    sm := <?= $searchModelType ?>{}
    decoder := schema.NewDecoder()
    if err := decoder.Decode(&sm, c.Request.URL.Query()); err != nil {
        fmt.Println(err)
        // return
    }

    cnt, err := ctrl.interactor.Count(sm)
    if err != nil {
         c.JSON(404, gin.H{"error": "count errer !"})
         return
    }

    c.JSON(http.StatusFound, cnt)

}


