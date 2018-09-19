[react-directory-structure](https://marmelab.com/blog/2015/12/17/react-directory-structure.html)

[a_better_file_structure_for_reactredux/](https://www.reddit.com/r/reactjs/comments/47mwdd/a_better_file_structure_for_reactredux/)


[organize-your-ember-app-with-pods/](http://cball.me/organize-your-ember-app-with-pods/)

>
    You may have seen references to pods when reading up on Ember and ember-cli. What the heck are pods? 
    Simply put, pods are a way of grouping files in your project by feature (ex: Task) 
    rather than by type (ex: controllers). According to the ember-cli documentation, 
    “As your app gets bigger, a feature-driven structure may be better. Splitting your application
     by functionality/resource would give you more power and control to scale and maintain it”.
     
关于Pods的翻译
>
    pods
    [pɔdz]
    
        n.
    
        荚( pod的名词复数 )； （飞机的）吊舱； （航天器或船只上可与船只主体分离的）分离舱；
        简直是一个模子刻出来的

这玩意其实跟yii的modules一个意思  不过在js等语言中module是一种代码组织方式 而不是项目组织结构  如果也用modules容易混乱
    
[organizing-redux-application/](https://jaysoo.ca/2016/02/28/organizing-redux-application/)        

~~~
app
    boots
         集成各个特征模块下的东西 相当电脑的集成总线 都在这里 **挂钩** 有点路由器hub插槽的感觉
          
    pods( features | modules-in-yii | bundles-in-symfony | blueprint-flask )
       pods-x
           // index.xxx (暴露本 模块| 有界上下文 的公共API    export ... )
           actions/
             todos.js
           components/
             todos/
               TodoItem.js
               ...
           constants/
             actionTypes.js
           reducers/
             todos.js
             
           index.js       (facade 门面   暴露本模块的公共API public-api-exporter 与其他模块的耦合contracts协议)
           rootReducer.js
           
~~~           