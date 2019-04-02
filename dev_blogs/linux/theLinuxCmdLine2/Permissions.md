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