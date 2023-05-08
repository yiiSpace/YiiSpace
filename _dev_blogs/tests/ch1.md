测试的意义  重要性

>
    "Although it is true that quality cannot be tested in, it is equally evident that
    without testing, it is impossible to develop anything of quality."
    
软件生命周期
-------------

阶段

ideas      ----》  features Or stories ---------》 tasks  --------》each task execution  -----》  a finished product

质量等级

缺陷率  

波纹效应  错是软件的其他部分或者小组犯下的


项目管理
----------------
- 时间
- 质量
- 代价（花费）

很多时候是 三选二 （CAP 也是三选二）

消减软件质量 长远看其实是增加了软件投入（花销）的    

任务评估

燃烧图

测试方法
-------------
XP                
    双重检测 （ double checking ）
    DCI       （ Defect Cost Increase ）
    
>
    What DCI states is the following:
    "The sooner you find a defect, the cheaper it is to fix."
    Kent Beck
    
缺陷越早发现 耗费越小
    
更短的反馈周期
    
规范的叫法： CI    

尽早为项目引入测试 应将其视为一等公民


TDD
-------------
测试驱动开发                       Red-Green-Refactor

-  Red 先开发未通过的测试 （红色状态 ------  交通灯）            黑盒测试
-  Green 开发测试的接口 让其通过 （绿色状态 ）
-  Refactor 如果需要 重构 细化提高 被测试强调的接口

DBC  http://www.c2.com/cgi/wiki?DesignByContract          **BertrandMeyer**

双重检测
----------
两套测试集
-  程序员视角的测试集               测试所有的系统组件  
-  用户视角的测试集                 系统的操作视为一个整体                   BDD （行为驱动开发---- BehaviorDrivenDevelopment）

BDD 试图弥补TDD的缺陷（缺乏全局观 转移注意力到项目的行为方面）           但可能会影响组织结构

（项目结构 可能影响 组织结构 ，  反之也是可能的   比如 项目做明确的前端 后端分离  会导致前端成为组织中的一个部门，小组...等机构）


BDD 引入了 stories 和 scenario 的概念，         给开发者以规范格式来描述用户视角和应用的功能 

用户故事 在标准的敏捷框架 中的表述 ：“As a [role] I want [feature] so that [benefit]”
接受标准应该写成场景并实现为类： “Given 【initial context】 ，when【event occurs】 , then【 ensure some outcomes】”

规划测试
------------

测试计划

ACC （google 的 Attributes-Components-Capabilities）

生成测试
------------

测试计划只是开始 ，

好的测试展示的重要特性
-  重复性                    可重现
-  简单性                    只做一件事并将其做好
-  隔离性                   测试间无依赖
 
 
接受测试这个理念
--------------

项目初 先让开发者变为测试者  使开发者对其的代码质量负责
 
测试者具备的三个东西
-  测试理念
-  技能集
-  测试 知识

ACC                      

                       break-down                     break-down
    application|project    >-      modules|components     >-       features|capabilities  .. 每个特征可以表示为特定属性 
      
知名企业中的专业测试工程师 协助开发者      
    