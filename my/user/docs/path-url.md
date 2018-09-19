每个控制器 对应的都有对外暴露的route

在常规的crud 情况下 视图上下文View::context 是“当前”控制器 使用Url::to|toRoute 方法 可以省略当前控制器id 模块id

但在某些聚合性页面（页面内容涉及 多个widget  多个控制器链接） 此时使用Url::to 需要带上控制器id 这种方法意味你隐含知道
这些路由的具体长相。 不如给一个更“表达化”的方法来封装


在 <<Programming phoenix>> 一书中 所有的Controller 都可以用类似 {{controller_id}}_path 的方法来生成URL：
>
    <%= link "Register", to: user_path(@conn, :new) %>
    <%= link "Log in", to: session_path(@conn, :new) %>
    
在phoenix中 是不需要声明这些方法的！（自动被生成？还是...）    

##  我们可以

对模块中的每个控制器 设计对应的Path 帮助类
- 明确列举出所有可用的路由
- 对每个控制器的actionXxx 暴露出显式的方法  而不是通过底层Url::to  来构造链接

phoenix 使用了协议来生成url
>
  Phoenix and Elixir have the perfect solution for this. Phoenix knows to use the id field in a Video struct because
  Phoenix defines a protocol, called Phoenix.Param. By default, this protocol extracts the id of the struct, if one exists.
  ...
  The protocol requires us to implement the to_param function, which receives the video struct itself.
  ...
  The beauty behind Elixir protocols is that we can implement them for any data structure, anywhere, any time.
  Though we place our implementation in the same file as the video definition, it could as easily exist elsewhere.
  We get clean polymorphism because we can extend Phoenix parameters without changing Phoenix or the Video module itself.