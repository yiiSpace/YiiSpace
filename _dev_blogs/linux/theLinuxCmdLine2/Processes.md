Processes
======

多任务       快速切换

Linux使用进程来组织不同的程序在CPU上等待其执行时机。


- ps Report a snapshot of current processes
- top Display tasks
- jobs List active jobs
- bg Place a job in the background
- fg Place a job in the foreground
- kill Send a signal to a process
- killall Kill processes by name
- shutdown Shut down or reboot the system


## 进程如何工作

当系统启动的时候 内核初始化一些自身的活动作为进程集合 并加载一个称之为 init的程序
init依次运行一些shell脚本（位于 /etc）称之为init scripts 初始化脚本 他们用来启动所有的系统服务
这些服务中的很多都被实现为daemon programs 他们只呆在幕后做其该做的 他们没有用户接口

因此即便我们没有登录 系统也忙着执行一些例程任务。

程序可以加载运行其他程序的事实在进程模式中被描述为 `parent process`产生了一个`child process`

内核维护了每个进程信息 以便于组织他们 。 比如 每个进程被赋予一个进程id PID
进程id是递增被赋予的 init总是获取进程id 1 
内核也维护追踪了被赋予每个进程的内存信息 恢复执行的意愿(processes' to resume execution)
同 文件一样  进程也有owners 和 user Ids 实际user id 等等.

### 查看进程
最常用的就是 ps
ps程序有很多选项 最简形式是：
>  ps

TTY is short for “teletype”
and refers to the controlling terminal for the process.

更多的信息
> $ ps x
    PID TTY      STAT   TIME COMMAND
  19848 ?        Ss     0:00 /lib/systemd/systemd --user
  19849 ?        S      0:00 (sd-pam)
  19899 ?        S      0:00 sshd: yiqing@pts/8
  19901 pts/8    Ss     0:00 -bash
  19945 pts/8    S      0:00 bash
  19957 pts/8    S      0:00 -su
  20038 pts/8    S      0:00 -su
  20245 pts/8    T      0:00 top
  20356 pts/8    R+     0:00 ps x
  
可以不用 -  前缀 

告诉ps 显示我们所有的进程 不论他们是否又被终端控制  tty列的？问号就表示没有控制终端
使用此选项我们看到了我们拥有的每个进程列表。

因为系统运行了很多进程， ps 会产生一个很长的列表
从ps导向结果到less经常对查看是很有帮助的 把终端模拟器的窗口放大也是好主意

STAT 揭示当下进程的状态

Process States

State                       Meaning
R                       Running. This means the process is running or ready to run.
S                       Sleeping. The process is not running; rather, it is waiting for an event, such
                        as a keystroke or network packet.
D                       Uninterruptible sleep. The process is waiting for I/O such as a disk drive.
T                       Stopped. The process has been instructed to stop. You’ll learn more about
                        this later in the chapter.
Z                       A defunct or “zombie” process. This is a child process that has terminated
                        but has not been cleaned up by its parent.
<                       A high-priority process. It’s possible to grant more importance to a process,
                        giving it more time on the CPU. This property of a process is called niceness.
                        A process with high priority is said to be less nice because it’s taking more
                        of the CPU’s time, which leaves less for everybody else.
N                       A low-priority process. A process with low priority (a nice process) will get
                        processor time only after other processes with higher priority have been
                        serviced. 
                        
进程状态也可能跟其他字符 表示不同的进程特性 查看ps的man手册页获取更多信息

另一个经常流行的选项集是 aux(没有-哦) 这会显示更多信息    

BSD Style ps Column Headers

Header                  Meaning
USER                    User ID. This is the owner of the process.
%CPU                    CPU usage in percent.
%MEM                    Memory usage in percent.
VSZ                     Virtual memory size.
RSS                     Resident set size. This is the amount of physical memory (RAM) the process
                         is using in kilobytes.
START                   Time when the process started. For values over 24 hours, a date is used.      

> yiqing@yiqing-VirtualBox:~$ ps aux
  USER       PID %CPU %MEM    VSZ   RSS TTY      STAT START   TIME COMMAND
  root         1  0.0  0.5  37748  5764 ?        Ss   09:41   0:11 /lib/systemd/systemd --system --des
  root         2  0.0  0.0      0     0 ?        S    09:41   0:00 [kthreadd]
  root         4  0.0  0.0      0     0 ?        I<   09:41   0:00 [kworker/0:0H]
  ...
  
> root     19838  0.0  0.6  94928  6664 ?        Ss   11:24   0:00 sshd: yiqing [priv]
  yiqing   19848  0.0  0.4  45280  4592 ?        Ss   11:24   0:00 /lib/systemd/systemd --user
  yiqing   19849  0.0  0.1  63292  1884 ?        S    11:24   0:00 (sd-pam)
  yiqing   19899  0.0  0.4  94928  4212 ?        S    11:24   0:01 sshd: yiqing@pts/8
  yiqing   19901  0.0  0.5  24544  5724 pts/8    Ss   11:24   0:00 -bash
  root     19930  0.0  0.3  56112  3872 pts/8    S    11:29   0:00 su -
  root     19931  0.0  0.5  24540  5568 pts/8    S    11:29   0:00 -su
  root     19944  0.0  0.3  56112  3708 pts/8    S    11:29   0:00 su yiqing
  yiqing   19945  0.0  0.5  24548  5416 pts/8    S    11:29   0:00 bash
  root     19956  0.0  0.3  56112  3812 pts/8    S    11:31   0:00 su -l yiqing
  yiqing   19957  0.0  0.5  24540  5564 pts/8    S    11:31   0:00 -su
  root     19978  0.0  0.3  56112  3848 pts/8    S    11:38   0:00 su -
  root     19979  0.0  0.5  24540  5624 pts/8    S    11:38   0:00 -su
  root     20037  0.0  0.3  56112  3768 pts/8    S    11:39   0:00 su -l yiqing
  yiqing   20038  0.0  0.5  24632  5952 pts/8    S    11:39   0:00 -su
  root     20129  0.0  0.0      0     0 ?        I    12:15   0:00 [kworker/u2:0]
  yiqing   20245  0.0  0.3  43536  4004 pts/8    T    12:45   0:00 top
  root     20306  0.0  0.0      0     0 ?        I    13:29   0:00 [kworker/u2:2]
  root     20359  0.0  0.0      0     0 ?        I    13:45   0:00 [kworker/u2:3]
  root     20397  0.0  0.0      0     0 ?        I    13:55   0:00 [kworker/u2:1]
  yiqing   20403  0.0  0.3  39100  3544 pts/8    R+   13:58   0:00 ps aux        
  
### Viewing Processes Dynamically with top

默认 每3秒一更

类比 win下的 任务管理器 但比其更快 消耗资源更少        

## 控制进程

Ctrl + c   并不是所有程序都支持哟！

### Putting a process  in the background

> [me@linuxbox ~]$ xlogo &
  [1] 28236
  [me@linuxbox ~]$
  
输入命令之后 xlogo窗口消失了 shell提示返回 但输出了很怪的一个数字 此消息是shell特性的一部分称为 job control 
在此消息提示下 shell告诉我们 我们已经启动了一个job 任务号1 其拥有一个进程号28236 如果运行ps  我们就可以看到此进程

shell下的job工具 也可以帮助我们看到此信息
> yiqing@yiqing-VirtualBox:~$ jobs
  [1]+  Stopped                 top
  [2]-  Running                 xlogo &

### Returning a Process to the Foreground
返回进程到前台

使用fg命令
> fg %2
  xlogo
  
%百分比 +  任务号 称之为 jobspec  如果只有一个job 那么此时可选的 然后可以ctrl+c 来终结xlogo  

### Stopping (Pausing) a Process
有时我们只想停止进程而不是终结它 这经常通过允许前台进程移到后台进程来完成
停止前台进程并将其移到后台，按 ctrl+Z 

可以在前台继续进程的执行 使用 fg命令 或者在后台使用bg命令恢复进程的执行
> yiqing@yiqing-VirtualBox:~$ xlogo
  ^Z
  [2]+  Stopped                 xlogo
  yiqing@yiqing-VirtualBox:~$ jobs
  [1]-  Stopped                 top
  [2]+  Stopped                 xlogo
  yiqing@yiqing-VirtualBox:~$ bg %2
  [2]+ xlogo &
  yiqing@yiqing-VirtualBox:~$ jobs
  [1]+  Stopped                 top
  [2]-  Running                 xlogo &
  yiqing@yiqing-VirtualBox:~$ 
  
看到 先xlogo运行程序  ctrl+z 停止并转后台  jobs命令查看已有的后台进程  bg %2 继续运行停止的xlogo  再次用jobs查看状态
xlogo变为 Running  
  
下面是停止后台程序的例子  后台进程转到前台 ctrl+c 停止之   
> yiqing@yiqing-VirtualBox:~$ jobs
  [2]+  Running                 xlogo &
  yiqing@yiqing-VirtualBox:~$ bg %2
  bash: bg: job 2 already in background
  yiqing@yiqing-VirtualBox:~$ fg %2
  xlogo
  ^C
  
同fg命令  只有一个进程时 jobspec是可选的

如果我们从命令行加载了一个图形化程序但忘记了把它弄成后台进程 （尾部带 &） 把一个进程从前台移到后台是很方便的 
为什么我们要从命令行加载图形程序 两个原因：
- 你想运行的程序并没有列举在window管理器的菜单中（比如 xlogo）。
- 通过从命令行开启一个程序 我们可以看到错误消息 如果程序图形化启动就不可见了  有时 一个程序从图形化菜单启动会失败的
通过从命令行启动 我们可以看到错误消息 这些消息会揭示问题所在 。 一些图形程序也有一些有趣和有用的命令行选项。

## Signals 
kill 命令用来 kill进程的 
> yiqing@yiqing-VirtualBox:~$ xlogo &
  [1] 22866
  yiqing@yiqing-VirtualBox:~$ kill 22866

除了进程号 也可以用jobspec（比如 %1）来替代PID

kill命令不是直接杀死进程 而是发送signals给进程 信号是操作系统和程序通讯几种方式中的一种 我们已经看到过
Ctrl+c 和 Ctrl+Z  当终端接受到这些键盘输入时 它发送信号给在前台的程序
在 Ctrl+c 情况 一个信号INT（interrupt）被发送  
Ctrl +z TSTP（terminal stop）信号被发送
程序 监听这些信号 并且可能在收到信号时做出相应的反应 实际上一个程序可能监听并在信号上做出反应允许一个程序做一些事情比如
当被发送一个终止信号时保存正在进行的工作

### 用kill 发送信号给进程
最常用语法形式：
> kill -signal PID ...

如果未指定信号 TERM信号会被默认发送 

Common Signals

Number                  Name                    Meaning
1                   HUP Hang up.                This is a vestige of the good old days when terminals
                                                were attached to remote computers with phone lines and
                                                modems. The signal is used to indicate to programs that the
                                                controlling terminal has “hung up.” The effect of this signal
                                                can be demonstrated by closing a terminal session. The foreground
                                                program running on the terminal will be sent the signal
                                                and will terminate.
                                                This signal is also used by many daemon programs to cause
                                                a reinitialization. This means that when a daemon is sent
                                                this signal, it will restart and reread its configuration file. The
                                                Apache web server is an example of a daemon that uses the
                                                HUP signal in this way.
2                       INT                     Interrupt. This performs the same function as ctrl-C sent from
                                                the terminal. It will usually terminate a program.
9                        KILL                   Kill. This signal is special. Whereas programs may choose
                                                to handle signals sent to them in different ways, including
                                                ignoring them all together, the KILL signal is never actually
                                                sent to the target program. Rather, the kernel immediately
                                                terminates the process. When a process is terminated in this
                                                manner, it is given no opportunity to “clean up” after itself or
                                                save its work. For this reason, the KILL signal should be used
                                                only as a last resort when other termination signals fail.
15                      TERM                    Terminate. This is the default signal sent by the kill command.
                                                If a program is still “alive” enough to receive signals, it will
                                                terminate.
18                      CONT                    Continue. This will restore a process after a STOP or TSTP signal.
                                                This signal is sent by the bg and fg commands.
19                      STOP                    Stop. This signal causes a process to pause without terminating.
                                                Like the KILL signal, it is not sent to the target process,
                                                and thus it cannot be ignored.
20                      TSTP                    Terminal stop. This is the signal sent by the terminal when
                                                ctrl-Z is pressed. Unlike the STOP signal, the TSTP signal is
                                                received by the program, but the program may choose to
                                                ignore it.

> yiqing@yiqing-VirtualBox:~$ kill -1 %3
  yiqing@yiqing-VirtualBox:~$ jobs
  [3]+  Hangup                  xlogo

后台运行xlogo  kill发送INT信号   jobs查看状态  
> yiqing@yiqing-VirtualBox:~$ xlogo &
  [1] 23110
  yiqing@yiqing-VirtualBox:~$ kill -INT 23110
  yiqing@yiqing-VirtualBox:~$ jobs
  [1]+  Interrupt               xlogo
  
> yiqing@yiqing-VirtualBox:~$ xlogo &
  [1] 23117
  yiqing@yiqing-VirtualBox:~$ jobs
  [1]+  Running                 xlogo &
  yiqing@yiqing-VirtualBox:~$ kill -SIGINT 23117
  yiqing@yiqing-VirtualBox:~$ jobs
  [1]+  Interrupt               xlogo

信号可以通过名称 或者数字指定 都行  名称前还可以冠以SIG前缀  

除了进程号 还可以用jobspec

进程 像文件 有拥有者 你必须是进程的拥有者（或者superuser）才能通过kill发送信号
下面是系统进程使用的信号

Other Common Signals

Number                  Name                    Meaning
3                       QUIT                    Quit.
11                      SEGV                    Segmentation violation. This signal is sent if a program makes
                                                illegal use of memory; that is, if it tried to write somewhere it
                                                was not allowed to write.
28                      WINCH                   Window change. This is the signal sent by the system when
                                                a window changes size. Some programs, such as top and
                                                less, will respond to this signal by redrawing themselves to fit
                                                the new window dimensions.  
                                                
如果的话好奇 使用 kill -l  显示所有可用的信号    
> yiqing@yiqing-VirtualBox:~$ kill -l
   1) SIGHUP	 2) SIGINT	 3) SIGQUIT	 4) SIGILL	 5) SIGTRAP
   6) SIGABRT	 7) SIGBUS	 8) SIGFPE	 9) SIGKILL	10) SIGUSR1
  11) SIGSEGV	12) SIGUSR2	13) SIGPIPE	14) SIGALRM	15) SIGTERM
  16) SIGSTKFLT	17) SIGCHLD	18) SIGCONT	19) SIGSTOP	20) SIGTSTP
  21) SIGTTIN	22) SIGTTOU	23) SIGURG	24) SIGXCPU	25) SIGXFSZ
  26) SIGVTALRM	27) SIGPROF	28) SIGWINCH	29) SIGIO	30) SIGPWR
  31) SIGSYS	34) SIGRTMIN	35) SIGRTMIN+1	36) SIGRTMIN+2	37) SIGRTMIN+3
  38) SIGRTMIN+4	39) SIGRTMIN+5	40) SIGRTMIN+6	41) SIGRTMIN+7	42) SIGRTMIN+8
  43) SIGRTMIN+9	44) SIGRTMIN+10	45) SIGRTMIN+11	46) SIGRTMIN+12	47) SIGRTMIN+13
  48) SIGRTMIN+14	49) SIGRTMIN+15	50) SIGRTMAX-14	51) SIGRTMAX-13	52) SIGRTMAX-12
  53) SIGRTMAX-11	54) SIGRTMAX-10	55) SIGRTMAX-9	56) SIGRTMAX-8	57) SIGRTMAX-7
  58) SIGRTMAX-6	59) SIGRTMAX-5	60) SIGRTMAX-4	61) SIGRTMAX-3	62) SIGRTMAX-2
  63) SIGRTMAX-1	64) SIGRTMAX	
  
