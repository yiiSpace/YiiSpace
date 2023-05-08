常用 通用命令
=========

- type Indicate how a command name is interpreted
- which Display which executable program will be executed
- help Get help for shell builtins
- man Display a command’s manual page
- apropos Display a list of appropriate commands
- info Display a command’s info entry
- whatis Display one-line manual page descriptions
- alias Create an alias for a command


## Command 类型

- usr/bin目录下的 c/C++ 程序 或者一些语言脚本 py ruby之类
- 内建  shell内建命令 如 cd
- shell 函数  
- 别名

### 查看cmd 类型

~~~shell


yiqing@yiqing-VirtualBox:~/playground$ type cd
cd is a shell builtin
yiqing@yiqing-VirtualBox:~/playground$ type type
type is a shell builtin
yiqing@yiqing-VirtualBox:~/playground$ type cat
cat is /bin/cat
yiqing@yiqing-VirtualBox:~/playground$ type ls
ls is aliased to `ls --color=auto'
yiqing@yiqing-VirtualBox:~/playground$ type cp
cp is hashed (/bin/cp)


~~~

### which 显示可执行的路径

可能存在同名文件的多版本安装 用which查看到底是哪个

~~~shell

yiqing@yiqing-VirtualBox:~/playground$ which ls
/bin/ls

~~~

只工作于可执行程序

~~~shell

yiqing@yiqing-VirtualBox:~/playground$ which cd
yiqing@yiqing-VirtualBox:~/playground$ chich cd -v
No command 'chich' found, did you mean:
 Command 'which' from package 'debianutils' (main)
chich: command not found

~~~

### 获取命令的文档

help

获取cd命令的帮助文档
> help cd

很多可执行程序本身也支持--help选项 显示命令支持的语法和选项 有些cmd不支持此选项 无论如何先用--help试下

~~~shell

yiqing@yiqing-VirtualBox:~$ mkdir --help
Usage: mkdir [OPTION]... DIRECTORY...
Create the DIRECTORY(ies), if they do not already exist.

Mandatory arguments to long options are mandatory for short options too.
  -m, --mode=MODE   set file mode (as in chmod), not a=rwx - umask
  -p, --parents     no error if existing, make parent directories as needed
  -v, --verbose     print a message for each created directory
  -Z                   set SELinux security context of each created directory
                         to the default type
      --context[=CTX]  like -Z, or if CTX is specified then set the SELinux
                         or SMACK security context to CTX
      --help     display this help and exit
      --version  output version information and exit

GNU coreutils online help: <http://www.gnu.org/software/coreutils/>
Full documentation at: <http://www.gnu.org/software/coreutils/mkdir>
or available locally via: info '(coreutils) mkdir invocation'


~~~
 

## less

- less is more

用来替换more命令的 具有pagenation 可分页信息展示特征


## man 

男人  显示应用程序的手册页(Manual page) 很多可执行程序提供正规的 手册页 man page
man 是一个特殊的分页（paging）程序用于查看这些命令

>
    Man pages vary somewhat in format but generally contain the following:
    • A title (the page's name)
    • A synopsis of the command’s syntax
    • A description of the command’s purpose
    • A listing and description of each of the command’s options
    
很多linux操作系统 man使用less 来显示手册页    

~~~shell


~~~

### 搜索 

- 段搜索
> man section search_term

-``apropos`` 显示合适的命令

在命令的man page中搜索关键字 粗鲁却管用的方式（简单粗暴）

>      
    yiqing@yiqing-VirtualBox:~$ apropos partition
    addpart (8)          - tell the kernel about the existence of a partition
    all-swaps (7)        - event signalling that all swap partitions have been activated
    cfdisk (8)           - display or manipulate a disk partition table
    cgdisk (8)           - Curses-based GUID partition table (GPT) manipulator
    delpart (8)          - tell the kernel to forget about a partition
    fdisk (8)            - manipulate disk partition table
    fixparts (8)         - MBR partition table repair utility
    gdisk (8)            - Interactive GUID partition table (GPT) manipulator
    gparted (8)          - GNOME Partition Editor for manipulating disk partitions.
    mpartition (1)       - partition an MSDOS hard disk
    partprobe (8)        - inform the OS of partition table changes
    partx (8)            - tell the kernel about the presence and numbering of on-disk p...
    resizepart (8)       - tell the kernel about the new size of a partition
    sfdisk (8)           - display or manipulate a disk partition table
    sgdisk (8)           - Command-line GUID partition table (GPT) manipulator for Linux...
    systemd-gpt-auto-generator (8) - Generator for automatically discovering and mountin..
    
括号中的就是 手册页 关键字出现的 段号

- whatis 显示匹配特殊关键字的一行手册页描述和名称

> .
  yiqing@yiqing-VirtualBox:~$ whatis mkdir
  mkdir (1)            - make directories
  mkdir (2)            - create a directory
  
  
手册页的用途是想作为引用文档的 而不是作为tutorials的 很多手册页都很难阅读 对新手帮助不是太大


## Info
显示一个程序的信息入口  

此gnu 项目可用于替换man  Info 页可有超链接 更像是一个web页
info 程序读取 树形结构的info文件到每个节点 一个节点对应一个topic

用法

> : info Commands
    Command                                 Action
    ?                               Display command help
    page up or backspace            Display previous page
    page down or spacebar           Display next page
    n                               Next—display the next node
    p                               Previous—display the previous node
    U                               Up—display the parent node of the currently displayed
    node,                               usually a menu
    enter                           Follow the hyperlink at the cursor location
    Q                               Quit 
        
显示 coreutils 包下的gnu项目

> info coreutils

自省

> info info

### READEME 和其他应用程序文档文件

很多安装在系统上的程序都有文档文件 寄居在
/usr/share/doc 目录下 有的是html页可以用浏览器浏览
 也可以是.gz 文件  这样可以用zless程序阅读（less的gzip功能版）
 
 
多个命令可以放在一行中

> command1; command2; command3... 

