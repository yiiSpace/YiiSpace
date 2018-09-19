分布式追踪
请求入口处生成一个 事务id

每流经一个服务   服务可以添加自己的tag  标明用来追踪的纬度
可以有span_id {begin_time,  end_time }   用来统计该服务的某个代码块的 耗时

这些信息都被添加到 header 中   所有请求结束时做聚合  然后存kv存储  （如redis中的哈希）
逻辑结构
>
    tran_id
           tag_id
                  span_id      
               