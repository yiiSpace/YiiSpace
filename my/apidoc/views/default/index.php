<div class="apidoc-default-index ">
    <h1>api 概览</h1>


    <p>

    <h2>
        说明： api调用遵从以下通用格式
    </h2>

    网站api入口URL：<?= \yii\helpers\Url::to(['/api/v1'], true) ?>
    <p>
        方法调用形式：

        <?= \yii\helpers\Url::to(['/api/v1',
            'method' => 'user.login',
            'params' => [
                'p1' => 'value1',
                'p2' => 'value2',
            ]], true) ?>

    </p>
    <ul>
        <li>
            <h4>method 参数</h4>
            代表调用的api名称，如 user.login


        </li>
        <li>
            <h4>params 参数</h4>
            代表所调用api方法需要传递的参数。可以是表单编码 或者json编码
            <ul>
                <li>
                    1. 表单/url编码 params['p1']=value1&params['p2']=value2
                </li>
                <li>
                    2. json编码 params='{"p1":"value1","p2":"value2"}'
                </li>
            </ul>


        </li>
    </ul>

    </p>

    <div>
        <p>

        <h3>
            方法调用为rpc风格
        </h3>
        主调用形式确定后，只需要关心某个具体api的签名
        如： user.login(username,password) : {status:true, data{ token:"xxxxxxxxxxxxx" } } | {status:false , error: {
        msg:"some error msg here !"} }

        每个方法调用都分成功 ，失败两种状态
        成功时返回正常的方法结果，失败情况下 会返回错误对象，包括错误码 错误原因等信息
        </p>
    </div>

    <div>
        <p>

        <h2>HTTP API响应数据规范</h2></p>
        <p>

        <h3>所有的操作都可以归类到 命令（Command）或者 请求（Query） 两类操作去</h3>
        <ul>
            <li>
                命令类操作如：CUD （Create,Update,Delete） 性质的操作
                常见的如增删改 都归结为命令类操作，他们是能对服务器数据产生某种状态变更的操作，在restful架构中对应的http
                方法如：POST ，PUT ， DELETE ，PATCH 。

                在某些简化情形下 可以简单的全部使用http POST来递交数据。
            </li>
            <li>
                请求类操作如：View , topN , query filter pagination
                restful架构中对应的http方法是GET，这些方法基本都是幂等的（一定时间内，多次调用跟一次调用返回的数据是一样的，
                对服务器数据的状态影响是相同的）

                请求类操作常见的如：
                1. 单项数据的查询（view请求）。
                2. topN请求，例如 最热商品，最近加入的会员，最新评论 ...
                3. 分页式请求， 需要对数据进行排序，过滤，查询
            </li>
        </ul>
        </p>

        <div>
            <!--            TODO 也可以考虑参考jsonRpc的响应规范 都用result表示
            TODO 至于数据返回字段可以允许客户端指定  比如resultParam = data|result|item|datum
            TODO 更深远的允许每个注册的app自己配置响应格式的字段名称           -->

            <h3>下面分别对上面的各种操的数据格式进行示例说明 (均是成功时的响应，失败的请求后面给出)</h3>

            <p>
                CUD 操作

                Create 性质的操作返回的响应数据格式如：
                <code class="json">
                    {
                    status : 1 ,
                    item : {
                    id : 123456
                    }
                    }
                    // 或者如
                    {
                    status : 1 ,
                    data : {
                    id : 123456
                    }
                    }
                </code>
                由于是新增操作，所以一般需要返回新插入的数据在存储系统中的id。

                Update 性质的操作返回的响应数据格式：

                <code>

                    {
                    status : 1 ,
                    data : true
                    }
                </code>
                更新操作需要指示出操作是否成功。

            <p>
                在新增跟更新操作中会存在数据合法性校验的情况 ，所以服务端可能会返回错误验证相关的信息。

                调用方需要根据不同的错误码进行处理。
            </p>

            Delete 性质的操作返回的响应数据格式：

            <code>
                {
                status : 1 ,
                data : true
                }
            </code>


            CUD 操作可能涉及到数据合法性，权限等约束，当出现操作失败（status:0） 时需要调用方根据不同的响应码来处理不同
            的情况。


            CUD操作还可以共享同一种格式(View 也可以) 此种风格不推荐使用：
            <code>
                {
                "status": 1,
                "data": {
                "id": 32,
                "name": "efg",
                "age": 20,
                "createdAt": "2014-09-05 02:40:44",
                "updatedAt": "2014-09-05 02:40:44"
                }
                }
            </code>
            在以上操作中都采用同一种响应格式也可以说通：
            Create ： 返回新创建的记录数据（包括id）；
            Update ： 返回修改成功后的记录数据；
            Delete ： 返回删除成功后的原始记录数据；
            View ： 返回指定id的记录数据；

            <!--
                     TODO   比较特殊的批量操作：
                     TODO   如DeleteAll : ids=[1,2,3,4]
                     TODO   此类操作涉及到三种情况：        全部成功，部分成功，全部失败！情况比较复杂 此处不考虑
                     -->


            </p>

            <p>
                Query性质的响应格式：

            <ul>
                <li>
                    view (单项数据请求) :
                    <code>
                        {
                        "status": 1,
                        "data": {
                        "id": 30,
                        "name": "yiqing",
                        "age": 78,
                        "createdAt": "2014-09-05 01:53:31",
                        "updatedAt": "2014-09-05 01:53:51"
                        }
                        }
                    </code>
                </li>

                <li>
                    TopN （最近N条数据请求）

                    <code>
                        {
                        "status": 1,
                        "data": [
                        {
                        "id": 30,
                        "name": "john",
                        "age": 78,
                        "createdAt": "2014-09-05 01:53:31",
                        "updatedAt": "2014-09-05 01:53:51"
                        },
                        {
                        "id": 29,
                        "name": "ben",
                        "age": 23,
                        "createdAt": "2014-09-05 01:53:28",
                        "updatedAt": "2014-09-05 01:54:00"
                        },
                        ...
                        ],
                        /* "totalItems": 3" // 没必要的字段 根据数组长度可以算出来的 */
                        }
                    </code>
                </li>

                <li>
                    Pagination （带分页数据请求）

                    <code>
                        {
                        "status": 1,
                        "data": [
                        {
                        "id": 30,
                        "name": "john",
                        "age": 78,
                        "createdAt": "2014-09-05 01:53:31",
                        "updatedAt": "2014-09-05 01:53:51"
                        },
                        {
                        "id": 29,
                        "name": "ben",
                        "age": 23,
                        "createdAt": "2014-09-05 01:53:28",
                        "updatedAt": "2014-09-05 01:54:00"
                        },
                        ...
                        ],
                        TotalCount : 100 , /* 记录总数 */
                        PageCount : 10 , /* 总页数 */
                        CurrentPage : 2 , /* 当前第几页 */
                        PerPage : 10 /* 每页的的数据量 pageSize */
                        }
                    </code>
                    分页信息由四个字段给出：TotalCount , PageCount , CurrentPage , PerPage 。

                </li>
            </ul>


            </p>

        </div>

        <div>
            <h3>错误处理</h3>

            所有响应的status 值为0 （ 不为1 ）时表示调用失败
            格式如
            <code>
                {
                status:0,
                error:{
                code:4xx | 5xx,
                msg:"错误消息内容"
                }
                }
            </code>

            错误码code的语义跟http协议中的状态码一致，
            可以参考：<a href="http://www.w3.org/Protocols/rfc2616/rfc2616-sec10.html" target="_blank">http 状态码定义</a>

            下面给出常见的状态码语义
            <ul>
                <li>200 ok - 成功状态，对应，GET,PUT,PATCH,DELETE.</li>

                <li>500 faild - 失败状态</li>

                <li>304 not modified - HTTP缓存有效。</li>

                <li>400 bad request - 请求格式错误。可以标识参数错误或参数缺失</li>
                <li>401 unauthorized - 未授权。</li>
                <li>403 forbidden - 鉴权成功，但是该用户没有权限。</li>
                <li>404 not found - 请求的资源或接口不存在</li>
                <li>405 method not allowed - 该http方法不被允许。</li>
                <li>410 gone - 这个url对应的资源现在不可用。</li>
                <li>415 unsupported media type - 请求类型错误。</li>
                <li>422 unprocessable entity - 校验错误时用。</li>
                <li>429 too many request - 请求过多。</li>
            </ul>

            <p>

            <h3>只有错误发生时状态码才有意义</h3>
            也可以使用多层次错误信息反馈，泛错误跟具体的业务错误码同时返回给用户（不推荐使用，简单就好不要搞那么细，淘宝那种就是自定义错误码的 已具体到业务错误上
            比如 <a href="http://open.taobao.com/apidoc/api.htm?spm=a219a.7386789.1998342952.1.SO7LHp&path=cid:1-apiId:2">taobao.users.get</a>
            【isv.invalid-parameter:nicks ： 参数：nicks无效，可能为格式不对、非法值、越界等情况 ，】他们这种情况的泛错误其实就是验证错误422
            ）

            只对核心的几种错误进行定义即可
            <ul>
                <li>
                    400 请求格式错误 客户端传递的方法名，参数格式 参数类型跟api签名不符；
                </li>
                <li>
                    404 找不到资源 一般是query性质的操作 其实对这种操作可以通过返回null，空对象，空数组解决掉 没必要返回404 ；
                </li>
                <li>
                    422 验证错误 参数的前置条件检测不通过，比如传递的类型虽然对，但不符合业务约束。邮件email字段类型是string的。但传递的参数明显不是邮件地址；
                </li>
                <li>
                    429 请求过多 访问频率限制 ，防止恶意调用。
                </li>
            </ul>
            </p>

        </div>

    </div>
</div>

<?php \year\widgets\HighLightJsAsset::register($this); ?>

<?php \year\widgets\JsBeautifyAsset::register($this) ?>

<?php \year\widgets\JsBlock::begin() ?>
<script>
    $(function () {
        $('.apidoc-default-index  ul').addClass('ui-list ui-list-nosquare');
        $('.apidoc-default-index  li').addClass('ui-list-item');

        $('code').each(function () {
            // console.log(this);
            $(this).text(js_beautify($(this).text()));

        });
        $('code').wrap('<pre></pre>');

        /*
         // 代码高亮
         hljs.configure({useBR: true});
         $('code').each(function (i, block) {
         hljs.highlightBlock(block);
         });
         */
    });
</script>
<?php \year\widgets\JsBlock::end() ?>