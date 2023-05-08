配置

mailer

~~~

       'mailer' => [
                'class' => 'yii\swiftmailer\Mailer',
                'useFileTransport' =>false,// 这句一定有，false发送邮件，true只是生成邮件在runtime文件夹下，不发邮件
                'transport' => [
                    'class' => 'Swift_SmtpTransport',
                    'host' => 'smtp.163.com',  // smtp host
                    'username' => 'yiispace@163.com',
                   //  'password' => '',
                    'password' => 'jdjzalixfjbydxmz', // 客户端授权码  而非登陆密码  网易在【设置 》POP3/SMTP/IMAP】可用手机重置
                    'port' => '25',
                    'encryption' => 'tls',
    
                ],
                'messageConfig'=>[
                    'charset'=>'UTF-8',
                    'from'=>['yiispace@163.com'=>'admin']
                ],
            ],

~~~
出现的错误
>
    Swift_TransportException
    Expected response code 250 but got code "553", with message "553 Mail from must equal authorized user
    "
原因：
    预期的响应代码250，但得到了代号“553”，消息“553邮件必须来源于授权用户
    
只能同域下发送 太悲催了！    