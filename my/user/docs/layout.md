布局
================

yii的布局使用了**继承**的概念 所有的views 可以继承一个layout 

上面是简单的印象，但实际上继承是可以很多层次的 layout也可以继承多个layout  比如模块的layout 可以继承应用application的布局

复用的另一个手段是组合 widget在这里就体现了这种用法 一个页面 可以由多个widget组成。

其他语言中概念
-------------

###flask 中的jinja模板引擎
《flask by example》
>
    Jinja handles inheritance by using the concept of blocks. Each parent template can
    have named blocks, and a child that extends a parent can fill in these blocks with its
    own custom content. The Jinja inheritance system is quite powerful, and accounts for
    nested blocks and overwriting existing blocks.
    
>
    The Jinja inheritance system is quite powerful, and accounts for
    nested blocks and overwriting existing blocks. However, we're only going to scratch
    the surface of its functionality. We'll have our base template contain all the reusable
    code, and it'll contain one blank block named content and one named navbar. Each
    of our three pages will extend from the base template, providing their own version
    of the content block (for the main page content) and the navigation bar. We'll need to
    make the navigation bar dynamic, because the Login fields of the bar at the top of the
    page will only appear if the user isn't logged in.

html 模板 使用jinja引擎
    
~~~jinja
    
    </head>
    <body>
    {% block navbar %}
    <nav class="navbar navbar-inverse navbar-fixed-top">
    <div class="container">
    <div class="navbar-header">
    <a class="navbar-brand" href="/dashboard">Dashboard</a>
    <a class="navbar-brand" href="/account">Account</a>
    </div>
    </div>
    </nav>
    {% endblock %}
    {% block content %}
    {% endblock %}
~~~

    