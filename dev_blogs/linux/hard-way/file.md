[Ubuntu Linux TUTORIAL Getting started with the FIND command and its practical uses](https://www.youtube.com/watch?v=3n7GHqPU310)

# 查找

##  find  查找文件

>   find . -type f -name "*.php"

查找 在当前目录下  类型是文件的 名称类似 *.php 的文件

- -type   文件类型   f-文件  d-目录
- -iname  忽略文件名大小写

- -perm   权限    如：       find . -perm 0664

- -isize  按照大小搜索   +100M|-100K(大于100M的 | 小于100k的 )     如  find . -type f -size +100k (大于100k的文件)

- -not    不符合条件的   如： find . -type f -not -iname "*.php" (找非后缀是php的文件)

- -maxdepth  最大深度 （默认是递归的 ）    -maxdepth 1  (只在本级找)

## grep 查找内容
>   grep "function"  some_file.php 

在php文件中找`function`出现的行

- -i  忽略大小写                 如  grep -i "function" some_file.php 
- -n  搜索结果中给出关键字出现的行号

组合： 
>   find . -type f -iname "*.php"  -exec grep -i -n "function" {} + 


## 重定向  
>  ls >  out.txt

将ls 的结果重定向的 out.txt 文件中

~~~shell
    find . -type f -size -10k -iname "*.php" -exec grep -i -n "wandwich" {} +  > some_output.txt
~~~
-exe 执行后面的grep命令 然后把结果重定向到 某文件 去

| tee some_out.out  (也是管道到某个文件)

## 进程
- top  列举当前 最火的进程  实时更新
- ps aux   快照

    ps  aux |  grep "xxx"
    
- pgrep   正则捕获进程号  如：  pgrep liri-browser 
    
- kill    杀死进程        如：  kill -9  1111    杀死进程号是1111 的进程
- killall 杀死所有进程   参数是 一个程序命令  如 killall liri-browser
    
### service 后台运行的进程
>
    service  elasticsearch start   
    service  elasticsearch stop   
    systemctl start elasticsearch 
    systemctl stop elasticsearch 
    
>
    您的位置: Linux系统教程 > Ubuntu系统 >
    ubuntu安装配置elasticSearch
    时间:2016-01-21来源:linux网站 作者:天运子
    
    安装jdk
    
    sudo apt-get install python-software-properties
    sudo add-apt-repository ppa:webupd8team/java
    sudo apt-get update
    sudo apt-get install oracle-java8-installer
    sudo update-alternatives --config java
    
    
    安装elasticSearch
    
    wget -qO - https://packages.elastic.co/GPG-KEY-elasticsearch | sudo apt-key add -
    echo "deb http://packages.elastic.co/elasticsearch/2.x/debian stable main" | sudo tee -a /etc/apt/sources.list.d/elasticsearch-2.x.list
    sudo apt-get update && sudo apt-get install elasticsearch
    
    
    安装Marvel监控工具
    
    /usr/share/elasticsearch/bin/plugin install elasticsearch/marvel/latest
    
    
    禁用监控
    
    echo 'marvel.agent.enabled: false' >> /etc/elasticsearch/elasticsearch.yml
    
    
    运行elasticSearch
    
    sudo mkdir /usr/share/elasticsearch/logs
    sudo mkdir /usr/share/elasticsearch/data
    sudo mkdir /usr/share/elasticsearch/config
    sudo chmod -R 777 /usr/share/elasticsearch/logs
    sudo chmod -R 777 /usr/share/elasticsearch/data
    sudo chmod -R 777 /usr/share/elasticsearch/config
    /usr/share/elasticsearch/bin/elasticsearch
    /usr/share/elasticsearch/bin/elasticsearch -d //守护进程启动
    
    
    测试是否正常
    
    curl 'http://localhost:9200/?pretty'
    
    
## 网络监听  
列举本机有网络监听的程序  
>   netstat  -l -n 


## schedule task  任务调度

crontab 