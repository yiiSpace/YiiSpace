
### 展开expansion
每次我们敲一个命令并按下enter键时，shell在执行命令前 在文本上执行了很多替换  比如* 对shell有很多意思 让此发生的过程
称之为expansion 通过它 我们输入一些内容 这些内容在命令作用其上前展开成其他东西

看个演示
> yiqing@yiqing-VirtualBox:~/playground$ echo hello world
  hello world


> yiqing@yiqing-VirtualBox:~/playground$ echo *
  lazy-dog.txt ls-error.txt ls-output.txt ls.txt

上例中* 被shell扩展成其他东西（当前工作目录下的文件名称）在echo执行前 Enter键按下后 shell自动展开一些特定字符
所以 echo 从来执行时不会看到*的 只会看到展开的结果 知道这个我们就明白了 echo确入期望的那样工作的。  

### 路径名展开

> yiqing@yiqing-VirtualBox:~$ ls
  Desktop    Downloads         Music     playground  share      tools   yiqing-space
  Documents  examples.desktop  Pictures  Public      Templates  Videos

> yiqing@yiqing-VirtualBox:~$ echo D*
  Desktop Documents Downloads

> yiqing@yiqing-VirtualBox:~$ echo *S
    *S
    yiqing@yiqing-VirtualBox:~$ echo *s
    Documents Downloads Pictures Templates tools Videos
大小写敏感！

>   yiqing@yiqing-VirtualBox:~$ echo [[:upper:]]*
    Desktop Documents Downloads Music Pictures Public Templates Videos
    
隐藏文件 （形如 ..xx不显示哦 ）
> ls -d .* | less

只有一个. 后跟一个或者多个非.的字符
> echo .[!.]*

-A 选项(almost all) 显示 包括隐藏文件在内的所有文件
> ls -A
    
    
### 破折号 Tilde 展开

`~` 用在字首时展开成主目录的名称
>   yiqing@yiqing-VirtualBox:~$ echo ~/playground
    /home/yiqing/playground

此处展开为 /home/yiqing   yiqing是当前用户

如果有用户名存在 有账号 即 ~somename 展开成什么还要取决于后面的word是否是用户账号

> yiqing@yiqing-VirtualBox:~$ echo ~yiqing
  /home/yiqing


> yiqing@yiqing-VirtualBox:~$ echo  ~yiqing/playground
  /home/yiqing/playground
  yiqing@yiqing-VirtualBox:~$ echo ~/playground
  /home/yiqing/playground
 
 可以看到两个结果一样！
 
 ### 数学展开
 
 语法
 $((expr))
 
 > yiqing@yiqing-VirtualBox:~$ echo $((1+6))
   7
     
只支持整数   

>   yiqing@yiqing-VirtualBox:~$ echo $((1.2 + 3))
     -bash: 1.2 + 3: syntax error: invalid arithmetic operator (error token is ".2 + 3")
    yiqing@yiqing-VirtualBox:~$ echo $(( 1+3 ))
    4

支持的操作符

Operator            Description
    +           Addition
    -           Subtraction
    *           Multiplication
    /           Division (but remember, since expansion supports only integer
                arithmetic, results are integers)
    %           Modulo, which simply means “remainder”
    **          Exponentiation
 
 空格在数学表达式中不重要，表达式可以嵌套
 >  yiqing@yiqing-VirtualBox:~$ echo $(( $((5**2)) * 3  ))
    75
    
单个括号可用来归组多个子表达式 用此技术可重写上面的表达式
> yiqing@yiqing-VirtualBox:~$ echo $(( (5**2) * 3   ))
  75

整除 与 余数
> yiqing@yiqing-VirtualBox:~$  echo five divided by two equals $((5/2))
  five divided by two equals 2
  yiqing@yiqing-VirtualBox:~$ echo with $((5%2)) left over
  with 1 left over


### 括号展开

最奇怪的展开就是符号展开 通过它可以从模式创建多个文本
> yiqing@yiqing-VirtualBox:~$ echo Front-{A,B,C}-Back
  Front-A-Back Front-B-Back Front-C-Back

