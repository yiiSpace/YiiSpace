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


