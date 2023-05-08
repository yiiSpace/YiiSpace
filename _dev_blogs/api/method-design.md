[[learning flask framework]]
>
   function load(entryId) {
            var filters = [{
                'name': 'entry_id',
                'op': 'eq',
                'val': entryId}];
            var serializedQuery = JSON.stringify({'filters': filters});
            $.get('/api/comment', {'q': serializedQuery}, function(data) {
                if (data['num_results'] === 0) {
                    displayNoComments();
                } else {
                    displayComments(data['objects']);
                }
            });
        }
  
            
注意q参数后面的json编码  这种使用方法很新颖 
            
对于YII而言 如果你想支持复杂的条件 请参考Query 支持的where部分的那些个数组表示  直接可以对应到前端的json表示哦
是可以做平滑过渡：

~~~

    ['or' , ['name'=>'qing'] ,['>=' , 'age' , 18 ] ]

~~~
这种表达式 好像在语法学里面有个特定名字的（xxx表达式？）  反正不是AST哦！
          
            