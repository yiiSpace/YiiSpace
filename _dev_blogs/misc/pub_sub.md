
11:13:09
A_宜居云 2016/7/21 11:13:09
不对吧
A_宜居云 2016/7/21 11:13:23
 我自己这里测试都可以 /ss 都可以啊
竹心 2016/7/21 11:13:41
Android手机基于emqtt的SDK谁有么？
~笑对人生~ 2016/7/21 11:14:24
@竹心  看来你没参透mqtt
EMQTT/李枫 2016/7/21 11:14:37
@Ryan emqtt是组织: https://github.com/emqtt/
11:14:40
~笑对人生~ 2016/7/21 11:14:40
为啥要基于emqtt呢
A_宜居云 2016/7/21 11:14:46

A_宜居云 2016/7/21 11:14:56
这不是可以么
hello 2016/7/21 11:14:57
$SYS/brokers/${broker}/clients/${clientId}/connected

$SYS/brokers/${broker}/clients/${clientId}/disconnected
prensence要订阅这个两个topic?
竹心 2016/7/21 11:15:03
emqtt就是一个通道
EMQTT/李枫 2016/7/21 11:15:10

竹心 2016/7/21 11:15:28
现在也有很多mqtt的sdk
竹心 2016/7/21 11:15:52
但是一个比较好的Android手机上的sdk比较难搞
EMQTT/李枫 2016/7/21 11:15:56
@A_宜居云 开多个订阅，然后PUB
Ryan 2016/7/21 11:16:31
@EMQTT/李枫 
谢谢大神的作品
竹心 2016/7/21 11:16:32
我也写过sdk 但是稳定性总是解决不了
Ryan 2016/7/21 11:16:38
请问2.0版本估计何时出呢？
11:18:19
新衣不如旧人 2016/7/21 11:18:19
请问一下，我源码编译的emqttd里面调用为什么lager的debug，info之类的接口没有export是？
新衣不如旧人 2016/7/21 11:18:41
是不是我做少了那一步？
EMQTT/李枫 2016/7/21 11:18:54
@Ryan https://github.com/emqtt/emqttd/milestones 一般会延期
A_宜居云 2016/7/21 11:18:55
@EMQTT/李枫  这个是这样的。 那我刚刚问的那2个问题呢？
A_宜居云 2016/7/21 11:19:04

A_宜居云 2016/7/21 11:09:59
在源码里面 所有的 $queue 全部替换为 $USR  这样会有问题吗？ 我不改源码能不能 也可以替换？
EMQTT/李枫 2016/7/21 11:19:27
会
A_宜居云 2016/7/21 11:19:43
什么问题？
EMQTT/李枫 2016/7/21 11:20:15
$user/ emqttd会作为普通topic处理
竹心 2016/7/21 11:20:17
有谁熟悉Android端MQTT 的 SDK解决方案么？
竹心 2016/7/21 11:20:33
需要解决链接的可靠性问题
A_宜居云 2016/7/21 11:21:13
.. 那个  小龙不是说  这个是硬代码 替换掉就可以啊
11:22:17
EMQTT/李枫 2016/7/21 11:22:17
小龙说的应该是可以修改代码
A_宜居云 2016/7/21 11:22:51

A_宜居云 2016/7/21 11:23:03
那我该 如何 替换这个标签
A_宜居云 2016/7/21 11:23:12
 因为 已经有模块烧录进去了。
A_宜居云 2016/7/21 11:23:25
  里面的标识是  $USR
A_宜居云 2016/7/21 11:23:43
就算我现在升级  也不好全部 替换为 $queue
11:24:50
杀不死的坏蛋  2016/7/21 11:24:50
烧硬件程序最蛋疼了。。
EMQTT/李枫 2016/7/21 11:24:55
服务端修改下
杀不死的坏蛋  2016/7/21 11:25:02
一个一个一个一个的烧。。
A_宜居云 2016/7/21 11:25:11
是啊
A_宜居云 2016/7/21 11:25:14
  怎么修改