>  Patterns to be brace expanded may contain a leading portion called a
   preamble and a trailing portion called a postscript. The brace expression itself
   may contain either a comma-separated list of strings or a range of integers
   or single characters. The pattern may not contain unquoted whitespace.
   Here is an example using a range of integers:
   [me@linuxbox ~]$ echo Number_{1..5}
   Number_1 Number_2 Number_3 Number_4 Number_5
   
bash4.0 之后 整数可以 用0补全
> yiqing@yiqing-VirtualBox:~$ echo {01..15}
  01 02 03 04 05 06 07 08 09 10 11 12 13 14 15

> echo {001..15}
  001 002 003 004 005 006 007 008 009 010 011 012 013 014 015
  
反序字符范围
> yiqing@yiqing-VirtualBox:~$ echo {Z..A}
  Z Y X W V U T S R Q P O N M L K J I H G F E D C B A

花括号展开可以嵌套
> echo a{A{1,2},B{3,4}}b
  aA1b aA2b aB3b aB4b
  
实际用途 比如可以按照年月模式来创建文件夹
> yiqing@yiqing-VirtualBox:~$ cd playground/
  yiqing@yiqing-VirtualBox:~/playground$ mkdir photos
  yiqing@yiqing-VirtualBox:~/playground$ ls
  lazy-dog.txt  ls-error.txt  ls-output.txt  ls.txt  photos
  yiqing@yiqing-VirtualBox:~/playground$ cd photos
  yiqing@yiqing-VirtualBox:~/playground/photos$ mkdir {2007..2009}-{01..12}
  yiqing@yiqing-VirtualBox:~/playground/photos$ ls
  2007-01  2007-05  2007-09  2008-01  2008-05  2008-09  2009-01  2009-05  2009-09
  2007-02  2007-06  2007-10  2008-02  2008-06  2008-10  2009-02  2009-06  2009-10
  2007-03  2007-07  2007-11  2008-03  2008-07  2008-11  2009-03  2009-07  2009-11
  2007-04  2007-08  2007-12  2008-04  2008-08  2008-12  2009-04  2009-08  2009-12

相当聪明

（有点像数学上的排列组合）

### 参数展开 Parameter expansion

此特性在shell脚本比在命令行中相比更有用 很多相关功能是用系统能力存储小块数据 并给每块一个名称 ，很多这样的
块 更贴切的称之为 variables （变量）

执行参数展开：
> yiqing@yiqing-VirtualBox:~/playground/photos$ echo $USER
  yiqing
  
查看可用的变量
> printenv | less

如果拼错了变量名 那么展开不会发生 站位但是空串

### 命令替换
命令替换 允许我们使用命令的输出作为一个展开
> yiqing@yiqing-VirtualBox:~$ echo $(ls)
  Desktop Documents Downloads examples.desktop Music Pictures playground Public share Templates tools Videos yiqing-space
  
>  ls -l $(which cp)
  -rwxr-xr-x 1 root root 151024 3月   3  2017 /bin/cp*

把which cp的结果作为参数传递给ls 

