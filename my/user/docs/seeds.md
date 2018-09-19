使用脚本 来 “喂” 给表一些【假】数据

可以通过写console 控制器来做哦

另外也可以是一些散乱的脚本 

yii-shell 可以 包含某些脚本的

    seeds/
        fake-user.php
        fake-blog.php
        ...
        
        
注意 需要防止误操作 导致一个脚本运行多次哦！
对于写性质的 可以先读 对比后  在写 
        
其实使用Migration 喂数据也不错哦！        