shopnc 代码结构分析
===========

整个项目由若干个app构成


admin 后台管理程序
-----------
-  config 目录 改目录是此应用的配置
-  control 目录 是本应用的控制器所在目录
    
    每个独立的控制器都有一个共同的基类控制器：SystemControl
    基类控制器提供的通用功能如：登录检测，权限检测，可用菜单|导航相关的功能

    控制器包括了所有应用的后台功能。
-   include 目录 作为跟配置相似的功能存在。
    权限功能 跟菜单的配置
    
-   language 目录 该目录是国际化相关文件。包括各个应用的翻译都聚集在这里！
    不同于返回一个数组，此处的做法是为一个全局变量$lang 设置不同的翻译配置：$lang['someNewKey'] = 'someMessage';
    
-   resource 目录  该目录下面是存放全局可访问的静态资源：（js ，css fonts ..）
    这种目录在其他web项目中等价的目录名可能是：public static assets...
    
-   templates 目录 改目录是存放控制器对应的views的地方。目前只有一个default皮肤。
    改目录存放了layouts布局，css 图片images以及各个控制器op（action动作）对应的各种views视图文件。
    css，images 也会出现在这里（跟本皮肤有关系，紧耦合）；
    也就是说跟某套皮肤配套的一般还有css，js images这些资源文件的。设计皮肤时不光要设计views视图，还有与之配套的
    js，css，images文件。
    
    注意 css images 等也存放在此目录，shopnc的各个目录下的文件好像可以从webroot跟目录直接访问过来（直接穿透），
    对于不许访问的文件会在顶部做限制，比如某个视图view的首部：
    > <?php defined('InShopNC') or exit('Access Invalid!');?>
    
    这种代码会出现在文件首部！是防止某些非法的直接从浏览器输入脚本文件名称来访问某个文件。而常量InShopNc 是在上游或者
    入口文件中才会被定义的。也就是下游程序会在本段中检测是否持有上游的访问标识（没牌不让进！），能走到我这儿你肯定经历
    了InShopNc 的常量定义阶段。
     这种问题的抽象：  在流式结构中（pipeline，管道，瀑布） 下游程序如何判断上游的某个流段被执行了？    
     
     
-  index.php 程序入口文件。
    此中定义常量，比如BASE_PATH，ADMIN_TEMPLATES_URL，BASE_TPL_PATH...包含核心文件，定义模板目录，运行程序。
    代码解读
    ~~~
    
        // 定义本应用的基路径
        define('BASE_PATH',str_replace('\\','/',dirname(__FILE__)));
        // 包含项目最外层的公共文件 （该文件主要是定义各种常用的常量 很多哦！）
        if (!@include(dirname(dirname(__FILE__)).'/global.php')) exit('global.php isn\'t exists!');
        if (!@include(BASE_CORE_PATH.'/royal.php')) exit('royal.php isn\'t exists!');
        // 定义模板名称
        define('TPL_NAME',TPL_ADMIN_NAME);
        // 后台模板URL 视图文件寻址时此常量应该做为“基”目录被拼接上
        define('ADMIN_TEMPLATES_URL',ADMIN_SITE_URL.'/templates/'.TPL_NAME);
        define('BASE_TPL_PATH',BASE_PATH.'/templates/'.TPL_NAME);
        
        // 导入基控制器所在的文件
        if (!@include(BASE_PATH.'/control/control.php')) exit('control.php isn\'t exists!');
        
        // 运行程序
        Base::run();
    
    ~~~
    