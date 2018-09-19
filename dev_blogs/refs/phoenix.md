整个框架简化为管道模型

每个管道段 内部仍旧实现为管道 ！ 此即为层次性 看你站在哪里看了。


整个程序的看起来是这样：
>   connection |>  phoenix

下个层级可以这样看：
>   
    connection
    |> endpoint
    |> router
    |> pipelines         ## 这个概念推测是跟express中的中间件相似 
    |> controller

控制器内部：
>
    connection
    |> controller
    |> common_services      ## yii中的过滤器功能类似（实现为Behavior）
    |> action
    
action:
>
    connection
    |> find_user
    |> view
    |> template
    

## __

>    You’re in a functional language, so you’re going to spend all of your time writing functions. 
你处在函数式语言中，所以你会花费你所有的时间去写函数 。

## __

构建一个Feature
步骤
>
    We’ll edit router.ex to point a URL to our code. We’ll also add a controller to the web/controllers subdirectory,
    a view to web/views, and a template to web/templates.
    ...
    First things first. We want to map requests coming in to a specific URL to the code that satisfies our request.
    We’ll tie a URL to a function on a controller, and that function to a view.First things first. We want to map 
    requests coming in to a specific URL to the code that satisfies our request. 
    We’ll tie a URL to a function on a controller, and that function to a view. You’ll do so in the routing layer, 
    as you would for other web frameworks.

认知
>
    When you think about it, typical web applications are just big functions. Each web request is a function call 
    taking a single formatted string—the URL—as an argument. That function returns a response that’s nothing more 
    than a formatted string. If you look at your application in this way, your goal is to understand how functions are 
    composed to make the one big function call that handles each request. In some web frameworks, that task is easier 
    said than done. Most frameworks have hidden functions that are only exposed to those with deep, intimate internal
    knowledge.
    
    The Phoenix experience is different because it encourages breaking big functions down into smaller ones. Then, it provides a place to explicitly register each smaller function in a way that’s easy to understand and replace. We’ll tie all of these functions together with the Plug library.
    Think of the Plug library as a specification for building applications that connect to the web. Each plug consumes and produces a common data structure called Plug.Conn. Remember, that struct represents the whole universe for a given request, because it has things that web applications need: the inbound request, the protocol, the parsed parameters, and so on.
    Think of each individual plug as a function that takes a conn, does something small, and returns a slightly changed conn. The web server provides the initial data for our request, and then Phoenix calls one plug after another. Each plug can transform the conn in some small way until you eventually send a response back to the user.
    Even responses are just transformations on the connection. When you hear words like request and response, you might be tempted to think that a request is a plug function call, and a response is the return value. That’s not what happens. A response is just one more action on the connection, like this:
    
    conn
    |> ...
    |> render_response
    
    The whole Phoenix framework is made up of organizing functions that do something small to connections, even rendering the result. Said another way…
    Plugs are functions.
    Your web applications are pipelines of plugs.
