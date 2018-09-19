## 移除元素上的事件

- http://stackoverflow.com/questions/11609053/jquery-empty-function-and-event-handlers
~~~js
   
   $("#mydiv").empty().off("*");
~~~
>
    To remove all bound event handlers from an element, you can pass the special value "*" to the off() method:
    
    $("#mydiv").empty().off("*");
    When the documentation says remove events handlers, it only speaks of bound event handlers, not delegated ones, 
    since these are bound to an ancestor element (or the document itself) which is not impacted by the removal.
    
    This allows delegated handlers to keep working as intended if the removed element is reinstated later
