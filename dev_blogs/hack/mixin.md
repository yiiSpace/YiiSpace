yii中的mixin 可以通过behavior跟traits来做
-------------

trait 是静态设计期的构造单元

behavior可以动态注入


插件化模块化扩展类功能
====================

根据behavior的动态特性 可以动态扩展对象功能

>   在Yii框架中对象的属性跟方法可以通过行为behavior来做
    但behaviors是静态期配置的要达到动态特征 对象的行为配置可以来自某种计算 
    这样可以在应用主流程的某个点动态注入某些behavior 这样程序的功能就可以动态扩充
    
一种设想实现

    class MyClass{
        public function behaviors(){
          $baseBehaviors = [] ;
          // return $baseBehaviors + Yii::$app->someId->getMyBehaviors(__CLASS__);
          return $baseBehaviors + Yii::$app->someComponentId->getMyBehaviors('someFeatureKey');
        }
    }
    
上面这种方法 可以在Bootstrap流程中为程序动态配置某种行为！
上面的componentId 是一个专门用来管理行为扩展的应用程序对象 可以在设计该对象上花些时间哦！是否对某个类应用扩展可以通过传入
该类的类名来决定     
    
    getMyBehaviors('someFeatureKey','MyClassName'){
        if(isset(featuresAllowed['MyClassName'])){
            return features['someFeatureKey'] ;
        }else{
            // 类名不允许配置改特征行为哦！
        }
    }
   
这个设计思路来自<<Functional programing in javascript>>一书
