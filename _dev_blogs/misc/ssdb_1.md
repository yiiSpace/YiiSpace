
2016/11/21 12:53:05
ヒカルの碁 2016/11/21 12:53:05
如果ssdb的setnx支持ttl就可以了。
ヒカルの碁 2016/11/21 12:53:46
分布式锁锁的对象就不是线程了。。是多个服务器间协调问题
Mr.Win 2016/11/21 12:54:15
恩 我上面描述有误
2016/11/21 12:55:55
Mr.Win 2016/11/21 12:55:55
做个nio服务怎么样，我觉得你依赖第三方都不可靠
ヒカルの碁 2016/11/21 12:56:36
多个服务器间，打个比方说：先读出一个值,再做比较处理。。在写进去更新。。这种操作。。你不锁住。。你无法控制在你读值之后。。会否被其他服务器更新了值
2016/11/21 12:56:57
Mr.Win 2016/11/21 12:56:57
如果 redis 、ssdb挂掉了 你不就用不了，本身 redis、ssdb 是为了用户体验，将热点数据缓存做优化的。
Mr.Win 2016/11/21 12:58:28
我觉得你得先考虑这个锁放到那一层
ヒカルの碁 2016/11/21 12:58:28
你理解不了这个需求。。只能说明你的业务面相对窄没遇过。。到你遇上了。。你就明白今天我说的
Mr.Win 2016/11/21 12:58:55
这有什么理解不了的。。
2016/11/21 12:59:12
ヒカルの碁 2016/11/21 12:59:12
理解就好
Wendal~兽 2016/11/21 12:59:40
ssdb的setnx支持ttl,这个想法不错
ヒカルの碁 2016/11/21 13:00:06
因为redis就支持
ヒカルの碁 2016/11/21 13:01:07
刚开始redis也是不支持。。后来建议多了就支持
2016/11/21 13:04:45
Mr.Win 2016/11/21 13:04:45
个人建议你用zookeeper吧 ，redis、ssdb是高性能 但是没zookeeper 更可靠。
Mr.Win 2016/11/21 13:05:26
其他的如果你有好办法解决了，麻烦分享一下哈。
ヒカルの碁 2016/11/21 13:05:40
唉，有时候方便部署。维护成本很多因素要考虑的。。
2016/11/21 13:06:26
ヒカルの碁 2016/11/21 13:06:26
搞个zookeeper是可以。。但往往有时候有其它问题在
Mr.Win 2016/11/21 13:06:41
是的 所以自动部署系统在大公司都很受用
ヒカルの碁 2016/11/21 13:08:01
像redis用开了。。我只需要两条命令。
上锁。set key value ex 3 nx
解锁。 del key
ヒカルの碁 2016/11/21 13:08:11
很方便的事
2016/11/21 15:39:59
Mr.Win 2016/11/21 15:39:59
那如果你的主挂了呢 
Mr.Win 2016/11/21 15:40:14
读从的话 还是加锁状态
Mr.Win 2016/11/21 15:40:24
不就死锁了
2016/11/21 16:03:15
EARP 2016/11/21 16:03:15
弱弱问下，ssdb可以reload配置吗？需要增加allow ip。。
2016/11/21 16:07:42
找我私聊者踢 2016/11/21 16:07:42
list_allow_ip
add_allow_ip
del_allow_ip
list_deny_ip
add_deny_ip
del_deny_ip

这几个命令还没加到文档中.
2016/11/21 16:16:19
EARP 2016/11/21 16:16:19
还要切换slave of。。也有私藏的命令吗？
2016/11/21 16:21:01
找我私聊者踢 2016/11/21 16:21:01
没有, slave 必须重启.
EARP 2016/11/21 16:21:20
了解了
2016/11/21 16:23:41
找我私聊者踢 2016/11/21 16:23:41
注意, 必须同时修改配置文件, 否则重启后, ip filter 配置又会恢复.
EARP 2016/11/21 16:24:37
嗯嗯
2016/11/21 16:25:35
可西哥 2016/11/21 16:25:35
私藏的命令 
猫哥 2016/11/21 16:27:34
list_allow_ip
add_allow_ip
del_allow_ip
list_deny_ip
add_deny_ip
del_deny_ip
执行命令必须同步修改配置文件？
2016/11/21 16:31:49
EARP 2016/11/21 16:31:49
在线修改参数，也得同步修改配置文件，要不重启再从配置文件读取
EARP 2016/11/21 16:32:01
又是旧的配置了
2016/11/21 16:41:51
猫哥 2016/11/21 16:41:51
	// add built-in procs, can be overridden
	proc_map.set_proc("ping", "r", proc_ping);
	proc_map.set_proc("info", "r", proc_info);
	proc_map.set_proc("auth", "r", proc_auth);
	proc_map.set_proc("list_allow_ip", "r", proc_list_allow_ip);
	proc_map.set_proc("add_allow_ip",  "r", proc_add_allow_ip);
	proc_map.set_proc("del_allow_ip",  "r", proc_del_allow_ip);
	proc_map.set_proc("list_deny_ip",  "r", proc_list_deny_ip);
	proc_map.set_proc("add_deny_ip",   "r", proc_add_deny_ip);
	proc_map.set_proc("del_deny_ip",   "r", proc_del_deny_ip);
