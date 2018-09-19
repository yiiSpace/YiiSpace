http://blog.csdn.net/kenhins/article/details/52814333

~~~


版权声明：本文为博主原创文章，未经博主允许不得转载。


按年汇总，统计：
select sum(mymoney) as totalmoney, count(*) as sheets from mytable group by date_format(col, '%Y');
按月汇总，统计： 
select sum(mymoney) as totalmoney, count(*) as sheets from mytable group by date_format(col, '%Y-%m');
按季度汇总，统计： 
select sum(mymoney) as totalmoney,count(*) as sheets from mytable group by concat(date_format(col, '%Y'),FLOOR((date_format(col, '%m')+2)/3)); 
select sum(mymoney) as totalmoney,count(*) as sheets from mytable group by concat(date_format(col, '%Y'),FLOOR((date_format(col, '%m')+2)/3));
按小时： 
select sum(mymoney) as totalmoney,count(*) as sheets from mytable group by date_format(col, '%Y-%m-%d %H ');
查询 本年度的数据:
SELECT * FROM mytable WHERE year(FROM_UNIXTIME(my_time)) = year(curdate())
查询数据附带季度数:
SELECT id, quarter(FROM_UNIXTIME(my_time)) FROM mytable;
查询 本季度的数据:
SELECT * FROM mytable WHERE quarter(FROM_UNIXTIME(my_time)) = quarter(curdate());
本月统计:
select * from mytable where month(my_time1) = month(curdate()) and year(my_time2) = year(curdate())
本周统计:
select * from mytable where month(my_time1) = month(curdate()) and week(my_time2) = week(curdate())
N天内记录:
WHERE TO_DAYS(NOW())-TO_DAYS(时间字段)<=N


例子：

