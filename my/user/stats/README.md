实现统计相关的功能

涉及的处理

statistic
    统计
    
aggregation
    聚合          
    Metric aggregations        矩阵
    
    如ElasticSearch 中对某个字段进行统计聚合
    ~~~
         
         {
         "size": 0,
         "aggs": {
         "by_stats": {
         "stats": {
         "field": "bytes"
         }
         }
         }
         }
    ~~~
    结果
    
    "aggregations": {
    "by_stats": {
    "count": 2843774,
    "min": 2086,
    "max": 4884,
    "avg": 3556.769230769231,
    "sum": 3932112564
    }
    }
    
    
聚合的多层次 嵌套
------

时间段内的聚合
    
~~~ES
   
    {
    "size": 0,
    "aggs": {
    "over_time": {
    "date_histogram": {
    "field": "@timestamp",
    "interval": "20m"
    },
    "aggs": {
    "by_verb": {
    "terms": {
    "field": "verb"
    },
    "aggs": {
    "by_bytes": {
    "stats": {
    "field": "bytes"
    }
    }
    }
    }
    }
    }
    }
    }
~~~    