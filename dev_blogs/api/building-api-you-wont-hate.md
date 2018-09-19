api 开发
============

- DBSeeder  数据库填充

为每一个表编写Seeder  然后遍历执行他们  来填充数据库


- 端点计划 EndPoint plan

>
    A complete API action plan might look like this:
    Categories
    - Create
    - List
    Checkins
    - Create
    - Read
    - Update
    - Delete
    - List
    - Image
    
    Places
    - Create
    - Read
    - Update
    - Delete
    - List (lat, lon, distance or box)
    - Image
    Users
    - Create
    - Read
    - Update
    - Delete
    - List (active, suspended)
    - Image
    - Favorites
    - Checkins
    - Followers
    
方法

| Endpoint  |   route  |  http-method | controller::action |
| --        | --       | --           |--                  | 
| /users  |   Route::post('user','UsersController@create'')  |  GET | UserController::actionCreate |

列举出应用的所有 route  和对应的控制器方法

对于对应的控制器方法 ，先让其返回空的 *return " oh hai!""*  然后用 浏览器等测试 检查其输出

## 输入输出

如同ajax请求

请求

~~~http
    
    GET /places?lat=40.759211&lon=-73.984638 HTTP/1.1
    Host: api.example.com
    
    POST /moments/1/gift HTTP/1.1
    Host: api.example.com
    Authorization: Bearer vr5HmMkzlxKE70W1y4MibiJUusZwZC25NOVBEx3BD1
    Content-Type: application/json
    
    { "user_id" : 2 }
~~~

响应

~~~http

    1 HTTP/1.1 200 OK
    2 Server: nginx
    3 Content-Type: application/json
    4 Connection: close
    5 X-Powered-By: PHP/5.5.5-1+debphp.org~quantal+2
    6 Cache-Control: no-cache, private
    7 Date: Fri, 22 Nov 2013 16:37:57 GMT
    8 Transfer-Encoding: Identity
    9
    10 {
    11 "id":"1690",
    12 "is_gift":true,
    13 "user":{
    14 "id":1,
    15 "name":"Theron Weissnat",
    16 "bio":"Occaecati excepturi magni odio distinctio dolores.",
    17 "gender":"female",
    18 "picture_url":"https:\/\/cdn.example.com/foo.png",
    19 "timezone":-1,
    20 "birthday":"1989-09-17 16:27:36",
    21 "status":"available",
    22 "created_at":"2013-11-22 16:37:57",
    23 "redeem_by":"2013-12-22 16:37:57"
    24 }
    25 }

~~~

# 状态码 错误和消息
出错时：
1. http 状态码
2. 自定义错误码和消息

## http 状态码
200-507
被归为不同的类别

* 2xx  都是关于成功的  注意*202 accepted* 只是指示出请求被接受并异步处理.
* 3xx  都是关于重定向的  303  和 301 是最常用的
* 4xx  都是关于客户端错误的 
* 5xx  都是关于服务端错误的 (db失连 )

用于Capture 的api 例子
>
    • 200 - Generic everything is OK
    • 201 - Created something OK
    • 202 - Accepted but is being processed async (for a video means
    encoding, for an image means resizing, etc.)
    • 400 - Bad Request (should really be for invalid syntax, but some folks
    use for validation)
    • 401 - Unauthorized (no current user and there should be)
    • 403 - The current user is forbidden from accessing this data
    • 404 - That URL is not a valid route, or the item resource does not exist
    • 405 - Method Not Allowed (your framework will probably do this for
    you)
    • 410 - Data has been deleted, deactivated, suspended, etc.
    • 500 - Something unexpected happened, and it is the APIs fault
    • 503 - API is not here right now, please try again later
    
## 错误码和错误消息
    
错误码经常是字符串或者数字 扮演索引角色 指向一个对应的人可读的 带有更多发生了什么的 错误消息  ，听起来很像http状态码，
但这些错误是关于应用规范的 跟http规范的响应无关

有些人可能会仅仅使用Http状态码而跳过使用状态码，因为他们不喜欢创造他们自己的错误或者不得不文档化他们，胆这不是一个可扩展的方法。
有时候同一个端点endpoint对不同的条件返回同一个状态码 状态码不会提示更多的错误类别

参考
- [foursquare](https://developer.foursquare.com/overview/responses)
- [twitter](https://dev.twitter.com/docs/error-codes-responses)

### 程序探测错误码

~~~python
    
    1 try:
    2 api.PostUpdates(body['text'])
    3
    4 except twitter.TwitterError, exc:
    5
    6 skip_codes = [
    7 # Page does not exist
    8 34,
    
    # You cannot send messages to users who are not following you
    11 150,
    12
    13 # Sent too many
    14 # TODO Make this requeue with a dekal somehow
    15 151
    16 ]
    17
    18 error_code = exc.__getitem__(0)[0]['code']
    19
    20 # If the error code is one of those listed before, let’s just end here
    21 if error_code in skip_codes:
    22 message.reject()
    23
    24 else:
    25 # Rate limit exceeded? Might be worth taking a nap before we requeue
    26 if error_code == 88:
    27 time.sleep(10)
    28
    29 message.requeue()
~~~

>
    Using Python to analyse Facebook error strings as no codes exist
    1 except facebook.GraphAPIError, e:
    2
    3 phrases = ['expired', 'session has been invalidated']
    4
    5 for phrase in phrases:
    6
    7 # If the token has expired then lets knock it out so we don't try again
    8 if e.message.find(phrase) > 0:
    9 log.info("Deactivating Token %s", user['token_id'])
    10 self._deactivate_token(user['token_id'])
    11
    12 log.error("-- Unknown Facebook Error", exec_info=True)
    
>
    If Facebook added codes and documentation links to GraphAPI error responses.
    1 {
    2 "error": {
    3 "type": "OAuthException",
    4 "code": "ERR-01234",
    5 "message": "Session has expired at unix time 1385243766. The current unix time is\
    6 1385848532."
    7 "href": "http://example.com/docs/errors/#ERR-01234"
    8 }
    9 }
    
多个错误还是单个错误？

>
    If Facebook returned multiple errors in a list for GraphAPI responses.
    1 {
    2 "errors": [{
    3 "type": "OAuthException",
    4 "code": "ERR-01234",
    5 "message": "Session has expired at unix time 1385243766. The current unix time is\
    6 1385848532."
    7 "href": "http://example.com/docs/errors/#ERR-01234"
    8  }]
    9 }
    
错误规范
- JSON-API 
>
   An error object MAY have the following members:
   • "id" - A unique identifier for this particular occurrence of
   the problem.
   • "href" - A URI that MAY yield further details about this
   particular occurrence of the problem.
   • "status" - The HTTP status code applicable to this problem,
   expressed as a string value.
   • "code" - An application-specific error code, expressed as a
   string value.
   • "title" - A short, human-readable summary of the problem.
   It SHOULD NOT change from occurrence to occurrence
   of the problem, except for purposes of localization.
   • "detail" - A human-readable explanation specific to this
   occurrence of the problem.
   • "links" - Associated resources, which can be dereferenced
   from the request document.
   • "path" - The relative path to the relevant attribute within
   the associated resource(s). Only appropriate for problems
   that apply to a single resource or type of resource.
   Additional members MAY be specified within error objects.
   
[json-api-errors](http://jsonapi.org/format/#errors)   

Facebook 已经比较靠近这个标准了 
>
    1 {
    2 "errors": [{
    3 "code": "ERR-01234",
    4 "title": "OAuth Exception",
    5 "details": "Session has expired at unix time 1385243766. The current unix time is\
    6 1385848532.",
    7 "href": "http://example.com/docs/errors/#ERR-01234"
    8 }]
    9 }
    
- Problem Details for HTTP APIs
草案中
实现 [crell/api-problem](https://github.com/Crell/ApiProblem)

- Common Pitfalls 
常见陷阱

# 端点测试

BEHAT
