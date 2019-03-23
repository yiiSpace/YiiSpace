sql中的查询操作 就像是在一堆东西里面挑出满意的

select 
   user_name  , sex , age 
   
from 
   user
   
where 
    sex = 1 , age>20 ..
    
join user_profile on user_profile.user_id = user.id

order by user_name ASC

limit 10
                 
sql命令解析器 先解析成一颗树
然后优化

两个盒子中挑选结果

先链接 在filter过滤（where部分）   还是先filter 再join 这个影响内存开销

最终在projection 投影

很类似photoshop中 处理图像 横裁剪（where过滤） 水平切割（projection 投影 选取特定列）
                 