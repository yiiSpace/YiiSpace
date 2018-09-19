全局对象的使用：

>
    we added a signal handler that
    stores the current user as an attribute of the Flask g object. We can access this object
    in the template, so we simply need to check, in the template, whether g.user is
    authenticated or not.
    
    <ul class="nav navbar-nav">
    <li><a href="{{ url_for('homepage') }}">Home</a></li>
    <li><a href="{{ url_for('entries.index') }}">Blog</a></li>
    {% if g.user.is_authenticated %}
    <li><a href="{{ url_for('logout', next=request.path) }}">Log
    out</a></li>
    {% else %}
    <li><a href="{{ url_for('login', next=request.path) }}">Log
    in</a></li>
    {% endif %}
    {% block extra_nav %}{% endblock %}
    </ul>
    
断裂的思维    ， 这种使用全局对象的感觉 就相当于 在一个地方把东西放进去  在另一个地方取出来（类似使用缓存的经验 set/get） 
    而不是编程中 一直把你需要的东西 层层传递过去 给人感觉就是思维跳跃  需要熟悉执行流程 什么地方会先执行 什么地方后执行
    在先执行的地方 放东西 在后执行的地方取东西。