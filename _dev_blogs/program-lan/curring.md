## 克里化

"communicating sequential processes" (CSP) 风格函数

func  someFunc(p1 , p2, p3 )
   <=>
func someFuncStyle(p1)(p2)(p3)
   
某种角度解

~~~
func someFunc(p1, p2, p3){
     dosomeThingWith p3
     
     dosomeThingWith p1
     dosomeThingWith p2
}

==>
-- 假设形式
func funStage1(p1){
   
   return func(p2){
   
        return func(p3){
          -- 代码写在最后一个函数中
          
           dosomeThingWith p3
               
           dosomeThingWith p1
           dosomeThingWith p2
        }
   }
   
}
# 等价效果
someFunc(p1,p2, p3 )  <==> funcStage(p1)(p2)(p3) 

# 根据参数的个数 会出现不同组合
- p1,(p2, p3)
- (p1, p2), p3

-- stage1
func f1(p1,p2){

    return func(p3){
        
    }
}
~~~