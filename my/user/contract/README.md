contracts
=================

根据著名的 DBC（Designe By Contract）契约式编程
contract 也就是interface的别名 ；  
Lararel 一贯强调 expressive （表现力），所以采用的是 Contract 


本模块用到的接口

注意接口命名，在go语言中一般是 er 结尾 比如writer reader..

还有一种是使能 特征的：
 
  +   -able 如 Authenticable 
  +   Can-  如 CanResetPassword         注意格式如   Can<动词><名称>  即动宾短语前面带上Can ！
                
                
                
                
关于 traits
--------------------
                
也是Can- -able 命名风格！
如 ：

 ``
   
     class User 
    {
         use Authenticable, CanResetPassword;
         ...
    
  ``    
  
至于存放路径
可以弄个traits命名空间存放,如 ：   user\traits\CanEditObject
另几个候选：

+  放在helpers目录
+  放在support目录
+  放在components目录             