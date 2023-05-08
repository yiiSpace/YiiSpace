群里有个哥们 在用ThinkPhp的思维写 页面 问能否使用__PUBLIC__ 这种东西来表示公共目录  

其实在视图渲染结束后 使用字符串替换就可以搞的
~~~
<script src='__PUBLIC__/someCate/xxx.js' type="text/javascript">
~~~

afterRender 