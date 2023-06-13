
## Working with PHP 8 autoloading

The main difference is that the support for the global function __autoload(), deprecated in PHP 7.2, has been completely removed in PHP 8
Starting with PHP 7.2, developers were encouraged to register their autoloading logic using spl_autoload_ register(), available for that purpose since PHP 5.1. Another major difference is how spl_autoload_register() reacts if unable to register an autoloader.

- __autoload() 是函数式的 非oop风格 在单元测试时会出问题
- 如果应用程序使用了名空间 __autoload 函数必须定义在全局空间

- 跟 spl_autoload_register() 会冲突 同时出现时 __autoload 会被忽略

Composer 有自己的autoloader 也是依赖spl_autoload_rigester
If you are using Composer to manage your open source PHP packages, you can simply include /path/to/project/ vendor/autoload.php at the start of your application code to use the Composer autoloader. 

让composer自动加载我们的应用源码  https:// getcomposer.org/doc/04-schema.md#psr-4.

## callable

• A PHP procedural function
• An anonymous function
• A class method that can be called in a static manner
• Any class instance that defines the __invoke() magic method
• An array in this form: [$instance, 'method']


## magic methods

PHP magic methods are predefined hooks that interrupt the normal flow of an OOP application. Each magic method, if defined, alters the behavior of the application from the minute the object instance is created, up until the point where the instance goes out of scope.

An object instance goes out of scope when it's unset or overwritten.

### class constructor

和类同名的方法被视为构造方法 且忽略大小写！php7之前？

called automatically when the object instance is created and is used to perform some sort of object initialization.

This initialization most typically involves populating object properties with values supplied as arguments to this method. The initialization could also perform any necessary tasks such as opening file handles, establishing a database connection, and so forth.

**best practice ** is to simply rename the method having the same name as the class to __construct()

在构造方法中异常退出
抛Exception  exit() 或 die() ，析构方法可能不会被调用！