### 使用killall 发送信号给多个进程

也可能通过killall 命令 发送信号给多个匹配特定用户名 或者名称的进程 语法：
> killall [-u user] [-signal] name...

为了演示 我们开启多个 xlogo实例 之后终结他们   
> yiqing@yiqing-VirtualBox:~$ xlogo &
  [2] 23169
  yiqing@yiqing-VirtualBox:~$ xlogo &
  [3] 23171
  yiqing@yiqing-VirtualBox:~$ jobs
  [1]+  Stopped                 xlogo
  [2]   Running                 xlogo &
  [3]-  Running                 xlogo &
  yiqing@yiqing-VirtualBox:~$ killall xlogo
  [2]   Terminated              xlogo
  [3]-  Terminated              xlogo
  
  记着 使用kill 你必须拥有superuser权限来发送信号给不属于你的进程。
  
  
  ## 关闭系统
  涉及 常规的终结系统上的所有进程，和在系统关闭前执行一些关键的善后工作（比如同步所有的挂载的文件系统）四个命令可执行此
  功能
  
  - halt
  - poweroff
  - reboot
  - shutdown
  
  前三个是自解释的 经常在用时不用任何命令行选项 ：
  > sudo reboot
  
  `shutdown` 命令有点有趣 用它我们可以指定那个动作会被执行（halt ， power down ， 或者 reboot）并提供一个时间延迟给关闭事件
  > sudo shutdown -h now
  
  或者像这样重启系统
  > sudo shutdown -r now
  
  延迟可以通过多种方式指定 可以看看 shutdown man手册详细了解  一旦`shutdown` 命令被执行 一条消息被“广播”给所有已经登录
  的用户 告知他们这个事件
  
  
  ### 更多的进程相关的命令
  
  因为监控进程是一个重要的系统管理任务 有很多命令用于此目的
  
  Other Process-Related Commands
  
  Command                                       Description
  pstree                                        Outputs a process list arranged in a tree-like pattern showing the parentchild
                                        relationships between processes.
  vmstat                                        Outputs a snapshot of system resource usage including memory, swap,
                                        and disk I/O. To see a continuous display, follow the command with
                                        a time delay (in seconds) for updates. Here’s an example: vmstat 5.
                                        Terminate the output with ctrl-C.
  xload                                 A graphical program that draws a graph showing system load over time.
  tload                                 Similar to the xload program but draws the graph in the terminal.
                                        Terminate the output with ctrl-C.
                                            
  
