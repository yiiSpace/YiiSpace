控制台应用
==============
   
目标:       后台任务  维护任务    

结构：      于 web app 相似           （粒度：  app >>  module >> controller >> action ）

语法：         
>
   yii <route> [--option1=value1 --option2=value2 ... argument1 argument2 ...]
   
-   route 指到控制器动作的路由
-   options 会用来填充控制器类的属性  （即控制器的公共实例变量 如 ： public $myOptions = {default-value} ; ）   
-   argument 动作方法的参数  （如动作签名： actionXxx( $arg1,$argX , $argN = 'default-value')）  

所以 options 是**实例级**配置  argument是**方法级别**的配置   （程序级配置在config中做哦！）

入口文件
----------
               ===================   yii.php   ===================
                  
## 配置文件  config/console.php
               
可以配置应用程序组件 或者 应用程序属性                
                            
可以在运行某个动作时切换到不同的配置文件
>   yii <route> --appconfig=path/to/config.php ..
                            
## 自己的控制台命令
                            
继承它 ：  yii\console\Controller.                             
      
### 可选的选项： Options 
重载： yii\console\Controller::options() 
此方法中列举可配置的 公共变量

使用 --OptionName=OptionValue          在运行某个action动作时会为控制器对应的变量赋值的
当变量类型是数组时 赋值的字符串会用逗号分隔的 
>
   --name=yi,qing        <==>   public $name = ['yi','qing'] ;
   
### 参数
除了可用接受选项 运行命令时也可以接收参数。类似于options 当参数是数组时 需要用类型暗示 这样字符串会以逗号分割为数组"喂"
   给action动作的。 public function actionSubCmd($p1,array $p2=array())
   
## 退出代码

控制台应用使用退出代码是一种最佳实践， 依惯例 **0** 指示一切ok  如果大于 0  那么表示错误，数字是一个错误码
  如  1 是普遍意义上的未知错误  如果大于1 那么会用于保留的特定情况：输入错误 ，缺失文件 等等...

动作例子：
~~~[php]
  
   public function actionIndex()
   {
       if (/* some problem */) {
           echo "A problem occured!\n";
           return 1;
       }
       // do something
       return 0;
   }
~~~   
退出码 的预定义常量

-    Controller::EXIT_CODE_NORMAL with value of 0;
-    Controller::EXIT_CODE_ERROR with value of 1.

最佳实践 如果有更多的错误码类型 那么为错误码定义更多的有意义的控制器常量

##  格式化 颜色

优雅降级  ：  当终端不支持时 也可以正常显示的

> $this->stdout("Hello?\n", Console::BOLD); // 输出加错的文本                           

如果构造的字符串中 有一些部分是有格式的：

~~~

   $name = $this->ansiFormat('Alex', Console::FG_YELLOW);
   echo "Hello, my name is $name.";
~~~