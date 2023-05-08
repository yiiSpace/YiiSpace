IO 重定向
=========

输入输出  管道 流


-   cat             Concatenate files
-   sort            Sort lines of text
-   uniq             Report or omit repeated lines
-   grep            Print lines matching a pattern
-   wc              Print newline, word, and byte counts for each file
-   head            Output the first part of a file
-   tail            Output the last part of a file
-   tee             Read from standard input and write to standard output and files

标准输入输出和错误

### 程序的输出一般分两类
- 程序的结果 ： 程序设计要产生的数据
- 状态和错误信息： 告诉我们程序的运行情况

如果我们看一个命令 比如ls 我们可以看到其结果和错误信息被显示在屏幕上
保持Unix “万物皆文件”的宗旨 像ls这样的程序实际上输出其结果到一个特殊的文件“standard output”（stdout 标准输出）
其状态信息到另一个文件：“standard error”（stderr) 默认情况此二者都连接到屏幕而不是一个磁盘文件

此外 很多程序从一个称为：standard input(stdin) 的设备拿其输入 。此设备默认连接到键盘 

IO重定向 允许我们改变输出的去向和输入的来源 通常输出去到屏幕 输入来自键盘 但用IO重定向我们可以改变这种情况

#### 重定向标准输出  

``>`` 重定向符号

> yiqing@yiqing-VirtualBox:~/playground$ ls -l /usr/bin > ls-output.txt

上例中 告诉shell把ls的输出发送的文件 ls-output.txt中

看下结果

> yiqing@yiqing-VirtualBox:~/playground$ ls -lh
total 120K
-rw-rw-r-- 1 yiqing yiqing 119K 3月  23 08:21 ls-output.txt

用less命令看下文件内容

>yiqing@yiqing-VirtualBox:~/playground$ less ls-output.txt

如果是程序的错误输出呢
> ls -l /bin/usr > ls-output.txt
  ls: cannot access /bin/usr: No such file or directory
  
程序的错误并没有输出到 ls-output.txt 原因是ls的错误信息并没有输出到stdout标准输出 而是像很多良构的unix程序那样发送到了
标准错误 而我们仅仅重定向了标准输出 而不是标准错误 错误信息依旧发送到了屏幕

先看看文件内容：
> yiqing@yiqing-VirtualBox:~/playground$ ls ls-output.txt  -l
  -rw-rw-r-- 1 yiqing yiqing 0 3月  23 08:32 ls-output.txt


会发现 文件变0长度了 当使用重定向>符号时 目标文件总是从头被重写 因为上例中ls并没有产出结果而只是输出错误信息导致
文件内容被截断

实际上如果我们想截断文件（或者创建一个新的空文件）可以使用这样的小把戏：
> > ls-output.txt

追加 ``>>`` 追加重定向操作符

> ls -l /usr/bin >> ls-output.txt

如果目标文件不存在将被创建

### 重定向标准错误

必须使用``file descriptor`` 文件描述符来重定向标准错误输出

一个程序可以产生输出到任意多个文件流  我们已经谈及这些流中的前三个：标准输入 标准输出  标准错误 shell在内部分别用
文件描述符 0 1 2 来引用他们 shell提供了一种符号 使用文件描述符号 来重定向文件 因为标准错误和文件描述符2是一样的
我们可以用2来重定向标准错误

> yiqing@yiqing-VirtualBox:~/playground$ ls -l /bin/usr 2> ls-error.txt ; ls ls-error.txt -l
  -rw-rw-r-- 1 yiqing yiqing 56 3月  23 08:48 ls-error.txt

文件描述符2紧邻文件重定向符号用以重定向标准错误至ls-error.txt

### 重定向标准错误和标准输出到一个文件  

>  ls -l /bin/usr > ls-output.txt 2>&1

用此法 首选标准输出重定向到ls-output.txt 后标准错误到标准输出 2>&1
顺序很重要 标准错误重定向必须出现在标准输出重定向之后 不然不管用了

最新版的bash提供了另一种更流式化的方法：

> ls -l /bin/usr &> ls-output.txt

``&>`` 标准错误和标准输出被重定向到同一目标去了 
也可以追加： `&>>`

### 丢弃不想要的输出

沉默是金  

特殊的文件 dev/null 此文件是一个系统设备(称为 bit bucket 是一种unix文化 古老的概念) 接受输入但不做任何事情
 为了压制来自命令的错误消息我们可以这样
> ls -l /bin/usr 2> /dev/null 

## 重定向标准输入

Cat  (Concatenate files) 读取多个文件并拷贝其内容到标准输出

可以认为cat是dos下等价命令 ``type`` 
不用分页的显示文件
>  cat ls-output.txt

猫cat 经常用来显示端文本文件  也可以用来连接内容

比如网络下载中多个二进制分片重新连接成一个文件
>  
    movie.mpeg.001 movie.mpeg.002 ... movie.mpeg.099
    we could join them back together with this command:
    cat movie.mpeg.0* > movie.mpeg  

``*``  通配符总是有序的 所以可以保证文件不乱序

如果cat 没有提供参数 它将从标准输入（键盘）读取内容 而后使用ctrl+D 来终止输入
>     
    yiqing@yiqing-VirtualBox:~/playground$ cat
    hi this is some
    hi this is some
    text
    text