杀不死的坏蛋  2016/7/21 11:25:23
烧了又要一个一个一个一个的确认。。。
杀不死的坏蛋  2016/7/21 11:25:33
同命相连
hello 2016/7/21 11:26:40
烧什么硬件程序？
11:27:00
hello 2016/7/21 11:27:00
使用mqtt升级硬件程序？
Qt 2016/7/21 11:27:11
单片机
杀不死的坏蛋  2016/7/21 11:27:24
烧一个30秒 启动起来确认一下90秒  关键是还要接线。。。
hello 2016/7/21 11:27:56
自动化
Qt 2016/7/21 11:28:13
测试的？
竹心 2016/7/21 11:28:20
有熟悉前端的兄弟么？
11:29:06
Ryan 2016/7/21 11:29:06
@EMQTT/李枫 

真心非常感谢大神的作品。帮助我们不少。

也深受开源的感动，对此，我也公开下我们基于emqttd的一些设计，希望帮助下群里的大家。

我们差不多做完了一个类似微信的程序。

pub/sub逻辑最大的问题就是被动接收方不知道topic，离线不能主动订阅。

对此，

个人互相发送我们是采用默认sub自己/#的方法，比如A sub A/#, B sub B/#，
A给B发就发给B/A，反过来也一样。

群组消息，
我们让每个人，比如A，默认sub
group/A/#
group/+/A/#
group/+/+/A/#
group/+/+/+/A/#
...
100个topic，
这样默认群组极限是100人的话，所有人发信息就按照用户ID排序来发，比如群里有ABC三个人，A发给group/A/B/C/groupId, 大家都能收到

加人减人只需要添加或删除topic里对应人的level就可以了。

我们也支持多处登陆，主要就是不一样的client ID sub同一个user id的topic。

。。。。。。。。。。。。。。。。。。。。。。

希望能帮助下正在开发聊天软件的人。

也请大神@EMQTT/李枫 看看我们这个逻辑有问题没，特别是群组，就会有很多topic产生，不知道mqtt本身的设计是否符合这种逻辑，我们现在有些担心内存，但还没开始正式测试。

当然期待2.0出来，就解决离线帮别人sub的问题了
竹心 2016/7/21 11:29:06
如果好使可以购买
A_宜居云 2016/7/21 11:29:51
@EMQTT/李枫 哥啊， 怎么熄火了
EMQTT/李枫 2016/7/21 11:30:14
@A_宜居云 你和小龙讨论下
A_宜居云 2016/7/21 11:30:30
我加了他。。没鸟我
11:39:10
杀不死的坏蛋  2016/7/21 11:39:10
群组消息这个 我觉得到家都sub同一个topic就行了 为什么要那么复杂呢？是我想简单了？
杀不死的坏蛋  2016/7/21 11:39:35
@Ryan 
天山老妖 2016/7/21 11:39:50
@Ryan 
usera/b/c/d订阅/usr/abcd/#
usera send 2 userb : /usr/b/a
usera send 2 group: /group/xxxx
Ryan 2016/7/21 11:40:45
@杀不死的坏蛋  

主要问题是，离线被动拉入group，上线后怎么收到被拉入后的消息

