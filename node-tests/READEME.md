## 利用JS测试

- https://github.com/azat-co/node-testing/tree/master/code
- https://eggjs.org/zh-cn/core/unittest.html
- https://github.com/power-assert-js/power-assert

## 测试

老超时：
>
     Error: Timeout of 2000ms exceeded. For async tests and hooks, ensure "done()" is called; 
     if returning a Promise, ensure it resolves.
     
万能的百度：
找到了这个：https://www.cnblogs.com/tugenhua0707/p/8419534.html
>
    可以看到如上报错 Timeout of 2000ms exceeded， 这是因为mocha默认每个测试用例最多执行2000毫秒，如果超过这个时间没有返回结果，就会报错，
    所以我们在进行异步操作的时候，需要额外指定timeout的时间的。因为异步的操作是需要4000毫秒，所以我们指定5000毫秒就不会报错了。
    如下命令：
    
    mocha --timeout 5000 timeout.test.js
    
     