找我私聊者踢 2016/11/21 16:41:54
文档已经补充 http://ssdb.io/docs/zh_cn/commands/index.html
猫哥 2016/11/21 16:42:33
读一下代码   没什么秘密
2016/11/22 12:00:13
怪怪龙滴~~咚 2016/11/22 12:00:13
ssdb 是如何模拟数据超时的
怪怪龙滴~~咚 2016/11/22 12:00:18
在ldb基础上面
2016/11/22 12:52:04
Wendal~兽 2016/11/22 12:52:04
ssdb最近有什么开发计划吗
2016/11/22 20:13:57
0..0 2016/11/22 20:13:57
十一月 21, 2016 3:27:30 下午 org.apache.catalina.core.StandardWrapperValve invoke
严重: Servlet.service() for servlet springMVC threw exception
java.lang.OutOfMemoryError
	at java.util.zip.ZipFile.open(Native Method)
	at java.util.zip.ZipFile.<init>(ZipFile.java:214)
	at java.util.zip.ZipFile.<init>(ZipFile.java:144)
	at java.util.jar.JarFile.<init>(JarFile.java:152)
	at java.util.jar.JarFile.<init>(JarFile.java:89)
	at sun.net.www.protocol.jar.URLJarFile.<init>(URLJarFile.java:93)
	at sun.net.www.protocol.jar.URLJarFile.getJarFile(URLJarFile.java:69)
	at sun.net.www.protocol.jar.JarFileFactory.get(JarFileFactory.java:88)
	at sun.net.www.protocol.jar.JarURLConnection.connect(JarURLConnection.java:122)
	at sun.net.www.protocol.jar.JarURLConnection.getInputStream(JarURLConnection.java:150)
	at freemarker.cache.URLTemplateSource.close(URLTemplateSource.java:139)
	at freemarker.cache.URLTemplateLoader.closeTemplateSource(URLTemplateLoader.java:106)
	at freemarker.cache.MultiTemplateLoader$MultiSource.close(MultiTemplateLoader.java:188)
	
