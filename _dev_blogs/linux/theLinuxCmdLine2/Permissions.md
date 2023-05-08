早期计算机特别昂贵 都是很多人共享一个的

Unix操作系统早期 就是按照多用户来设计的 用户间需要隔离 资源也需要隔离

本篇是 基本系统安全部件和命令

- id              显示用户ID        Display user identity
- chmod           更改文件模式        Change a file’s mode
- umask           设置默认的文件权限        Set the default file permissions
- su              用另一个用户身份来运行shell        Run a shell as another user
- sudo            作为另一个用户来执行命令        Execute a command as another user
- chown           改变文件的所有者        Change a file’s owner
- chgrp           改变文件组的所有权        Change a file’s group ownership
- passwd          改变用户的密码        Change a user’s password


### 所有者  组员  其他人

> yiqing@yiqing-VirtualBox:~$ file /etc/shadow
  /etc/shadow: regular file, no read permission
  yiqing@yiqing-VirtualBox:~$ less /etc/shadow
  /etc/shadow: Permission denied
  
上面情况是 作为常规用户我们无权限读这个文件  

在Unix安全模型中 一个用户可以拥有(own)文件和目录 ，当用户拥有文件或目录时 其拥有文件或目录的访问控制权
用户可以属于一个组（group） 组由一个或者多个用户组成 文件或者目录的拥有者可以授予组访问权。
此外拥有者 还可以授予一些权限集给everybody 在unix中指：world

使用id命令可以找出你的标识信息：

> yiqing@yiqing-VirtualBox ~> id
  uid=1000(yiqing) gid=1000(yiqing) groups=1000(yiqing),4(adm),24(cdrom),27(sudo),30(dip),46(plugdev),113(lpadmin),128(sambashare),998(docker),999(vboxsf)

当新用户被创建时 赋予一个数字user-id（uid）并被赋以某个组 group ID（gid）

ubuntu uid是从1000开始的  其他系统不同

那么这些用户信息来自哪里呢？同linux其他很多东西一样 它来自一些文本文件
用户账号被定义在 /etc/password文件 
用户组被定义在   /etc/group文件
当用户和组被创建时 这些文件被/etc/shadow修改 其持有用户密码的信息 针对每个用户
/etc/password 定义了用户的 登录名 uid gid 账号的真名 主目录 和登录shell

superuser 的id uid是0！

很多 类unix系统 会将常规用户赋到一个公共组如users   现代的linux实践是创建一个特殊的，单成员的组 其名同用户名
这使得做某类权限赋值更容易些

### 读 写  和执行

对文件和目录的访问权被定义为术语 read access ,write access 和 execution access
> [me@linuxbox ~]$ > foo.txt
  [me@linuxbox ~]$ ls -l foo.txt
  -rw-rw-r-- 1 me me 0 2018-03-06 14:52 foo.txt
  
前10个字符 是文件属性 第一个是文件类型
常见的文件类型：

Attribute File type
-                   A regular file.
d                   A directory.
l                   A symbolic link. Notice that with symbolic links, the remaining file attributes
                    are always rwxrwxrwx and are dummy values. The real file attributes
                    are those of the file the symbolic link points to.
c                   A character special file. This file type refers to a device that handles data
                    as a stream of bytes, such as a terminal or /dev/null.
b                   A block special file. This file type refers to a device that handles data in
                    blocks, such as a hard drive or DVD drive.  


文件属性的剩余九个属性 称为 file mode 表示的是真对于 owner group world(every body)的  读 写 和执行权限

Attribute           Files                                               Directories
r                   Allows a file to be opened and read.        Allows a directory’s contents to
                                                                be listed if the execute attribute is
                                                                also set.
w                   Allows a file to be written to or
                    truncated; however, this attribute
                    does not allow files to be renamed
                    or deleted. The ability to delete or
                    rename files is determined by directory
                    attributes.
                                                                Allows files within a directory to be
                                                                created, deleted, and renamed if
                                                                the execute attribute is also set.
x                   Allows a file to be treated as a
                    program and executed. Program
                    files written in scripting languages
                    must also be set as readable to be
                    executed.                                    
                                                                Allows a directory to be entered,
                                                                e.g., cd directory.
                                                                
                                                                
权限属性的例子：
>   -rwx------                   A regular file that is readable, writable, and executable by the file’s
                                 owner. No one else has any access.
    -rw-------                  A regular file that is readable and writable by the file’s owner. No
                                 one else has any access.
    -rw-r--r--                  A regular file that is readable and writable by the file’s owner.
                                 Members of the file’s owner group may read the file. The file is
                                 world-readable.
    -rwxr-xr-x                  A regular file that is readable, writable, and executable by the file’s
                                     owner. The file may be read and executed by everybody else.
    -rw-rw----                  A regular file that is readable and writable by the file’s owner and
                                members of the file’s group owner only.
    lrwxrwxrwx                          A symbolic link. All symbolic links have “dummy” permissions. The
                                real permissions are kept with the actual file pointed to by the symbolic
                                link.
    drwxrwx---                          A directory. The owner and the members of the owner group may
                                enter the directory and create, rename, and remove files within the
                                directory.
    drwxr-x---                  A directory. The owner may enter the directory and create, rename,
                                and delete files within the directory. Members of the owner group
                                may enter the directory but cannot create, delete, or rename files.
                                
