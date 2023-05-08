##  远程终端
 找个终端 比如 xshell putty `MobaXterm Personal Edition` 之类的远程连接 linux
 因为用的是ssh 所以 服务端需要安装ssh-server 服务 并启动
 
 ~~~
 
 
1. Ubuntu14.04安装SSH

    命令: # sudo apt-get install openssh-server

2. 启动SSH Server

    命令: # sudo /etc/init.d/ssh start

3. 在控制端(安装putty的一侧,Windows或其他Linux OS)安装和配置putty
 ~~~
 参考
 >
     putty 连接ubuntu
    
    1、安装ssh   sudo apt-get install openssh-server
    
    2、查看ssh服务是否启动 sudo ps -e |grep ssh  
    
    3、如果没有启动，输入"sudo service ssh start"-->回车-->ssh服务就会启动 或者 启动SSH Server  sudo /etc/init.d/ssh start
    
    4、使用gedit修改配置文件"/etc/ssh/sshd_config" 
    
    打开"终端窗口"，输入"sudo gedit /etc/ssh/sshd_config"-->回车-->把配置文件中的"PermitRootLogin without-password"加一个"#"号,把它注释掉-->再增加一句"PermitRootLogin yes"
    
    5、输入sudo ifconfig 查看ip
    
    遇到的问题 ，一直putty 连接不上，修改了网络设置，从原来的NAT 模式修改为桥接模式后可以正常连接，网上查找原因：因为两个系统不在同一个局域网，互相之间不能通信。
    
    
## 网络监控
安装 tcpdump 工具 可以抓包
 
 服务端运行 tcpdump  远程客户端 用ssh发送命令 这样可以监听到发的包
 
 
 
 namp 可以扫描指定ip|域名 开放的端口的工具
 
 
 ## 虚拟机与主机共享文件夹
 vmware tools 工具安装（ 正在进行简易安装时 无法手动启动 vmware tools 安装 的解决方法 ）
>
    http://blog.csdn.net/hugewaves/article/details/52203493
    
- 共享后 看不到文件    
>
      如何开启共享：    安装 VMware tools 后即可在  Ubuntu 中的/mnt/hgfs下面看到  
      要是没看到可用以下方法解决：   进入Ubuntu  终端 按两下 tab 键  
      进入 vmware 命令 框 输入     vmware-hgfsclient 命令即可     
      然后在 /mnt/hgfs 下即可看到你共享的文件夹了
      
      还要安装这个：sudo apt-get install open-vm-tools-dkms