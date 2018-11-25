- JMeter

- 基于node的 artillery

~~~cmd

> npm install -g
> artillery dino

artillery quick --duration 30 --rate 5 -n 1
http://localhost:80/api/v1/secret/

~~~
> The preceding command will do a quick test in a duration of 30 seconds. In this time,
  Artillery will create five virtual users; each one of them will do one GET request to the
  provided URL. As soon as the preceding command is executed, Artillery will start the tests
  and print some stats every 10 seconds.

类似输出：
>
    Started phase 0, duration: 30s @ 14:02:55(+0800) 2018-11-02
    Report @ 14:03:05(+0800) 2018-11-02
      Scenarios launched:  49
      Scenarios completed: 47
      Requests completed:  47
      RPS sent: 5.09
      Request latency:
        min: 219.3
        max: 4024
        median: 681.9
        p95: 3581.6
        p99: 4024
      Codes:
        200: 47
    
    Report @ 14:03:15(+0800) 2018-11-02
      Scenarios launched:  50
      Scenarios completed: 51
      Requests completed:  51
      RPS sent: 5.11
      Request latency:
        min: 218.4
        max: 562.5
        median: 252.4
        p95: 469
        p99: 562.2
      Codes:
        200: 51
    
    Report @ 14:03:25(+0800) 2018-11-02
      Scenarios launched:  50
      Scenarios completed: 50
      Requests completed:  50
      RPS sent: 5.03
      Request latency:
        min: 220.6
        max: 704.5
        median: 271.7
        p95: 481.7
        p99: 704.5
      Codes:
        200: 50
    
    Report @ 14:03:26(+0800) 2018-11-02
      Scenarios launched:  1
      Scenarios completed: 2
      Requests completed:  2
      RPS sent: 2
      Request latency:
        min: 269.8
        max: 286.7
        median: 278.3
        p95: 286.7
        p99: 286.7
      Codes:
        200: 2
    
    All virtual users finished
    Summary report @ 14:03:26(+0800) 2018-11-02
      Scenarios launched:  150
      Scenarios completed: 150
      Requests completed:  150
      RPS sent: 4.99
      Request latency:
        min: 218.4
        max: 4024
        median: 297.4
        p95: 2908.8
        p99: 3871.1
      Scenario counts:
        0: 150 (100%)
      Codes:
        200: 150

>
    A basic concept you need to understand before we start analyzing the Artillery report is the
    concept of Scenarios. In a few words, a Scenario is a sequence of tasks or actions you want
    to test, and they are related. Imagine that you have an e-commerce application; a testing
    scenario can be all the steps a user performs before they complete a purchase. Consider the
    following example:
    1. The user loads the home.
    2. The user searches for a product.
    3. The user adds a product to the basket.
    4. The user goes to the checkout.
    5. The user makes the purchase.
    All the mentioned actions can be transformed into a request to your application
    that simulates the user action, which means that a scenario is a group of requests.

> 95% (p95) and the 99%
  (p99).              
    