2016/11/22 20:14:10
0..0 2016/11/22 20:14:10
at freemarker.cache.MultiTemplateLoader.closeTemplateSource(MultiTemplateLoader.java:142)
	at freemarker.cache.TemplateCache.getTemplate(TemplateCache.java:353)
	at freemarker.cache.TemplateCache.getTemplate(TemplateCache.java:205)
	at freemarker.template.Configuration.getTemplate(Configuration.java:740)
	at freemarker.core.Environment.getTemplateForInclusion(Environment.java:1694)
	at freemarker.core.Environment.getTemplateForImporting(Environment.java:1748)
	at freemarker.core.Environment.importLib(Environment.java:1733)
	at freemarker.template.Configuration.doAutoImportsAndIncludes(Configuration.java:1105)
	at freemarker.core.Configurable.doAutoImportsAndIncludes(Configurable.java:1271)
	at freemarker.core.Configurable.doAutoImportsAndIncludes(Configurable.java:1271)
	at freemarker.core.Environment.process(Environment.java:242)
	at freemarker.template.Template.process(Template.java:277)
	at org.springframework.web.servlet.view.freemarker.FreeMarkerView.processTemplate(FreeMarkerView.java:366)
	at org.springframework.web.servlet.view.freemarker.FreeMarkerView.doRender(FreeMarkerView.java:283)
	at org.springframework.web.servlet.view.freemarker.FreeMarkerView.renderMergedTemplateModel(FreeMarkerView.java:233)
	at org.springframework.web.servlet.view.AbstractTemplateView.renderMergedOutputModel(AbstractTemplateView.java:167)
	at org.springframework.web.servlet.view.AbstractView.render(AbstractView.java:267)
	at org.springframework.web.servlet.DispatcherServlet.render(DispatcherServlet.java:1221)
	at org.springframework.web.servlet.DispatcherServlet.processDispatchResult(DispatcherServlet.java:1005)
	at org.springframework.web.servlet.DispatcherServlet.doDispatch(DispatcherServlet.java:952)
	at org.springframework.web.servlet.DispatcherServlet.doService(DispatcherServlet.java:870)
	at org.springframework.web.servlet.FrameworkServlet.processRequest(FrameworkServlet.java:961)
	at org.springframework.web.servlet.FrameworkServlet.doGet(FrameworkServlet.java:852)
	at javax.servlet.http.HttpServlet.service(HttpServlet.java:617)
	at org.springframework.web.servlet.FrameworkServlet.service(FrameworkServlet.java:837)
	at javax.servlet.http.HttpServlet.service(HttpServlet.java:723)
	at org.apache.catalina.core.ApplicationFilterChain.internalDoFilter(ApplicationFilterChain.java:290)
	at org.apache.catalina.core.ApplicationFilterChain.doFilter(ApplicationFilterChain.java:206)
	at org.apache.shiro.web.servlet.ProxiedFilterChain.doFilter(ProxiedFilterChain.java:61)
	at org.apache.shiro.web.servlet.AdviceFilter.executeChain(AdviceFilter.java:108)
	at org.apache.shiro.web.servlet.AdviceFilter.doFilterInternal(AdviceFilter.java:137)
	at org.apache.shiro.web.servlet.OncePerRequestFilter.doFilter(OncePerRequestFilter.java:125)
	at org.apache.shiro.web.servlet.ProxiedFilterChain.doFilter(ProxiedFilterChain.java:66)
	at org.apache.shiro.web.servlet.AbstractShiroFilter.executeChain(AbstractShiroFilter.java:449)
	at org.apache.shiro.web.servlet.AbstractShiroFilter$1.call(AbstractShiroFilter.java:365)
	at org.apache.shiro.subject.support.SubjectCallable.doCall(SubjectCallable.java:90)
	at org.apache.shiro.subject.support.SubjectCallable.call(SubjectCallable.java:83)
	at org.apache.shiro.subject.support.DelegatingSubject.execute(DelegatingSubject.java:383)
	at org.apache.shiro.web.servlet.AbstractShiroFilter.doFilterInternal(AbstractShiroFilter.java:362)
	at org.apache.shiro.web.servlet.OncePerRequestFilter.doFilter(OncePerRequestFilter.java:125)
0..0 2016/11/22 20:14:13
	at org.springframework.web.filter.DelegatingFilterProxy.invokeDelegate(DelegatingFilterProxy.java:344)
	at org.springframework.web.filter.DelegatingFilterProxy.doFilter(DelegatingFilterProxy.java:261)
	at org.apache.catalina.core.ApplicationFilterChain.internalDoFilter(ApplicationFilterChain.java:235)
	at org.apache.catalina.core.ApplicationFilterChain.doFilter(ApplicationFilterChain.java:206)
	at org.springframework.web.filter.CharacterEncodingFilter.doFilterInternal(CharacterEncodingFilter.java:88)
	at org.springframework.web.filter.OncePerRequestFilter.doFilter(OncePerRequestFilter.java:107)
	at org.apache.catalina.core.ApplicationFilterChain.internalDoFilter(ApplicationFilterChain.java:235)
	at org.apache.catalina.core.ApplicationFilterChain.doFilter(ApplicationFilterChain.java:206)
	at org.apache.catalina.core.StandardWrapperValve.invoke(StandardWrapperValve.java:233)
	at org.apache.catalina.core.StandardContextValve.invoke(StandardContextValve.java:191)
	at org.apache.catalina.core.StandardHostValve.invoke(StandardHostValve.java:127)
	at org.apache.catalina.valves.ErrorReportValve.invoke(ErrorReportValve.java:103)
	at org.apache.catalina.core.StandardEngineValve.invoke(StandardEngineValve.java:109)
	at org.apache.catalina.connector.CoyoteAdapter.service(CoyoteAdapter.java:293)
	at org.apache.coyote.http11.Http11Processor.process(Http11Processor.java:861)
	at org.apache.coyote.http11.Http11Protocol$Http11ConnectionHandler.process(Http11Protocol.java:620)
	at org.apache.tomcat.util.net.JIoEndpoint$Worker.run(JIoEndpoint.java:489)
	at java.lang.Thread.run(Thread.java:722)
