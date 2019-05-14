A Gentle Introduction to v i
=====

有一个古老的笑话 是关于一个游客在纽约市问一个路人 去城市的经典音乐会场
> Visitor: Excuse me, how do I get to Carnegie Hall?
   Passerby: Practice, practice, practice!
   
   游客：打扰下 我怎样才能去卡耐基音乐大厅呢？
   路人：练习  练习 练习
   
呵呵 路人以为游客想要成为出色的表演者 以登顶音乐大厅 实际上人家只是问个路

学习linux 命令行跟成为优秀的钢琴师一样 不是一个下午就能搞定的 需要经年累月的练习

vi 是unix传统中的核心程序   因其难用的的ui臭名昭著 但当你看到一个大师坐在键盘前开始“表演”时 我们确实会被某种
会成为某种伟大艺术的见证者

## 为啥要学vi
在当今图形化编辑器和易用的基于文本编辑器比如nano的时代为什么我们应该学习VI？ 有三因
- vi 总是可用 如果我们有一个没有图形界面的系统 比如远程服务器或者本地系统 有一个毁坏的 X configuration
 nano 可用拯救我们 但流行并不是通用 POSIX 兼容Unix系统的标准 需要vi存在
 - vi轻量级并且很快 对于很多任务 相比于在菜单中找一个图形文本编辑器 等待好几兆被加载 启动vi更容易
 另外 vi被设计于快速输入 如我们将看到的 一个老道的vi用户在编辑时不需要从键盘上离开其手指
 
 - 我们不想让其他linux合unix用户认为我们是懦夫
 
 好吧 可能是两个好原因
 
 ## 一点背景
 第一版的vi在1976年由Bill Joy写成 在加利福利亚的大学一个伯克利的学生 他后来去联合创建了Sun Microsystems.
 vi之名源于单词“visual”visual editor之前有 line editors.... 省略几百字...
 
 
 很多Linux发行版并不包括真正的vi 而是 一个强化版的替换品 称为vim（是“vi improved”的简称）由Bram Moolenaar写成
 
 ## 启动 停止 vi
 简单的键入
 > vi
  
 回车
 
 同 nona一样 第一件要学的就是如何退出：
 > :q
 
 如果我们做了一些修改 那么想退出可能就不那么顺利了 可以强制退出
 > :q!
 
 TIP 如果在vi中迷失了 那么连续按  ESC 两次 就会找到出路了
 
 ## 编辑模式
 再次开始vi 这次传一个不存在的文件名给他  这就是如何用vi创建新文件的方式
 > rm -f foo.txt
    vi foo.txt
    
如果一切顺利 我们会看到一个这样的屏幕
> ~
  ~
  ~
  ~
  ~
  ~
  ~
  ~
  ~
  
首部的tilde ~ 字符表示此行没有文本 这表示我们有一个空文件 先不要输入任何东西      
 
 第二重要的东西关于vi要了解的事（在知道如何退出后）vi是模式对话框 当vi开启时 它始于 command mode命令行模式
 在此模式下 任何键入都是一个命令 所以如果我们开始输入 vi会变疯掉的
 
 ### 进入编辑模式
 为了给我们的文件中加入一些文本，我们首先必须进入插入模式  通过i 键可以做到
 之后 可以输入一些文本
 
 为了退出插入模式并返回到命令行模式 按 ESC键
 
 ### 保存我们的工作
 在命令模式下进入 ex命令 可以简单的通过按 : 键  之后冒号会出现在屏幕底部
 
 为了写入修改的文件，在冒号后跟一个w 之后 按回车
 > :w
 
 文件会被写入到硬盘驱动 我们应该会在屏幕的底部得到确认信息
 
 TIP  如果你读vim的文档  你会注意到（迷惑的）命令模式被称为 normal mode
 ex 命令被称为 command mode ，留意下！
 
 ### 移动鼠标
 
 当在命令模式下 vi提供了很多移动命令 其中一些跟 less 共享 下面列出一部分：
 
 Cursor Movement Keys
 
 Key Moves the cursor
 l or right arrow Right one character.
 h or left arrow Left one character.
 j or down arrow Down one line.
 k or up arrow Up one line.
 0 (zero) To the beginning of the current line.
 ^ To the first non-whitespace character on the current line.
 $ To the end of the current line.
 w To the beginning of the next word or punctuation character.
 W To the beginning of the next word, ignoring punctuation
 characters.
 b To the beginning of the previous word or punctuation
 character.
 B To the beginning of the previous word, ignoring punctuation
 characters.
 ctrl-F or page down Down one page.
 ctrl-B or page up Up one page.
 numberG To line number. For example, 1G moves to the first line of
 the file.
 G To the last line of the file. 
 
 
 为什么 h j k 和 l 会被用来移动光标？  在vi写成的时候 不是所有的视频终端都有 箭头键  熟练的打字员可以使用常规的键盘键来移动光标 而不用
 将他们的手指从键盘离开
 
 vi中的很多命令都可以冠以数字前缀  比如表中的G 通过用数字前缀在一个命令前
 我们可以指定命令执行该数字个次数 比如命令5j 导致vi移动鼠标向下 5行。
 
 ### 基本编辑
 
常规任务 增删改 复制 黏贴

有限的undo   命令行下 u

### 添加文本

a 命令

因为在一行行尾添加文本很常用  vi 提供了 A 命令 这个捷径

首先可以使用 0 命令 移动到行首

### 开启一行
两行中间插入一行

Line Opening Keys
Command                 Opens
o               The line below the current line
O               The line above the current line 
 
ESC 退出编辑模式 u 命令撤销一步

### 删除文本

