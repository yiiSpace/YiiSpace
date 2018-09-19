[learning ionic]
========================

>
    The Ionic plugin API
    There are four main commands that you will be using while dealing with plugins.
    Add a plugin
    This CLI command is used to add a new plugin to the project, for example:
    ionic plugin add org.apache.cordova.camera
    Also, you can use this:
    ionic plugin add cordova-plugin-camera
    Remove a plugin
    This CLI command is used to remove a plugin from the project, for example:
    ionic plugin rm org.apache.cordova.camera
    Also, you can use this:
    ionic plugin rm cordova-plugin-camera
    List added plugins
    This CLI command is used to list all the plugins in the project, for example:
    ionic plugin ls
    Search plugins
    This CLI command is used to search plugins from the command line, for example:
    ionic plugin search scanner barcode

设计插件系统 那么插件系统一般有个管理器  比如 plugin-man(ager) 其应该完成的api接口有：
-   add                            接受多种形式的参数 例子：ionic plugin add https://github.com/EddyVerbruggen/Toast-PhoneGap-
                                               Plugin.git
                                               
-   rm             remove
-   ls             list
-   search         