0..0 2016/11/22 20:15:05
java web项目运行一段时间侯 ，连着抛出这个错误，谁能帮忙看看为什么吗？
Wendal~兽 2016/11/22 20:15:45
不应该找个java群吗
2016/11/22 21:40:14
猫哥 2016/11/22 21:40:14
out of memory
0..0 2016/11/22 21:40:25
是的
0..0 2016/11/22 21:40:50
我想是不是因为程序里面有文件流没有关闭引起的
猫哥 2016/11/22 21:42:05
启动的脚本挂载一个jprofile试试什么东西耗的内存一直涨
2016/11/22 22:08:44
0..0 2016/11/22 22:08:44
好
2016/11/23 18:04:59
nosun 2016/11/23 18:04:59
我想用ssdb用来存储 log， log 的值 是 key value结构，log的值需要定期做统计分析，然后把结果存储到MySQL中，key value 有多组，我想使用hash 表来存储这个，然后 hash 的key 使用 prefix_{deivce_id}_{time} 这样的格式来存储，这样是否是最佳的方法呢？ 也想过把 这些key 再用集合存一下，这样便于查找，是否有必要呢？
2016/11/23 18:16:03
找我私聊者踢 2016/11/23 18:16:03
一般日志存储的需求是: 能存, 能按顺序遍历, 能按时间段遍历. 真正的统计只发生成内存中, 也即一连遍历一边统计.
找我私聊者踢 2016/11/23 18:16:59
根据你的读需求, 来决定如何存.
2016/11/23 18:17:27
nosun 2016/11/23 18:17:27
哈希表的 key 不能 scan到吧
nosun 2016/11/23 18:17:41
因此要放在集合中
nosun 2016/11/23 18:17:43
？
找我私聊者踢 2016/11/23 18:17:54
目前看, 你有两个需求
1. 按 device_id 读 (start_time, end_time) 区间内的数据
2. 读取  (start_time, end_time) 区间内的全部数据, 不管其它的任何条件.
nosun 2016/11/23 18:18:15
嗯
nosun 2016/11/23 18:18:16
对
nosun 2016/11/23 18:19:05
知道了， hlist 这个可以
2016/11/23 18:20:47
nosun 2016/11/23 18:20:47
第一个需求可以通过hlist 实现
找我私聊者踢 2016/11/23 18:22:20
所以
1. 用一个 hash, 名字为 all_logs 来存储, key 是 {time}_{device_id}, value 是 log 本身
2. 用n个 hash, 名字为 device_log_index_{device_id} 来存储, key 是 {time}
找我私聊者踢 2016/11/23 18:22:36
假设同一个设置一个时间只有一条log
找我私聊者踢 2016/11/23 18:22:42
同一个设备
2016/11/23 18:30:25
nosun 2016/11/23 18:30:25
第二个，value 是log本身么
2016/11/23 18:34:03
nosun 2016/11/23 18:34:03
明白了，value不重要，存一个时间戳就行了
nosun 2016/11/23 18:34:08

2016/11/23 18:59:26
fidel 2016/11/23 18:59:26
尝试用RocksDB，测试结果比leveldb，差了好多 
ヒカルの碁 2016/11/23 19:00:40
人家是有业务场景的。。不是这样简单压测能压出来
2016/11/23 19:01:07
fidel 2016/11/23 19:01:07
比如什么场景呢？value大的情况下？
ヒカルの碁 2016/11/23 19:01:29
好像alisql...你说它都比mysql好？肯定定不是。。肯定在一业务场景会比它好
ヒカルの碁 2016/11/23 19:03:06
比如我也不知道。。只是觉得这些特化的库存在肯定有一定场景优点
2016/11/24 15:38:02
猫哥 2016/11/24 15:38:02
ssdb 压4K 8K的包很容易core
2016/11/24 15:40:09
猫哥 2016/11/24 15:40:09
(gdb) bt
#0  0x000000000043d898 in BinlogQueue::commit() ()
#1  0x000000000043249f in SSDBImpl::set(Bytes const&, Bytes const&, char) ()
#2  0x0000000000408e96 in proc_set(NetworkServer*, Link*, std::vector<Bytes, std::allocator<Bytes> > const&, Response*) ()
#3  0x000000000044de35 in ProcWorker::proc(ProcJob*) ()
#4  0x000000000044b785 in WorkerPool<ProcWorker, ProcJob*>::_run_worker(void*) ()
#5  0x0000003e63807851 in start_thread () from /lib64/libpthread.so.0
#6  0x0000003e630e890d in clone () from /lib64/libc.so.6


