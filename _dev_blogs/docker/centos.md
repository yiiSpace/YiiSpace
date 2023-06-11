docker run -it -d --privileged --name centos_k3s -p 2222:22 centos

docker exec -it centos_k3s /bin/bash

yum update -y

yum install net-tools -y

yum install openssh-server  -y

yum install vim -y

ssh -p 2222 root@localhost
-----------------------------------
使用docker安装完整版的CentOS系统
https://blog.51cto.com/u_15127555/3641940



## 运行在root模式 并自己给一个名字
上面的工具装完后 自己commit 一个本地镜像

然后在特权模式运行

>  docker run -it --privileged --name=mycentos_all   centos_common_tools_0.1 bash  

systemctl 不能运行 可以这样：

docker run -itd --privileged --name=mycentos_all   centos_common_tools_0.1 /usr/sbin/init 

看有关资料 是需要指定

ENTRYPOINT ["/sbin/init"]

这个好像是在k8s 环境指定的 docker独立使用 最后那个就是吧？
参考： 
- https://www.jianshu.com/p/35536a151f93
- https://blog.csdn.net/qq_31856061/article/details/123185140

重点是这一句 /usr/sbin/init就是给容器一个超级管理员的权限，登入终端是由init负责的。

然后再进入容器:
> docker exec -it my_centos_all /bin/bash