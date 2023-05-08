http://segmentfault.com/q/1010000003849810?_ea=393163

Yii2框架中，有必要再分离service层么？

>
        答
        5
        杨益 1.9k 10月13日 回答
        
        在简单的系统里面，分层是这样的
        
        controller <-> model <-> storage(sql、nosql、cache)
        
        所有的业务逻辑都在model上
        
        现在讨论一个常见的场景，用户下订单要买点东西，这个业务逻辑涉及到的model类有User（用户）、Order（订单）、Goods（商品）
        
        那么下订单这个事情是放到User还是Order上？无论放在User还是Order上，这个业务逻辑都需要多个model类的参与
        
        这种需求在系统里面越来越多，你就会发现你总有那么几个model在不断的膨胀，这些model之间甚至产生了网状的相互依赖关系
        
        需求越复杂，你越容易陷入这种混乱的局面
        
        service层的作用就是把这些需要多个model参与的复杂业务逻辑单独封装出来，这些model之间不再发生直接的依赖，而是在service层内协同完成逻辑
        
        service层的第一个目的其实就是对model层进行解耦
        
        业界对前面提到的那种不断膨胀的model称为“充血模型”，起初对充血模型进行反思的一种解决方案就是“贫血模型”，model里面尽量少放点逻辑，把这些逻辑都移动到controller层面去处理，在controller里面调用多个model完成业务逻辑，也达到了对model间解耦的作用
        
        但问题就是，业务逻辑都放到controller层面了，如果其它的controller也需要相同的业务逻辑时，只能在controller里面调用其它的controller，这样做既不方便又麻烦
        
        所以后来还是把这种解耦单独放一层，叫service，现在分层就变成这样
        
        controller <-> service <-> model <-> storage
        
        service层的第二个作用就是重用
        
        差不多就是这样
        
        简单粗暴的总结来说，如果你的某个业务逻辑，需要用到多个model，就放到service层里面去，如果只是这个model自己的事，跟其它的model没有任何关系，就放到model里面就好。
        
        如果你的系统本来就很小，业务逻辑也超级简单，也不存在长期演进迭代的需求，随你怎么高兴怎么写都行。

>
         更多 
    
    0
    Watcher_杭州 1.4k 10月13日 回答
    
    分层永远是处理复杂业务的有效手段（一般项目三层，复杂的项目回到四层、五层）。
    
    在面向OO的系统里，service就是biz manager，在面向过程的系统里service就是TS脚本。
    
    AR Model里面当然可以放业务代码，但仅限于操作这个model自身（如果使用了repository则也不能操作同类型别的model，而应该在repository中操作某一类models），不对其他类型model产生依赖。
    
    业务manager（也就是所谓的service）则根据业务，处理不同类型model或者repository之间的关系。
    
    业务更加复杂时可以抽出子系统的facade门面，处理不同业务manager调用顺序。
    
    最后在controller里调用它们（对， controller也可以认为是一个facade）。
    
    我接触过的项目都在这几层里面，再复杂也就到facade。小项目当然直接扔到model里，，随着业务不断复杂，我们要做的只是不断重构而已。
