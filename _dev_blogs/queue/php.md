- [php-queue](https://github.com/php-enqueue/enqueue-dev)

- 连接主流java队列[stomp-php](https://github.com/stomp-php/stomp-php/tree/master/src/Stomp/Broker)

-  [amqplib](https://github.com/php-amqplib/php-amqplib)
    对apollo 的配置 需要验证
    可以参考[mqtt-can-not-connect-to-apollo-server](http://stackoverflow.com/questions/27633353/mqtt-can-not-connect-to-apollo-server)：
    >
         Well, it seems that nobody got to help me, I repeatedly see apollo.xml this configuration file, accidentally gave it to solve. Uncomment to disable security for the virtual host，
        
        <!-- Uncomment to disable security for the virtual host -->
        
        <authentication enabled="false"/>
        
        maybe i should read the configuration more carefully.
        
    或者看该库的tests 看看怎么获取 client的  参考测试目录下的 类 ： ClientProvider


## 队列里面存放什么
- {action: some-action-name , data:{ anything:... }}
   react flux 或者vue 中的 store？
   在 yii-queue中 任务的实现：
   
   ~~~php
   
   class DownloadJob extends BaseObject implements \yii\queue\JobInterface
   {
       public $url;
       public $file;
       
       public function execute($queue)
       {
           file_put_contents($this->file, file_get_contents($this->url));
       }
   }
 
   ~~~
   任务类名 等价于 action  类属性就是需要传递的数据。
   {action: dowload , url:'baidu.com/' , file: '' }