当确实文件名参数时 cat 拷贝标准输入到标准输出 所以我们看到输入的文本被重复了
可用此特性创建短文本文件
> cat > lazy_dog.txt
  yiqing@yiqing-VirtualBox:~/playground$ cat > lazy-dog.txt
  hello this is some random typing
  yiqing@yiqing-VirtualBox:~/playground$ cat lazy-dog.txt
  hello this is some random typing

标准输入的内容被重定向到了 lazy-dog.txt 中

重定向标准输入
> yiqing@yiqing-VirtualBox:~/playground$ cat < lazy-dog.txt
  hello this is some random typing

使用 ``<`` 我们改变了标准输入的源 从键盘到 lazy-dog.txt 看到结果跟传递一个单文件参数是一样的！和传递文件参数相比
这没什么太大用处 但它用来展示了 使用一个文件作为标准输入的源

可以看看cat 命令的手册  (一个男人 一个猫 ^_^)
> man cat 

## 管道

命令从标准输入读取内容并发送到标准输出的能力经常被shell特性所使用 称之为“pipeline”管道

> cmd1  |  cmd2 

串起来

分页式查看
> ls -l /usr/bin | less

用此技术我们可以方便地查看任何命令的标准输出内容

## 过滤

多个命令放在一个管道中 经常被称之为“filter”过滤器
过滤器拿到输入 做某种修改 之后输出

首先我们可以试下``sort`` 排序

假设我们想把/bin 目录下的可执行程序进行排序 之后查看结果列表
> ls /bin /usr/bin | sort | less

这里给了两个目录 /bin 和 /usr/bin 

### 管道和重定向的区别

> 
    command1 > file1
    command1 | command2
    
滥用
>   cmd1 > cmd2

真实案例：
>  # cd /usr/bin
   # ls > less
   
第一条命令切换目录到 /usr/bin 去  第二条命令是把 ls的输出写到 less文件去  恰巧这个文件存在！ 这样破坏掉了less程序的内容
导致程序被损坏！


区别：
重定向操作符总是隐含的创建或者复写文件！ 所以你得注意这方面

### uniq 汇报或者漏掉重复的行

uniq命令经常和sort命令一起出现
>  ls /bin /usr/bin | sort | uniq | less


wc 打印行 单词和字节数
> yiqing@yiqing-VirtualBox:~/playground$ wc ls-output.txt
   1  9 56 ls-output.txt
   
第一列时行数 第二列是字数 第三列是字节数          

``-l``选项可以限制程序只打印行数
> yiqing@yiqing-VirtualBox:~/playground$ wc ls-output.txt -l
  1 ls-output.txt

添加到管道做统计
> 
    yiqing@yiqing-VirtualBox:~/playground$ ls /bin /usr/bin | sort | uniq | wc -l
    2016

可以看到大概两千多个程序！

### grep 打印匹配模式的行

用来在文件中查找匹配的模式
用法：
> grep pattern filename 

当grep碰到文件中的模式 会打印出包含模式的行
>  yiqing@yiqing-VirtualBox:~/playground$ ls /bin /usr/bin | sort |uniq | grep zip
  bunzip2
  bzip2
  bzip2recover
  funzip
  gpg-zip
  gunzip
  gzip
  mzip
  preunzip
  prezip
  prezip-bin
  unzip
  unzipsfx
  zip
  zipcloak
  zipdetails
  zipgrep
  zipinfo
  zipnote
  zipsplit
  
grep 有些好用的选项
- -i 执行搜索时忽略大小写（通常的搜索时是大小写敏感的！）  
- -v 只打印不匹配模式的行  
>   yiqing@yiqing-VirtualBox:~/playground$ ls /bin /usr/bin | sort |uniq | grep zip -v | wc -l
    1996

可以看到 不含zip关键字的程序越 1996个

### head/tail : 打印文件最首/最末部分

默认都是10行
通过-n 选项来指定行数：
>   yiqing@yiqing-VirtualBox:~/playground$ head ls-output.txt  -n 5
    /bin:
    total 12988
    -rwxr-xr-x 1 root root 1037528 5月  16  2017 bash
    -rwxr-xr-x 1 root root   31288 5月  20  2015 bunzip2
    -rwxr-xr-x 1 root root 1964536 8月  19  2015 busybox
    
用于管道
> yiqing@yiqing-VirtualBox:~/playground$ ls /bin | tail -5
    zforce
    zgrep
    zless
    zmore
    znew

tail 有个选项允许我们实时的查看文件 这在观察日志文件进度时比较有用
> tail -f /var/log/messages

使用-f 选项tail 持续监控文件 当新行添加时将立即被显示 可以用ctrl+c来中断显示。

### tee
为了保持我们的管道隐喻，Linux提供了一个命令： tee 来创建一个“tee”（T型）来适配我们的管道
（想下水管中的T型分流头）该程序从标准输入读入并将其拷贝到一个标准输出和一个或者多个其他文件
这对在一个处理流的中间阶段 捕获管道内容很有用

> ls /usr/bin | tee ls.txt | grep zip

 中间过程输出到了ls.txt 文件
 
 此篇列出的都是命令的常用情形 更多选项请看手册页    
       
