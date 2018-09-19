
秋水
美丽说当时是  120gb内存 32core
>
    ps -A --sort -rss -o comm,pmem,pcpu |uniq -c |head -15 查看内存CPU使用量排序
    pmap $(pgrep php-fpm |head -1) 查看进程占用的内存
    netstat -an|awk '/tcp/ {print $6}'|sort|uniq -c 查看TCP网络状态集合
    time ss -o state established | wc -l 统计服务器并发连接数
    当时准备的命令，，为了大促，，小公司没有监控服务，，
    
fpm 一般开启20 - 500  单个进程占用空间在20m左右    