### chmod change file mode 改变文件模式

只有文件的主人或者超级用户 才可以更改文件或者目录的模式
chmod 支持两种模式更改的方式
- 八进制数字表示
- 符号表示

File Modes in Binary and Octal
Octal          Binary               File mode
0               000                 ---
1               001                 --x
2               010                 -w-
3               011                 -wx
4               100                 r--
5               101                 r-x
6               110                 rw-
7               111                 rwx          

chmod 也支持 symbolic 符号  分为三个部分：
- 改变会影响到谁
- 将执行哪个操作
- 将设置什么权限

指定会影响到谁 使用字符 u g o 的组合
> chmod Symbolic Notation
  Symbol                            Meaning
  u                     Short for “user” but means the file or directory owner.
  g                     Group owner.
  o                     Short for “others” but means world.
  a                     Short for “all.” This is a combination of u, g, and o.
                      
如果未指定 那么使用 all
a +  表示权限被添加  a - 表示权限被收回  a = 表示只有特定权限被采用 所有其他的会被移除

权限使用字符 r w 和 x 指定
> chmod Symbolic Notation Examples
  Notation                                  Meaning
  u+x                               Add execute permission for the owner.
  u-x                               Remove execute permission from the owner.
  +x                                Add execute permission for the owner, group, and world. This is
                                    equivalent to a+x.
  o-rw                              Remove the read and write permissions from anyone besides the
                                    owner and group owner.
  go=rw                             Set the group owner and anyone besides the owner to have read and
                                    write permissions. If either the group owner or the world previously
                                    had execute permission, it is removed.
  u+x,go=rx                         Add execute permission for the owner and set the permissions for the
                                    group and others to read and execute. Multiple specifications may be
                                    separated by commas.      
                                    
一些人更愿意使用二进制符号，另一些人更喜欢symbolic 象征性的符号提供了一种允许我们设置单个属性而不干扰其他的优势     

GUI下也可以方便的设置这些  右键单击文件或者目录--》permissions

### umask 设置默认的权限

umask 命令控制赋给文件刚创建时的默认权限 使用八进制符号表示 从文件模式属性中移除的位掩码      
> umask
  0002
  
默认掩码 0002
修改下  然后再创建一个文件 可以看到other的权限变为 可读可写了
>   umask 0000
    > foo.txt
    ls -l foo.txt
  -rw-rw-rw- 1 yiqing yiqing 0 4月  13 15:39 foo.txt       
  
  Original file mode    --- rw- rw- rw-
  Mask                  000 000 000 010
  Result                --- rw- rw- r--
  
  掩码中二进制1出现的地方 就是文件属性被重置的地方
  
### 一些特殊权限

- setuid bit 4000
- setgid bit 2000
- sticky bit 1000  


## 更换用户

动机：  其他用户的权限 superuser  ， 测试一个账号 ...

三种方式
-  登出 作为另一个用户登入回来
- 使用 su 命令
- 使用sudo 命令

第一种 比较易理解   但不及后两者方便


/etc/sudoers
  
  
### su Run a shell with Substitute User and Group IDs

su 命令用来以另一个用户身份启动一个shell 语法如：
>  su [-[l]] [user]   

-l 选项如果被包含 最终的shell会话就是针对特定用户的登陆shell  此意味着用户环境被加载 工作目录被改变到用户的home目录。
这也经常是我们希望的 

如果用户没有指定 那么superuser是默认的。

另外注意一个奇怪的用法 -l可以简写为 - 这也是经常使用的方式
>  su -

也可以执行一个单独的命令 而不是开启一个新的交互命令通过以下方式使用su 
> su -c 'command'           

使用此种方式 单个命令行被传递到新的shell去执行 用单引号括起来是很重要的 因为我们不想在我们自己的shell中被展开(expansion)
 而是在新的shell中展开                                                                 
 
> su -c 'ls -l /root/*'

### sudo: Execute a Command As Another User


### chown: Change File Owner and Group

此命令需要superuser 的特权 语法如：
> chown [owner][:[group]] file ...

chown Argument Examples
Argument                    Results
bob                  Changes the ownership of the file from its current owner to user bob.
bob:users            Changes the ownership of the file from its current owner to user bob
                     and changes the file group owner to group users. 
:admins              Changes the group owner to the group admins. The file owner is
                     unchanged.
bob:                 Changes the file owner from the current owner to user bob and
                     changes the group owner to the login group of user bob.      
                     
### chgrp: Change Group Ownership      
chown 在老版的Unix中 仅用来更改文件的所有者 而不是组的所有者。 因而 一个单独的命令 chgrp 被引入 使用方式很像chown 但
有更多的限制。

### Change Your password

> passwd [user]               

不指定用户时 是修改自己的秘密 

如果是superuser 可以指定用户  可以设置特定用户的密码
> sudo passwd root  
比如在 ubutu中 可以给root 用户设定一个秘密来开启root账户(在ubutu下 默认root账号是被锁定的)    
> yiqing@yiqing-VirtualBox:~/yiqing-space/the_linux_command_line$ sudo passwd root
  [sudo] password for yiqing:
  Enter new UNIX password:
  Retype new UNIX password:
  passwd: password updated successfully