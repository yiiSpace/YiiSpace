递归消除：
>
    <?php
    function factorial($n, $accumulator = 1) {
        if ($n == 0) {
            return $accumulator;
        }
    
        return function() use($n, $accumulator) {
            return factorial($n - 1, $accumulator * $n);
        };
    }
    
    function trampoline($callback, $params) {
        $result = call_user_func_array($callback, $params);
    
        while (is_callable($result)) {
            $result = $result();
        }
    
        return $result;
    }
    
    var_dump(trampoline('factorial', array(100)));
    
    ?>
    
这里原本是对规调用的地方：
>
     return factorial($n - 1, $accumulator * $n);
     ## 改进后返回一个匿名函数
      return function() use($n, $accumulator) {
          return factorial($n - 1, $accumulator * $n);
      };
返回匿名函数而不是直接调用递归函数 使得栈不在变深
      
调用这个函数时 当得到一个函数返回时 需要调用它 此过程不断继续：
>
      $result = call_user_func_array($callback, $params);
        
            while (is_callable($result)) {
                $result = $result();
        }  
这样把递归调用变为循环调用 但堆栈不会很深 （这里不用担心栈溢出）        
     