[sql] view plain copy
print?在CODE上查看代码片派生到我的代码片

    -- 全站时段统计  
      
    SELECT tch.hourlist as hourStr,  
      IFNULL(tv.numStr,0) as viewCount,  
      IFNULL(ts.numStr,0) as shareCount,  
      IFNULL(tl.numStr,0) as likesCount,  
      IFNULL(tc.numStr,0) as collectCount   
     FROM  
    (SELECT hourlist from t_calendar_hour) as tch   
     LEFT JOIN (select  DATE_FORMAT(CREATE_TIME,'%H') as hourStr, count(ID) as numStr from t_article_view_record where 1=1 and CREATE_TIME>='2016-06-20 00:00:00' and CREATE_TIME<='2016-06-20 23:59:59' GROUP BY DATE_FORMAT(CREATE_TIME,'%Y-%m-%d %H')) as tv   
     ON tv.hourStr = tch.hourlist   
     LEFT JOIN (select  DATE_FORMAT(CREATE_TIME,'%H') as hourStr, count(ID) as numStr from t_article_share_record where 1=1 and CREATE_TIME>='2016-06-20 00:00:00' and CREATE_TIME<='2016-06-20 23:59:59' GROUP BY DATE_FORMAT(CREATE_TIME,'%Y-%m-%d %H')) as ts   
      ON ts.hourStr = tch.hourlist   
     LEFT JOIN (select  DATE_FORMAT(CREATE_TIME,'%H') as hourStr, count(ID) as numStr from t_article_likes_record where 1=1 and CREATE_TIME>='2016-06-20 00:00:00' and CREATE_TIME<='2016-06-20 23:59:59' GROUP BY DATE_FORMAT(CREATE_TIME,'%Y-%m-%d %H')) as tl   
      ON tl.hourStr = tch.hourlist   
     LEFT JOIN (select  DATE_FORMAT(CREATE_TIME,'%H') as hourStr, count(ID) as numStr from t_article_collection_record where 1=1 and CREATE_TIME>='2016-06-20 00:00:00' and CREATE_TIME<='2016-06-20 23:59:59' GROUP BY DATE_FORMAT(CREATE_TIME,'%Y-%m-%d %H')) as tc   
      ON tc.hourStr = tch.hourlist   
     WHERE 1=1 ORDER BY tch.hourlist ASC;  
      
      
      
    创建存储过程  
    DELIMITER;//  
    create procedure myproc()  
    begin   
    declare num int;   
    set num=1;   
    while num <= 24 do   
    insert into t_calendar_hour(hourlist) values(num);  
    set num=num+1;  
    end while;  
    commit;   
    end;//  
      
    调用存储过程  
    CALL myproc();  
      
    -- 文章按时段统计  
      
    SELECT tch.hourlist as hourStr,  
      IFNULL(tv.numStr,0) as viewCount,  
      IFNULL(ts.numStr,0) as shareCount,  
      IFNULL(tl.numStr,0) as likesCount,  
      IFNULL(tc.numStr,0) as collectCount   
     FROM  
    (SELECT hourlist from t_calendar_hour) as tch   
     LEFT JOIN (select  DATE_FORMAT(CREATE_TIME,'%H') as hourStr, count(ID) as numStr from t_article_view_record where 1=1 and ARTICLE_ID="e548fdc0556bb01a01556bc6723b0005" and CREATE_TIME>='2016-06-20 00:00:00' and CREATE_TIME<='2016-06-20 23:59:59' GROUP BY DATE_FORMAT(CREATE_TIME,'%Y-%m-%d %H')) as tv   
     ON tv.hourStr = tch.hourlist   
     LEFT JOIN (select  DATE_FORMAT(CREATE_TIME,'%H') as hourStr, count(ID) as numStr from t_article_share_record where 1=1 and ARTICLE_ID="e548fdc0556bb01a01556bc6723b0005" and CREATE_TIME>='2016-06-20 00:00:00' and CREATE_TIME<='2016-06-20 23:59:59' GROUP BY DATE_FORMAT(CREATE_TIME,'%Y-%m-%d %H')) as ts   
      ON ts.hourStr = tch.hourlist   
     LEFT JOIN (select  DATE_FORMAT(CREATE_TIME,'%H') as hourStr, count(ID) as numStr from t_article_likes_record where 1=1 and ARTICLE_ID="e548fdc0556bb01a01556bc6723b0005" and CREATE_TIME>='2016-06-20 00:00:00' and CREATE_TIME<='2016-06-20 23:59:59' GROUP BY DATE_FORMAT(CREATE_TIME,'%Y-%m-%d %H')) as tl   
      ON tl.hourStr = tch.hourlist   
     LEFT JOIN (select  DATE_FORMAT(CREATE_TIME,'%H') as hourStr, count(ID) as numStr from t_article_collection_record where 1=1 and ARTICLE_ID="e548fdc0556bb01a01556bc6723b0005" and CREATE_TIME>='2016-06-20 00:00:00' and CREATE_TIME<='2016-06-20 23:59:59' GROUP BY DATE_FORMAT(CREATE_TIME,'%Y-%m-%d %H')) as tc   
      ON tc.hourStr = tch.hourlist   
     WHERE 1=1 ORDER BY tch.hourlist ASC;  
      
      
    SELECT hourlist from t_calendar_hour;  
      
    select DATE_FORMAT(CREATE_TIME,'%Y-%m-%d') as dateStr, DATE_FORMAT(CREATE_TIME,'%H') as hourStr, count(ID) as numStr from t_article_view_record where ARTICLE_ID="e548fdc0556bb01a01556bc6723b0005" and CREATE_TIME>='2016-06-20 00:00:00' and CREATE_TIME<='2016-06-20 23:59:59' GROUP BY DATE_FORMAT(CREATE_TIME,'%Y-%m-%d %H');  
      
    select DATE_FORMAT(CREATE_TIME,'%Y-%m-%d') as dateStr, DATE_FORMAT(CREATE_TIME,'%H') as hourStr, count(ID) as numStr from t_article_share_record where ARTICLE_ID="e548fdc0556bb01a01556bc6723b0005" and CREATE_TIME>='2016-06-20 00:00:00' and CREATE_TIME<='2016-06-20 23:59:59' GROUP BY DATE_FORMAT(CREATE_TIME,'%Y-%m-%d %H');  
      
    select DATE_FORMAT(CREATE_TIME,'%Y-%m-%d') as dateStr, DATE_FORMAT(CREATE_TIME,'%H') as hourStr, count(ID) as numStr from t_article_likes_record where ARTICLE_ID="e548fdc0556bb01a01556bc6723b0005" and CREATE_TIME>='2016-06-20 00:00:00' and CREATE_TIME<='2016-06-20 23:59:59' GROUP BY DATE_FORMAT(CREATE_TIME,'%Y-%m-%d %H');  
      
    select DATE_FORMAT(CREATE_TIME,'%Y-%m-%d') as dateStr, DATE_FORMAT(CREATE_TIME,'%H') as hourStr, count(ID) as numStr from t_article_collection_record where ARTICLE_ID="e548fdc0556bb01a01556bc6723b0005" and CREATE_TIME>='2016-06-20 00:00:00' and CREATE_TIME<='2016-06-20 23:59:59' GROUP BY DATE_FORMAT(CREATE_TIME,'%Y-%m-%d %H');  
      
      
      
      
    文章数据全站统计  
        SPECIAL_ID="4028813d54851a470154855335040012" -- 频道  
        CREATOR="e548fdc054f170770154f17f55dc0008"  -- 编辑  
        AUTHOR="4028813d54084b6a015408a303f1003a"  -- 作者  
     and TITLE LIKE "%陷贿选门%"  
      
      
    SELECT t.ID as articleId, t.title as title,t.SPECIAL_ID as specialId,t.CREATOR as createId,t.author as authorId,t.FACT_TIME as factTime,  
      IFNULL(tv.numStr,0) as viewCount,  
      IFNULL(ts.numStr,0) as shareCount,  
      IFNULL(tl.numStr,0) as likesCount,  
      IFNULL(tc.numStr,0) as collectCount  
     FROM  
        (select ID,TITLE,SPECIAL_ID,CREATOR,AUTHOR,FACT_TIME from t_article WHERE  1=1 and SPECIAL_ID='e548fdc054f188670154f1b6366c000b' ORDER BY FACT_TIME DESC LIMIT 0,1000) as t   
       LEFT JOIN (SELECT ARTICLE_ID,CREATE_TIME, count(ID) as numStr from t_article_view_record where CREATE_TIME>='2016-9-16' and CREATE_TIME<='2016-10-16' GROUP BY ARTICLE_ID having numStr>=45 and numStr<=87) as tv   
            on t.ID = tv.ARTICLE_ID   
       LEFT JOIN (SELECT ARTICLE_ID,CREATE_TIME, count(ID) as numStr from t_article_share_record where CREATE_TIME>='2016-9-16' and CREATE_TIME<='2016-10-16' GROUP BY ARTICLE_ID) as ts   
            on t.ID = ts.ARTICLE_ID  
       LEFT JOIN (SELECT ARTICLE_ID,CREATE_TIME, count(ID) as numStr from t_article_likes_record where CREATE_TIME>='2016-9-16' and CREATE_TIME<='2016-10-16' GROUP BY ARTICLE_ID) as tl   
            on t.ID = tl.ARTICLE_ID  
       LEFT JOIN (SELECT ARTICLE_ID,CREATE_TIME, count(ID) as numStr from t_article_collection_record where CREATE_TIME>='2016-9-16' and CREATE_TIME<='2016-10-16' GROUP BY ARTICLE_ID) as tc   
            on t.ID = tc.ARTICLE_ID   
       where 1=1 ;  
      
      
        SELECT t.ID as articleId, t.title as title,t.SPECIAL_ID as specialId,t.CREATOR as createId,t.author as authorId,t.FACT_TIME as factTime,IFNULL(tv.numStr,0) as viewCount,IFNULL(ts.numStr,0) as shareCount,IFNULL(tl.numStr,0) as likesCount,IFNULL(tc.numStr,0) as collectCount FROM  (select ID,TITLE,SPECIAL_ID,CREATOR,AUTHOR,FACT_TIME from t_article WHERE 1=1  ORDER BY FACT_TIME DESC ) as t  LEFT JOIN (SELECT ARTICLE_ID,CREATE_TIME, count(ID) as numStr from t_article_view_record where 1=1  and CREATE_TIME>='2016-06-28' and CREATE_TIME<='2016-10-12'  GROUP BY ARTICLE_ID) as tv on t.ID = tv.ARTICLE_ID  LEFT JOIN (SELECT ARTICLE_ID,CREATE_TIME, count(ID) as numStr from t_article_share_record where 1=1  and CREATE_TIME>='2016-06-28' and CREATE_TIME<='2016-10-12' GROUP BY ARTICLE_ID) as ts on t.ID = ts.ARTICLE_ID  LEFT JOIN (SELECT ARTICLE_ID,CREATE_TIME, count(ID) as numStr from t_article_likes_record where 1=1  and CREATE_TIME>='2016-06-28' and CREATE_TIME<='2016-10-12' GROUP BY ARTICLE_ID) as tl on t.ID = tl.ARTICLE_ID  LEFT JOIN (SELECT ARTICLE_ID,CREATE_TIME, count(ID) as numStr from t_article_collection_record where 1=1  and CREATE_TIME>='2016-06-28' and CREATE_TIME<='2016-10-12'  GROUP BY ARTICLE_ID) as tc on t.ID = tc.ARTICLE_ID where 1=1  ORDER BY viewCount DESC  LIMIT 0,20;  
      
      
      
      
      
    SELECT ARTICLE_ID,CREATE_TIME, count(ID) as numStr from t_article_view_record where CREATE_TIME>='2016-9-16' and CREATE_TIME<='2016-10-16' GROUP BY ARTICLE_ID having numStr>=45 and numStr<=87;  
      
    SELECT ARTICLE_ID,CREATE_TIME, count(ID) as numStr from t_article_share_record where CREATE_TIME>='2016-9-16' and CREATE_TIME<='2016-10-16' GROUP BY ARTICLE_ID having numStr>=45;  
      
    SELECT ARTICLE_ID,CREATE_TIME, count(ID) as numStr from t_article_likes_record where CREATE_TIME>='2016-9-16' and CREATE_TIME<='2016-10-16' GROUP BY ARTICLE_ID having numStr>=45;  
      
    SELECT ARTICLE_ID,CREATE_TIME, count(ID) as numStr from t_article_collection_record where CREATE_TIME>='2016-9-16' and CREATE_TIME<='2016-10-16' GROUP BY ARTICLE_ID having numStr>=45;  
      
        
      
      
      
      
      
      
      
      
      
      
      
      
      
    文章图表数据详情  
    SELECT de.datelist as timeStr,   
    IFNULL(tv.numStr,0) as viewCount,  
    IFNULL(ts.numStr,0) as shareCount,  
    IFNULL(tl.numStr,0) as likesCount,  
    IFNULL(tc.numStr,0) as collectCount FROM  
    (SELECT * from t_calendar where datelist<'2016-07-01' ORDER BY datelist DESC LIMIT 0,100) as de   
      LEFT JOIN (select DATE_FORMAT(CREATE_TIME,'%Y-%m-%d') as dateStr,count(ID) as numStr from t_article_view_record where ARTICLE_ID="e548fdc0556bb01a01556bc6723b0005" GROUP BY DATE_FORMAT(CREATE_TIME,'%Y-%m-%d')) AS tv  
     on tv.dateStr = de.datelist   
     LEFT JOIN (select DATE_FORMAT(CREATE_TIME,'%Y-%m-%d') as dateStr,count(ID) as numStr from t_article_share_record where ARTICLE_ID="e548fdc0556bb01a01556bc6723b0005" GROUP BY DATE_FORMAT(CREATE_TIME,'%Y-%m-%d')) AS ts  
        on ts.dateStr = de.datelist    
     LEFT JOIN (select DATE_FORMAT(CREATE_TIME,'%Y-%m-%d') as dateStr,count(ID) as numStr from t_article_likes_record where ARTICLE_ID="e548fdc0556bb01a01556bc6723b0005" GROUP BY DATE_FORMAT(CREATE_TIME,'%Y-%m-%d')) AS tl  
        on tl.dateStr = de.datelist   
     LEFT JOIN (select DATE_FORMAT(CREATE_TIME,'%Y-%m-%d') as dateStr,count(ID) as numStr from t_article_collection_record where ARTICLE_ID="e548fdc0556bb01a01556bc6723b0005" GROUP BY DATE_FORMAT(CREATE_TIME,'%Y-%m-%d')) AS tc  
        on tc.dateStr = de.datelist   
     ORDER BY de.datelist DESC;  
      
      
    -- 按日统计   
    select DATE_FORMAT(CREATE_TIME,'%Y-%m-%d') as dateStr,count(ID) as numStr from t_article_view_record where ARTICLE_ID="e548fdc0556bb01a01556bc6723b0005" GROUP BY DATE_FORMAT(CREATE_TIME,'%Y-%m-%d');  
      
    select DATE_FORMAT(CREATE_TIME,'%Y-%m-%d') as dateStr,count(ID) as numStr from t_article_share_record where ARTICLE_ID="e548fdc0556bb01a01556bc6723b0005" GROUP BY DATE_FORMAT(CREATE_TIME,'%Y-%m-%d');  
      
    select DATE_FORMAT(CREATE_TIME,'%Y-%m-%d') as dateStr,count(ID) as numStr from t_article_likes_record where ARTICLE_ID="e548fdc0556bb01a01556bc6723b0005" GROUP BY DATE_FORMAT(CREATE_TIME,'%Y-%m-%d');  
      
    select DATE_FORMAT(CREATE_TIME,'%Y-%m-%d') as dateStr,count(ID) as numStr from t_article_collection_record where ARTICLE_ID="e548fdc0556bb01a01556bc6723b0005" GROUP BY DATE_FORMAT(CREATE_TIME,'%Y-%m-%d');  
      
    select * from t_article_share_record where ARTICLE_ID="e548fdc0556bb01a01556bc6723b0005";  


~~~