x 命令删除当前光标位置 x可以冠以数字前缀表示删几个字符
d 命令更通用的目的 同x 一样可以冠以数字前缀

Text Deletion Commands

Command                     Deletes
x                           The current character
3x                          The current character and the next two characters
dd                          The current line
5dd                         The current line and the next four lines
dW                          From the current cursor position to the beginning of the next word
d$                          From the current cursor location to the end of the current line
d0                           From the current cursor location to the beginning of the line
d^                          From the current cursor location to the first non-whitespace character in
                            the line
dG                          From the current line to the end of the file
d20G                        From the current line to the twentieth line of the file

使用 d  和 u 命令试试删除 和 undo

NOTE 真的vi 只支持一个单级的undo vim支持多级

dw 删除字
d$ 删除当前光标到行尾间的字符
dG 删除当前光标到文件末尾的东西

u  回退操作  

可以自己演练下

### Cutting Coping and Pasting Text

d命令除了删除文本 也“cuts”文本 每次我们使用d命令 删除会被拷贝至paste buffer（想想 clipboard）
之后可以用 p命令来粘贴缓冲内容到 光标之前或之后

y 命令以差不多同样的方式来“yank”（copy）文本 

Yanking Commands

Command                     Copies
yy                          The current line
5yy                         The current line and the next four lines
yW                          From the current cursor position to the beginning of the next word
y$                          From the current cursor location to the end of the current line
y0                          From the current cursor location to the beginning of the line
y^                          From the current cursor location to the first non-whitespace character in
                            the line
yG                          From the current line to the end of the file
y20G                        From the current line to the twentieth line of the file

配合u 撤销命令 随便试试吧

### Joining Lines

不要和 j 混淆    虽然字符一样
使用 大写的 J 可以join两行文本

### 搜索和替换

vi可以根据搜索 移动光标到指定位置 可以在单行或者整个文件中这样做
也可以执行文本替换 用或者不用用户确认。

- 行中搜索  
使用f 命令
比如 fa 会移动光标到a字符在一行中的下次出现  通过输入 ; semicolon 继续搜索

- 搜索整个文件

为了移动光标到一个字或者短语的下次出现 / 命令被使用

当我们使用  / 命令时 反斜杠会出现在屏幕的底部 下一步输入字 或者phrase 敲enter键来搜索

搜索可以通过用 n 命令重复

vi允许使用 正则表达式来搜索

### 全局搜索和替换

vi 使用ex命令 来执行搜索和替换操作（substitution in vi）在一些行范围内 或者整个文件

为了改变 在整个文件中 Line 到  line 可以键入下面的命令：
> :%s/Line/line/g

打碎解释下每个项的含义：

An Example of Global Search-and-Replace Syntax

Item                    Meaning
:               The colon character starts an ex command.
%               This specifies the range of lines for the operation. % is a shortcut meaning
                from the first line to the last line. Alternately, the range could have
                been specified 1,5 (since our file is five lines long) or 1,$, which means
                “from line 1 to the last line in the file.” If the range of lines is omitted,
                the operation is performed only on the current line.
s               This specifies the operation. In this case, it’s substitution
                (search-and-replace).
/Line/line/     This specifies the search pattern and the replacement text.
g               This means “global” in the sense that the search-and-replace is performed
                on every instance of the search string in the line. If omitted,
                only the first instance of the search string on each line is replaced. 
                
替换命令也可以指定用户确认
> :%s/line/Line/gc

确认消息                
> replace with Line (y/n/a/q/l/^E/^Y)?

含义：
Replace Confirmation Keys

Key                 Action
y                   Perform the substitution.
n                   Skip this instance of the pattern.
a                   Perform the substitution on this and all subsequent instances of the
                    pattern.
q or esc            Quit substituting.
l                   Perform this substitution and then quit. This is short for “last.”
ctrl-E, ctrl-Y      Scroll down and scroll up, respectively. This is useful for viewing the
                    context of the proposed substitution.
                    
                    
## 编辑多个文本

> vi f1 f2 f3 ...

多文件间切换

> :bn

移回前面的文件 使用 
> :bp

如果当前文件有未保存的更改 vi会阻止我们切换文件的 
强制vi切换文件 并放弃修改 通过给命令添加（!）

>:buffers 

命令可以看到那些文件被编辑

为了切换到另一个文件的buffer 通过键入:buffer 跟一个数字

另一个方式可以改变buffers是使用 :bn( buffer next 的简称) and :bp( buffer previous 简称)

### 打开额外的文件用来编辑

可以添加其他文件到当前的编辑会话中  ex命令:e(short for "edit")跟一个文件名 会打开额外文件

## 从一个文件拷贝内容到另一个

在编辑多个文件的时候经常想拷贝一个文件的一部分到另一个正在编辑的文件去 这很容易的使用常规的 yank和paste命令 

可以展示如下
首先使用我们的两个文件  切换到 buffer 1(foo.txt) 通过键入:
> :buffer 1

接下来 移动光标到第一行  键入 yy 来拷贝此行   
切换到第二个缓存 通过键入:
> :buffer 2

移动光标到第一行 通过p命令 可以粘贴从前面文件拷贝过来的行

### 插入整个文件到另一个文件           

> :r some-file.txt

:r 命令 （short for “read”）插入指定文件在光标位置


## 保存我们的工作

ZZ 会保存当前文件并退出 vi
:wq

:w命令 也可以指定一个额外的文件名 行为像Save As 
>  :w foo1.txt

保存当前文件为 另一个文件

## 总结

vi风格的编辑器 是如此深的嵌入到Unix 文化中 我们会看到很多其他的程序已经被这种设计所影响  less 就是很好的一个例子     