## 会话变量
- 形式1
~~~sql
    set @someVar:=1 ;
    select * , @someVar as col_x from my_table
~~~
- 形式2
>
    select * , IFNULL(@anyVar, @anyVar='first occur') from my_table
    
- 形式3
>
    select * , @someVar = @someVar || '---'   from my_table , (select @someVar='init_states'  ) as tbl_var
    --  相当于在临时表中定义变量的初始值  在select 中递增（这里是不断连接-- 在变量屁沟上）
    
注意session变量具有记忆性质 所以第三种形式 会做初始化！
    
基于此特性可以实现：``分组后在分组内排序、每个分组中取前N条``    
来自 沈逸（程序员在囧途作者）    
1 先group by 分组（比如category_id）
2 利用上面的变量特性  让当前变量值为上一次的category_id 
>
    cate_id  name                 price
      上衣    小棉袄                30
      上衣    军大衣                 200
      办公    铅笔
      办公    A4纸
      办公    垃圾篓
      
利用 遍历的特性 和会话变量的记忆性 对比上个cate_id 跟本次迭代的cate_id 是否相同 如果相同则递增变量
如果不同 则变量置为1或者零 （此处需要两个变量  select @rowNum=0 , @lastRowCateId = 0 ）
select ... IF(@lastRowCateId=cate_id, @rowNum:=@rowNum+1, @rowNum:=1) AS my_seq ,@lastRowCateId:=cate_id 
      
然后 会形成这样的结果

>
    cate_id  name                 price      @my_var (my_seq)
      上衣    小棉袄                30          1
      上衣    军大衣                200         2
      办公    铅笔                              1
      办公    A4纸                              2
      办公    垃圾篓                            3
            
最后结果集中只需要取  @my_var <=2  就表示取的是每个分组中的前N（此处为2） 个元素            
      

### 看起来表的select 有很多奇淫技巧 就跟你迭代数组类似
~~~php
foreach( $yourTable as $rowNum => $row ){
    ## 用$row 搞事情啦  
   // row上下文中  就跟你在当前select 后面感觉一样
}
~~~      

关系型表本质就是集合论 上面这个感觉就像：

~~~php
$sessionVar =  ''; // 初始化一个会话变量
foreach( $yourTable as $rowNum => &$row ){
   if($row['cate_id'] != $sessionVar){
        $row['my_var'] = 0 ;
   }else{
        $row['my_var'] =  $row['my_var'] + 1 ;
   }
   $sessionVar = $row[''cate_id] ;
}
~~~