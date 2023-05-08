group by 后 

~~~sql
    
    SELECT  GROUP_CONCAT(some_field) , cate_id FROM goods GROUP BY cate_id ;
    SELECT  GROUP_CONCAT(some_field SEPARATOR '|') , cate_id FROM goods GROUP BY cate_id ; -- 指定连接时的分割符为竖线
    SELECT  GROUP_CONCAT(some_field [,<another_field>]* ORDER BY goods_id SEPARATOR '|') , cate_id FROM goods GROUP BY cate_id ; -- 支持排序

    -- 还支持多字段连接 
~~~