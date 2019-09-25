https://github.com/rubs33/exemplo-dci/tree/master/Interaction

有的项目将此目录命名为interaction  里面全是traits
traits 是设计期产物  

原始的DCI 是运行期角色注入  yii的behavior简直太贴切了！


## 标准dci实现：

http://fulloo.info/Documents/trygve/trygve1.html

>  6.2.3      Acting In and Out of Character
   
    
   
   A Role-player plays a Role in some Context. The Role-player brings its own scripts from its class; it gets new scripts (in addition to the existing ones) when it becomes a Role-player, because it now can perform the Role scripts as well. In a network of interacting objects, Roles usually interact with each other by cueing each other through the Role scripts.
   
    
   
   Just as an actress uses her born abilities to carry out the actions in a script, while playing her Role (speaking, moving, crying, fighting, etc.) so a Role in trygve depends on the basic stuff in its Role-player to do the actual low-level work. There is a contract between a Role and its Role-player that describes what the Role expects its Role-player to be able to do. This is called the requires contract.
   
    
   
   So consider a role PathName. It may be played by a String object. Of course, there are many other objects that could also play the Role of PathName as long as each meets the minimal requirements of what the Role methods need. These needs are documented in the requires contract.
   
    
   
   role PathName {
   
   public String baseName() {
   
         String retval = "";
   
         int baseNameDelim = substring(0).findLast("/");
   
         retval = if (baseNameDelim == -1) substring(0)
   
                  else substring(baseNameDelim + 1)
   
         return retval
   
   }
   
   public String dirName() { . . . . }
   
   } requires {
   
         int length();
   
         String substring(int start, int theEnd)
   
   }
   
   
角色 和其扮演者（要成为某角色的人）有协议约束 即----requires  
即扮演者必须拥有 特定方法签名才有资格成为这个角色的扮演者！

在yii中 可以用类似反射的功能来自省某个对象 以检测其是否满足约束

而在类似go的语言中 可以通过判断对象是否实现了某个接口（go的接口实现 跟接口没有强关联  是duck-type  即只要“看起来像”
就算实现了接口）   

go实现中 角色应该是私有的 对用例以外是不可见的（ 小写 接口即可 ^_^ ）