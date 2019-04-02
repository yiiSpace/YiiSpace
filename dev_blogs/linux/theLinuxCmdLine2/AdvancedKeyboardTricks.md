Unix 人是不是都爱敲键盘

命令行 都很短  都是一些懒人呀

尽量不要离开键盘 跑去摸鼠标

下面的命令会先出场
- clear 清除终端屏幕
- history 显示或操纵历史列表

### 编辑命令行

bash 使用了一个库（一个共享的不同程序可以使用的例程集合）称之为Readline来实现命令行编辑

我们已经见过其中的一些了 比如箭头移动鼠标 但是存在更多的特性
没必要全学 但其中的一些还是很有用的

光标移动

Table 8-1: Cursor Movement Commands
>Key                    Action
    ctrl-A                  Move cursor to the beginning of the line.
    ctrl-E                  Move cursor to the end of the line.
    ctrl-F                  Move cursor forward one character; same as the right arrow key.
    ctrl-B                  Move cursor backward one character; same as the left arrow key.
    alt-F                   Move cursor forward one word.
    alt-B                   Move cursor backward one word.
    ctrl-L                  Clear the screen and move the cursor to the top-left corner. The clear
    command                 does the same thing.


文本编辑

Key Action
ctrl-D              Delete the character at the cursor location.
ctrl-T              Transpose (exchange) the character at the cursor location with the one
                    preceding it.
alt-T               Transpose the word at the cursor location with the one preceding it.
alt-L               Convert the characters from the cursor location to the end of the word
                    to lowercase.
alt-U               Convert the characters from the cursor location to the end of the word
                    to uppercase.
                    
复制粘贴文本（(Killing and Yanking)）
Readline 文档使用 kill和yank 来指我们经常称之为剪切 拷贝 被剪切的项目被存储在一个缓存中(内存中的临时存储区) 称为kill-ring 

Key                     Action
ctrl-K                  Kill text from the cursor location to the end of line.
ctrl-U                  Kill text from the cursor location to the beginning of the line.
alt-D                   Kill text from the cursor location to the end of the current word.
alt-backspace           Kill text from the cursor location to the beginning of the current word. If
                        the cursor is at the beginning of a word, kill the previous word.
ctrl-Y                  Yank text from the kill-ring and insert it at the cursor location.                                                     

meta key经常映射到现代键盘的 alt键  但并不总是这样的


补全

tab键    ls xx

按下tab键 就会找到最匹配的那个文件|文件夹

》  这个有点类似现在web搜索中的前缀搜索  考虑下如何实现？

While this example shows completion of pathnames, which is its most
common use, completion will also work on variables (if the beginning of the
word is a $), usernames (if the word begins with ~), commands (if the word is
the first word on the line), and hostnames (if the beginning of the word is @).
Hostname completion works only for hostnames listed in /etc/hosts.


程序式补全 用shell函数实现
大概了解下：
> set | less


## 使用历史
bash 维护了一个已输入的命令历史 此命令列表保存在home目录下的文件 bash_history

- 搜索历史
任何时候都可查看命令历史内容通过：
> history | less 

默认情况 bash 至少存储500条已输入的命令 而大部分的版本将此值设为1000 可手动设置哟

来看看我们想搜索下 关于/usr/bin 的命令历史

> yiqing@yiqing-VirtualBox:~$ history | grep /usr/bin
    145  cd /usr/bin/php
    147  cd /usr/bin
    222  cd /usr/bin
    332  file $(ls -d /usr/bin/* | grep zip)
    355  history | grep /usr/bin
    
前面的数字就是历史列表中所处的行号，我们可以用一种称之为history expansion 的展开类型来使用它
> !145
  cd /usr/bin/php
  -bash: cd: /usr/bin/php: Not a directory    
  
感叹号跟行号

渐进式搜索（增量？） 
> Ctrl + R + 要搜索的文本
找到之后 按 enter来执行 或者Ctrl+J 从历史列表中拷贝此行到当前命令行  再次按 Ctrl+R 会往上找到下一个出现（历史是往后滚动的我们是反向行进）
Ctrl+C 或者Ctrl+G退出搜索

>  (reverse-i-search)`/usr/bin': ls -l /usr/bin > ls-output.txt

reverse-i-search 代表的是  逆向 incremental搜索

操纵历史列表的键盘组合：

Key Action
ctrl-P                  Move to the previous history entry. This is the same action as the up arrow.
ctrl-N                  Move to the next history entry. This is the same action as the down arrow.
alt-<                   Move to the beginning (top) of the history list.
alt->                   Move to the end (bottom) of the history list, i.e., the current command line.
ctrl-R                  Reverse incremental search. This searches incrementally from the current command
                    line up the history list.
alt-P                   Reverse search, nonincremental. With this key, type in the search string and
press                   enter before the search is performed.
alt-N                   Forward search, nonincremental.
ctrl-O                   Execute the current item in the history list and advance to the next one. This
                    is handy if you are trying to re-execute a sequence of commands in the
                    history list.               
                    
- 历史展开

叹号前缀

Sequence Action
!!                      Repeat the last command. It is probably easier to press the up arrow
                        and enter.
!number                 Repeat history list item number.
!string                 Repeat last history list item starting with string.
!?string                Repeat last history list item containing string.


### script

除了bash中的命令历史特性，很多发行版也包含了一个称之为 script的程序 可用来记录整个shell会话 并将之存储在一个文件中 
基本语法：
> script  file

file是用来存储记录的文件名称 如果未指定文件名称 默认使用typescript  可以看下 man script手册页                           