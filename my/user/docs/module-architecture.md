模块架构
============


每个模块应该对系统负责，需要提供系统相关的功能。
由于系统是用分治（分而治之）方式来切割的，所以各个部分需要分担系统功能。
系统除了需要考虑如何分，为了保证逻辑上的一体性，还需要考虑如何合。系统的使用者不会关心你内部是如何分工的，他从外部看，你
的系统就是作为一个整体对外提供功能的（各种用例，api）。

模块内部也是一个子系统 也有自己相应的常见结构（逻辑上，物理上），心智上系统跟模块，模块间都是以相似方式，相似结构来构造的
，分形即是这种状态的描述（百度什么是[分形](https://www.baidu.com/s?wd=%E5%88%86%E5%BD%A2&ie=UTF-8&tn=19045005_32_pg&ch=4)。
 模块仍旧可以有其他子模块（yii是支持模块的嵌套的 甚至是无限级，但不推荐多于3的模块层次）这种情形就是分治思想中所谓的“度”
 处理一个问题时可以以相同的手段（算法）不断分割 直到某个适合的“度”这个粒度的单位是可以简单解决掉的，在这个“度”下是没必要再继续分割了。
 分治思想就是个个击破思想的体现，把问题域不断分割，每个小的问题域被以相同思想继续分割直到问题足够简单时分割停止，然后
 对每个问题域给出相应的解答，然后拼接所有答案直至回答整个问题。
 关于模块的嵌套问题，建议最好还是使用平面的一级结构，因为有个著名的“平面优于嵌套”（Flat is better than nested）的理论指导。
 
 ## 系统的层次性
整个宇宙是全息的，也就是说你构建的最小应用组件里面也蕴含着最宏观的架构形貌。

比如宇宙层面 ，宇宙由各个行星 恒星 星系构成
地球由几个地壳层 大气层 臭氧层 等有机构成
地球上的一个人 由五脏六腑 四肢百骸等构成

上面就是层次性 你研究的客体的粒度到底有多大！城市的规划师他们的视角跟一座商业大楼的设计者 考虑的也不同哦，前者需要规划各个
区的用途 居民区，绿化区，工业带...。当然如果你想当码农 那就垒码吧 搬搬砖垒个房房就行了。

麻雀虽小五脏俱全，治大国如烹小鲜 这些词都指出了这种“相似性”

 
## 留意“胶水”
python 被称之为**胶水**语言，是因为它游走在松耦合的系统之间，粘连各个子系统，常常是站在系统运维者的角度来看待各个应用|系统
的。换言之 也就是它的思考单位 往往是进程|应用 级别。而我们phper经常只是面对class function trait interface 这些构体，他们的
粒度自然小于进程，线程了。

分裂系统后难点在于系统的“缝隙”如何被连接在一起，他们就相当于大陆板块间的海洋，细胞间的组织液，没有这些“桥”每个模块都
是独立的板块。


模块需要的额外组件
-----------


除了mvc组件外，还需要的辅助组件。

大家都知道现代php框架经常是mvc结构（此是逻辑上的结构 是系统级设计模式），对应的物理文件夹（相应的逻辑结构：名空间）分别
是：models , views ,controllers . 但实际实战过程中发现有些功能无法放置在他们任何一个区域中（名空间，目录）。

此时需要引入额外的名空间（目录）！（以后如果不特别声明 名空间 跟 目录 等价概念）
经常引入的如：
-  helpers :   ror中与其说是mvc 反而不如说是： 帮助类 模型 控制器 视图 。所有开发都是在这四者间迭代。
-  components ; 组件 ， 此概念跟其他框架中的服务类是同义的 。 即系统通用性的组件（服务类），常常是单体。比如系统级的：
    db ，cache ，request，response ... 

-  constants :  常量
-  exceptions : 异常    
-  events : 事件
-  listeners : 监听器
-  ...
     
常用的功能：
+ 搜索 : 搜索功能
+ urlCreator :  负责创建本模块内的各种url。     
+ 统计  :  各种实体的统计功能 report报表功能


## MISC 杂项

见[阮一峰ES6](http://www.nodeclass.com/api/ECMAScript6.html#h2-Number_parseInt____Number_parseFloat__)

>
    Number.parseInt(), Number.parseFloat()
    
    ES6将全局方法parseInt()和parseFloat()，移植到Number对象上面，行为完全保持不变。
    
    
    // ES5的写法
    parseInt("12.34") // 12
    parseFloat('123.45#') // 123.45
    
    // ES6的写法
    Number.parseInt("12.34") // 12
    Number.parseFloat('123.45#') // 123.45
    
    这样做的目的，是逐步减少全局性方法，使得语言逐步模块化。
    
这种思想体现在 **全局方法|shortCut，和模块方法** 抉择倾向。有好多人还是喜欢用短方法 ， 包括yii社区 以及
Laravel（vender/illuminate/support/helpers.php） 都有短方法的例子。 短方法实际上会污染全局空间 不利于模块化的。    
