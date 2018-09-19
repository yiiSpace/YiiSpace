<?php
/**
 * Created by PhpStorm.
 * User: yiqing
 * Date: 2018/4/18
 * Time: 21:48
 */
?>
<?php
/* @var $this yii\web\View */
/* @var $generator year\gii\goodmall\generators\pod\Generator */

$podId = $generator->podID ;

?>
package gin

import (
    _ "fmt"
    _ "strconv"

    "github.com/gin-gonic/gin"

    _ "github.com/asaskevich/EventBus"

    "github.com/goodmall/goodmall/app"
    "github.com/goodmall/goodmall/pods/<?= $podId ?>/infra/repo/mysql"
    // "github.com/goodmall/goodmall/pods/<?= $podId ?>/usecase"

    "github.com/jinzhu/gorm"
)

// InitPod 集成入口  系统应用（SysApp）可用通过此方法把该模块的功能集成到系统总体版图去

func InitPod(engine *gin.Engine, env app.Env) {

r := engine

/**
            控制器 实例化
db, err := gorm.Open("mysql", app.Config.DSNMysql)
if err != nil {
panic("failed to connect database" + app.Config.DSNMysql)
}
db.LogMode(true) // 开启日志 生产环境中可以关闭
tr := mysql.NewTodoRepo(db)
ti := usecase.NewTodoInteractor(tr, env.EventBus)
th := TodoHandler{ts: ti}

**/

r.GET("/<?= $podId ?>", NotImplemented )
r.GET("/<?= $podId ?>/status", NotImplemented )

// TODO  我们可以在初始化方法中 触发一些事件 供内部钩子注册 也可以注册事件监听器 比如领域事件

// evbus.
}

var NotImplemented = func(c *gin.Context) {
    c.JSON(http.StatusOK, gin.H{
         "note": " this route is not implemented yet ! ",
    })
}
