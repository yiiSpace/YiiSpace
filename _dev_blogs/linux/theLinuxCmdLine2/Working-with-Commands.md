创建自己的命令
========

先确定命令不存在

> 
    yiqing@yiqing-VirtualBox:~$ type test
    test is a shell builtin
    yiqing@yiqing-VirtualBox:~$ type mycmd
    -bash: type: mycmd: not found


用别名创建我们自己的命令

> alias foo='cd /usr ; ls ; cd - '

多个命令可以用分号隔开  cd - 返回原始目录去

~~~shell

yiqing@yiqing-VirtualBox:~$ alias foo='cd /usr ; ls ; cd - '
yiqing@yiqing-VirtualBox:~$ foo
bin  games  include  lib  local  locale  sbin  share  src
/home/yiqing
yiqing@yiqing-VirtualBox:~$


~~~

别名语法：
> alias name='string'

查看foo的类型

> yiqing@yiqing-VirtualBox:~$ type foo
  foo is aliased to `cd /usr ; ls ; cd - '
  
移除别名

> 
    yiqing@yiqing-VirtualBox:~$ unalias foo
    yiqing@yiqing-VirtualBox:~$ type foo
    -bash: type: foo: not found
    
>
    yiqing@yiqing-VirtualBox:~$ type ls
    ls is aliased to `ls --color=auto'

ls 就是带颜色支持的命令别名

~~~shell

yiqing@yiqing-VirtualBox:~$ alias
alias alert='notify-send --urgency=low -i "$([ $? = 0 ] && echo terminal || echo error)" "$(history|tail -n1|sed -e '\''s/^\s*[0-9]\+\s*//;s/[;&|]\s*alert$//'\'')"'
alias egrep='egrep --color=auto'
alias fgrep='fgrep --color=auto'
alias grep='grep --color=auto'
alias l='ls -CF'
alias la='ls -A'
alias ll='ls -alF'
alias ls='ls --color=auto'
~~~    
  
无参的alias 可以看到系统中所有的别名应用


别名有个小问题就是 当前会话结束后 就消失了  
