两种形式的方法设计


public function  getXxx(){
    
    return $this->xxx;
}


public function  setXxx(SomeKind $xxx){
    
    $this->xxx = $xxx;
    
    return $this ; // 允许链式调用
}



另一种风格 是jQuery那种 一个方法根据所传参数决定是getter还是setter

public function xxx(SomeKind $xxx= {{ZeroValue}} ){

    if(empty($xxx))){
        return $this->_xxx ;
    }else{
        $this->_xxx = $xxx ;
        return $this ; // 允许链式调用
    }

}