(gdb) bt
#0  0x000000000044e413 in Fdevents::del(int) ()
#1  0x0000000000449a7d in NetworkServer::serve() ()
#2  0x0000000000404608 in MyApplication::run() ()
#3  0x000000000044585f in Application::main(int, char**) ()
#4  0x00000000004049bf in main ()


(gdb) bt
#0  0x0000000000470b99 in leveldb::Log(leveldb::Logger*, char const*, ...) ()
#1  0x0000000000456962 in leveldb::DBImpl::WriteLevel0Table(leveldb::MemTable*, leveldb::VersionEdit*, leveldb::Version*) ()
#2  0x0000000000457c20 in leveldb::DBImpl::CompactMemTable() ()
#3  0x000000000045a507 in leveldb::DBImpl::BackgroundCompaction() ()
#4  0x000000000045adc2 in leveldb::DBImpl::BackgroundCall() ()
#5  0x0000000000474def in leveldb::(anonymous namespace)::PosixEnv::BGThreadWrapper(void*) ()
#6  0x0000003e63807851 in start_thread () from /lib64/libpthread.so.0
#7  0x0000003e630e890d in clone () from /lib64/libc.so.6


(gdb) bt
#0  0x000000000045f74e in leveldb::log::Writer::EmitPhysicalRecord(leveldb::log::RecordType, char const*, unsigned long) ()
#1  0x000000000045f905 in leveldb::log::Writer::AddRecord(leveldb::Slice const&) ()
#2  0x0000000000456404 in leveldb::DBImpl::Write(leveldb::WriteOptions const&, leveldb::WriteBatch*) ()
#3  0x000000000043d89b in BinlogQueue::commit() ()
#4  0x000000000043249f in SSDBImpl::set(Bytes const&, Bytes const&, char) ()
#5  0x0000000000408e96 in proc_set(NetworkServer*, Link*, std::vector<Bytes, std::allocator<Bytes> > const&, Response*) ()
#6  0x000000000044de35 in ProcWorker::proc(ProcJob*) ()
#7  0x000000000044b785 in WorkerPool<ProcWorker, ProcJob*>::_run_worker(void*) ()
#8  0x0000003e63807851 in start_thread () from /lib64/libpthread.so.0
#9  0x0000003e630e890d in clone () from /lib64/libc.so.6


2016/11/24 18:05:22
xiaoshua 2016/11/24 18:05:22
leveldb只能做kv存储 ssdb里就把它封装成kv, hash, zset, queue等
2016/11/24 18:06:07
Mr.Win 2016/11/24 18:06:07
主从 主主同步 用的自己的协议栈？
xiaoshua 2016/11/24 18:07:14
这个我没怎么研究过  我主要就看了下它的数据结构是怎么封装的
Mr.Win 2016/11/24 18:07:24
哦
xiaoshua 2016/11/24 18:07:25
不过同步原理也都是大同小异的
2016/11/24 18:09:01
Mr.Win 2016/11/24 18:09:01
恩 你现在是做大数据 用 spark?
Mr.Win 2016/11/24 18:09:22
我想学习不知道从何入手啊
Mr.Win 2016/11/24 18:09:28
求大神指点一下
2016/11/24 18:10:37
xiaoshua 2016/11/24 18:10:37
我就一普通java开发... 
Mr.Win 2016/11/24 18:11:25
哦 
Mr.Win 2016/11/24 18:11:32
那你还用 表达式啊
Mr.Win 2016/11/24 18:11:55
我们现在jdk只用1.6的
xiaoshua 2016/11/24 18:12:24
1.9都快出了 你们还1.6... 
2016/11/24 18:12:58
Mr.Win 2016/11/24 18:12:58
对的 1.6 1.7
Mr.Win 2016/11/24 18:13:07
大公司 没办法哈 自己可以随便用
xiaoshua 2016/11/24 18:13:58
不过差别也不大
Mr.Win 2016/11/24 18:14:26
恩 
2016/11/24 18:38:48
怪怪龙滴~~咚 2016/11/24 18:38:48
我主要用LevelDB 存储 raft算法的日志
怪怪龙滴~~咚 2016/11/24 18:38:56
 还是有点麻烦
lonsoft 2016/11/24 18:39:15
raft
lonsoft 2016/11/24 18:39:19
高大山
怪怪龙滴~~咚 2016/11/24 18:39:24

lonsoft 2016/11/24 18:39:44

怪怪龙滴~~咚 2016/11/24 18:40:07

xiaoshua 2016/11/24 18:40:10

