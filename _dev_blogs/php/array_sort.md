# 数组排序

php中数组排序有两簇做法
1. 函数做法
2. 面向对象做法

## 函数做法：

~~~
            
        sort：本函数为 array 中的单元赋予新的键名。这将删除原有的键名而不仅是重新排序。
        rsort：本函数对数组进行逆向排序（最高到最低）。 删除原有的键名而不仅是重新排序。
        asort：对数组进行排序并保持索引关系
        arsort：对数组进行逆向排序并保持索引关系
        
        ksort：对数组按照键名排序，保留键名到数据的关联
        krsort：对数组按照键名逆向排序，保留键名到数据的关联
        
        natsort：对字母数字字符串进行排序并保持原有键／值的关联
        natcasesort：同natsort排序算法，但不区分大小写字母排序
        
        
        PHP 数组排序(sort)
        数字索引数组排序：
        函数：sort(array, [sort type])
        说明：sort()函数按升序对指定数组(第一个参数)进行排序。
        sort函数第二参数作用为指定排序类型，是可选参数，可能的值为：
        SORT_REGULAR: 默认值，不改变类型进行排序；
        SORT_NUMERIC: 把值作为数字进行排序；
        SORT_STRING: 把值作为字符串进行排序；
        如数组中有4和”37″，按数字排序，4小于”37″；按字符串排序，4大于”37″；
        
        复制代码 代码如下:
        
        <?php
        $a = array(4,"37",3,100,0,-5);
        sort($a);
        for ($i=0; $i<6; ++$i){
        echo $a[$i]." ";
        }
        echo "<br />";
        sort($a,SORT_STRING);
        for ($i=0; $i<6; ++$i){
        echo $a[$i]." ";
        }
        echo "<br />";
        ?>
        
        输出结果：
        
        -5 0 3 4 37 100
        -5 0 100 3 37 4
        
        降序排序：rsort(array, [sort type])
        参数用法与sort函数相同。
        
        关联数组排序：
        函数：asort(array, [sort type])
        说明：根据关联数组的元素值进行升序排序。参数使用见上面的sort函数。
        
        函数：ksort(array, [sort type])
        说明：根据关联数组的关键字进行升序排序。参数使用见上面的sort函数。
        
        
        复制代码 代码如下:
        
        <?php
        $a = array(
        "good" => "bad",
        "right" => "wrong",
        "boy" => "girl");
        
        echo "value sort<br />";
        asort($a);
        foreach($a as $key => $value){
        echo "$key : $value<br />";
        }
        
        echo "<br />key sort<br />";
        ksort($a);
        foreach($a as $key => $value){
        echo "$key : $value<br />";
        }
        ?>
        
        输出结果：
        
        value sort
        good : bad
        boy : girl
        right : wrong
        
        key sort
        boy : girl
        good : bad
        right : wrong
        降序排序：
        arsort(array, [sort type]) 与 asort对应
        krsort(array, [sort type]) 与 ksort对应
        
        
        快速创建数组的函数range()
        
        比如range()函数可以快速创建从1到9的数字数组：
        复制代码 代码如下:
        
        <?php
        $numbers=range(1,9);
        echo $numbers[1];
        ?>
        
        当然，使用range(9,1)则创建了9到1的数字数组。同时，range()还可以创建从a到z 的字符数组：
        复制代码 代码如下:
        
        <?php
        $numbers=range(a,z);
        foreach ($numbers as $mychrs)
        echo $mychrs." ";
        ?>
        
        
        使用字符数组时注意大小写，比如range(A,z)和range(a,Z)是不一样的。range()函数还具有第三个参数，该参数的作用是设定步长，比如range(1,9,3)创建的数组元素是：1、4、7。常见PHP数组排序一般数组中的各元素均以字符或数字表现的，所以可对数组元素进行升序排列，该功能函数为sort()。比如：
        复制代码 代码如下:
        
        <?php
        $people=array('name','sex','nation','birth');
        foreach ($people as $mychrs)
        echo $mychrs." ";
        sort($people);
        echo "<br />---排序后---<br />";
        foreach ($people as $mychrs)
        echo $mychrs." ";
        ?>
        
        升序排序后的数组元素显示为 birth name nation sex，当然，sort()函数是区分字母大小写的（字母从大到小的顺序是：A…Z…a…z）
        
        Sort()函数还具有第二参数，用来说明PHP数组排序升序的规则是用来比较数字还是字符串的。比如：
        复制代码 代码如下:
        
        <?php
        echo "---按数字升序排序---<br />";
        $num2=array('26','3',);
        sort($num2,SORT_NUMERIC);
        foreach ($num2 as $mychrs)
        echo $mychrs." ";
        echo "<br />---按字符升序排序---<br />";
        $num3=array('26','3');
        sort($num3,SORT_STRING);
        foreach ($num3 as $mychrs)
        echo $mychrs." ";
        ?>
        
        SORT_NUMERIC和SORT_STRING用来声明按数字或字符的升序排列。如果按照数字升序排列是：3，26；但如果按照字符升序排列则是：26，3了。PHP中除了升序函数以外，还有降序或称反向排列的函数，就是rsort()函数，比如：$num1=range(1,9);rsort($num1);这里其实就相当于range(9,1)。
            
~~~

## 面向对象做法：

[php 手册](http://tools.dedecms.com/uploads/docs/php/arrayobject.asort.html)

~~~
            
    ArrayObject::asort
    
    (PHP 5 >= 5.2.0)
    
    ArrayObject::asort — Sort the entries by value
    说明
    public void ArrayObject::asort ( void )
    
    Sorts the entries such that the keys maintain their correlation with the entries they are associated with. This is used mainly when sorting associative arrays where the actual element order is significant.
    参数
    
    此函数没有参数。
    返回值
    
    没有返回值。
    范例
    
    Example #1 ArrayObject::asort() example
    <?php
    $fruits = array("d" => "lemon", "a" => "orange", "b" => "banana", "c" => "apple");
    $fruitArrayObject = new ArrayObject($fruits);
    $fruitArrayObject->asort();
    
    foreach ($fruitArrayObject as $key => $val) {
        echo "$key = $val\n";
    }
    ?>
    
    以上例程会输出：
    
    c = apple
    b = banana
    d = lemon
    a = orange
    
    The fruits have been sorted in alphabetical order, and the key associated with each entry has been maintained.
    
    参见
    
        ArrayObject::ksort() - Sort the entries by key
        ArrayObject::natsort() - Sort entries using a "natural order" algorithm
        ArrayObject::natcasesort() - Sort an array using a case insensitive "natural order" algorithm
        ArrayObject::uasort() - Sort the entries with a user-defined comparison function and maintain key association
        ArrayObject::uksort() - Sort the entries by keys using a user-defined comparison function


~~~