上线sub时，sub之前的消息收不到
天山老妖 2016/7/21 11:41:05
qos不就可以？
11:41:51
天山老妖 2016/7/21 11:41:51
而且本身这些数据你是要留档的，以后会有人要求你这么干的，哈哈
Ryan 2016/7/21 11:42:47
@天山老妖 
哦，所以用数据库存起来是么？
天山老妖 2016/7/21 11:43:14
你怎么存储是你的事，但是等你用户量多一点，公安会找你的
杀不死的坏蛋  2016/7/21 11:43:20
你把group聊天记录可以用数据库存起来
杀不死的坏蛋  2016/7/21 11:43:36
这样就一个topic就能搞定 
天山老妖 2016/7/21 11:43:44
深圳网监有一个中队是在腾讯办公的
11:43:52
杀不死的坏蛋  2016/7/21 11:43:52
群的容量也会比较大 也简单很多
杀不死的坏蛋  2016/7/21 11:44:24
群聊一定要有监控
天山老妖 2016/7/21 11:44:31
私聊也要有的
天山老妖 2016/7/21 11:44:43
法律规定是存储6个月还是几年的样子
杀不死的坏蛋  2016/7/21 11:45:12
每次登录 群聊信息都可以去数据库查询一下index对比一下
杀不死的坏蛋  2016/7/21 11:45:23
恩
11:46:08
天山老妖 2016/7/21 11:46:08
存储我觉得也简单，一个后台服务订阅/#就是了
天山老妖 2016/7/21 11:46:37
然后直接推到redis，再来个程序周期性的入库
天山老妖 2016/7/21 11:47:21

我是搞这个的，你的需求跟我的差不多的
天山老妖 2016/7/21 11:47:52
上线直接即时行情，然后历史数据走http来一次get就好了
天山老妖 2016/7/21 11:48:08
http再来个gzip，数据量很小的
11:48:35
杀不死的坏蛋  2016/7/21 11:48:35

天山老妖 2016/7/21 11:50:15
im我记得之前讨论过，当时的建议是任何对话不论人数多少都直接搞一个/chat/guid，然后拖了谁就给谁acl进来
Ryan 2016/7/21 11:50:25
@天山老妖 非常感谢这个建议，我们现在弄服务器测试一下
天山老妖 2016/7/21 11:50:25
然后我刚才上面说的也是个思路，可以考虑下咯
11:50:39
Ryan 2016/7/21 11:50:39
嗯，服务器还是个不错的思路
天山老妖 2016/7/21 11:50:47

天山老妖 2016/7/21 11:51:11

我就瞎扯的，别当真，根据你的情况搞就好的，topic+acl很灵活的
11:52:49
Ryan 2016/7/21 11:52:49
acl好像是要重启后才会生效是么？
天山老妖 2016/7/21 11:53:02
说起来，想起一个笨办法，但可能要自己做个插件来刷新acl
所有人订阅/chat/#，然后任何对话都新建一个guid，有权限的人给acl，这样客户端不需要修改订阅就可以直接接收
hello 2016/7/21 11:53:26
重启，那岂不是要断业务了
Ryan 2016/7/21 11:53:34
插件可以如何刷新呢？
杀不死的坏蛋  2016/7/21 11:53:37
acl不需要重启吧
杀不死的坏蛋  2016/7/21 11:53:45
数据库修改数据就行了
天山老妖 2016/7/21 11:53:50
重新订阅会校验acl的，我记得
Ryan 2016/7/21 11:53:58
我们之前有用static subscribe，静态的

也是需要重启，或者重新登陆，才能生效
天山老妖 2016/7/21 11:54:06
刷新你得问问作者
天山老妖 2016/7/21 11:54:22
不用离线，只要重新订阅就可以
杀不死的坏蛋  2016/7/21 11:54:32
订阅的时候需要验证权限吧 
11:54:58
杀不死的坏蛋  2016/7/21 11:54:58
如果删除了acl  不知道原来订阅的还会不会收到 如果不退出登录的话
Ryan 2016/7/21 11:55:20
不退出，不主动取消订阅，订阅应该一直都有
天山老妖 2016/7/21 11:55:22
导致acl刷新的好像只有订阅
杀不死的坏蛋  2016/7/21 11:55:40
关键是acl被删除了的时候 
杀不死的坏蛋  2016/7/21 11:55:47
订阅还是有效的吗？
天山老妖 2016/7/21 11:55:54
有效的
杀不死的坏蛋  2016/7/21 11:56:03
每次数据推送的时候都去验证一下订阅  不可能吧