> file $(ls -d /usr/bin/* | grep zip)

整个命令管道的结果作为file 命令的参数

命令替换有另一种语法在老式的shell程序中 现代bash也支持 就是 反引号 来替代$(...) 形式 比如
> echo `ls`
    
    
### 引号
> echo The total is $100.00
  The total is 00.00

展开$1  是一个空串 ！      $1 是未定义的变量 shell提供了一种quoting机制用来选择性的压制不想要的展开

双引号
第一种quoting 就是双引号 双引号中的字符串 失去其特殊语义并被作为普通字符对待。 几个例外：$ \ `
这意味着 字符分割，路径名展开，大括号展开 tilde展开（~）将被压制  然而参数展开 数学展开 和命令替换依旧管用。

文件名中的空格
> ls -l "two words.txt"  
   
    
>   yiqing@yiqing-VirtualBox:~$ echo "$USER $((2+2 ))  $(cal) "
    yiqing 4        三月 2019
    日 一 二 三 四 五 六
                    1  2
     3  4  5  6  7  8  9
    10 11 12 13 14 15 16
    17 18 19 20 21 22 23
    24 25 26 27 28 29 30
    31

看到变量名  数学展开  命令替换 依旧被执行

> $ echo this is a      test
  this is a test

默认情况 字分割会找到 空格 tabs 和新换行 并将其视为字分割符 （是不是这个:  \s*）这意味着 未括起来的 空格
tabs 合newlines 不被认为是文本的一部分 他们只是separators

> $ echo "this is a        test"
  this is a        test

括起来 字分割就被压制了 嵌入的空格就不被视为分隔符了 一旦双引号被加上 我们的命令行就变成一个命令跟一个参数了      
 
在字分割机制下newlines被认为是分割符 会产生很有趣的结果：
>  echo $(cal)
  三月 2019 日 一 二 三 四 五 六 1 2 3 4 5 6 7 8 9 10 11 12 13 14 15 16 17 18 19 20 21 22 23 24 25 26 27 28 29 30 31

> yiqing@yiqing-VirtualBox:~$ echo " $(cal)  "
         三月 2019
  日 一 二 三 四 五 六
                  1  2
   3  4  5  6  7  8  9
  10 11 12 13 14 15 16
  17 18 19 20 21 22 23
  24 25 26 27 28 29 30
  31
  
二者差异就是因为 newline 换行 空格被作为分割符了
第一种情形 未括起来的命令行替换 导致echo 命令有38个参数  
第二种情形 只有一个参数 不过里面含有内嵌的空格合换行而已  

### 单引号
如果想压制所有的展开 可以使用单引号  

未括
> yiqing@yiqing-VirtualBox:~$ echo text ~/*.txt {a,b} $(echo foo) $((2+2)) $USER
  text /home/yiqing/*.txt a b foo 4 yiqing

双引号括起来
> yiqing@yiqing-VirtualBox:~$ echo "text ~/*.txt {a,b} $(echo foo) $((2+2)) $USER "
  text ~/*.txt {a,b} foo 4 yiqing
  
单引号括起来
> yiqing@yiqing-VirtualBox:~$  echo 'text ~/*.txt {a,b} $(echo foo) $((2+2)) $USER '
text ~/*.txt {a,b} $(echo foo) $((2+2)) $USER  

可以看到 越往后 压制越严重


### 转义字符
有时我们只想括单个字符 此时可以用反斜杠转义 经常见于双引号中用于选择性阻止展开
> yiqing@yiqing-VirtualBox:~$ echo "The balance for user $USER is: \$5.00 "
  The balance for user yiqing is: $5.00
  
也经常用于转义文件名中特殊字符  对shell有特殊含义的字符也可以用于文件名 
$, !, &, spaces, and others.

> mv bad\&filename good_filename

### 反斜杠 转义序列

除了转义 反斜杠还可用于表示特殊字符 称为``control codes`` 
ASCII 码中的前32个字符用于在电报类似的设备中传输命令 。 其中的一些我们比较熟悉(
tab,
backspace, line feed, and carriage return
)  而另一些就不太熟了(null, end-oftransmission,
                   and acknowledge)
>
    \a Bell (an alert that causes the computer to beep)
    \b Backspace
    \n Newline; on Unix-like systems, this produces a line feed
    \r Carriage return
    \t Tab                   
    
使用反斜杠来表示的想法最初源于C语言 已经被其他语言采用了 包括shell

给echo添加 -e 选项 使得转义序列的interpretation得以开启 也可以放在 $' '中,  这里sleep命令睡了10秒
>   yiqing@yiqing-VirtualBox:~$ sleep 10; echo -e "Time is up \a"
    Time is up

定时提醒！
也可以这样
>  sleep 10; echo "Time's up" $'\a'     

### 总结

shell用的越多 越会发现 展开和quoting使用的很频繁
甚至被争议认为是学习shell的重要主题 对展开没有合适的理解 ，shell一直会是神秘和误解的源泉 对其潜能也是浪费了   


        

  