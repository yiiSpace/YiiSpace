TODO
--------------

-  排序字段的格式统一化处理 可以参考
  
       + yii的字段排序特征
       + easyUI 对排序字段的处理方式
       + goLang beego的ORM框架中对字段排序的风格
   
-  对查询参数的统一化处理

       +  可以参考ElasticSearch中排序字段的名称 参数传递方式
       +  ...
       
-  对过滤字段的处理方式
       +  yii中使用了表单提交来处理高级查询 传递参数的形式如： SearchModelX[attr1]=x&SearchModelX[attr2]=y&...
          需要把这种形式变为api友好的方式
          api 是类似rpc风格的情形: queryMethodX($q=...,$filter=...) : results[]|pagedResults{}
            就是说有很多的可选参数，在ElasticSearch中术语： 查询跟过滤是有区别的 查询一般是模糊匹配（like xxx）；
            而过滤是精确匹配 ；在yii的web式处理方式下是不区分查询跟过滤的 只是根据AR字段的类型分别做like或者其他匹配，随便找
            个gii生成的search模型看看：
            
            ~~~
                
                $query->andFilterWhere([
                            'order_id' => $this->order_id,
                            'province_id' => $this->province_id,
                            'city_id' => $this->city_id,
                            'district_id' => $this->district_id,
                            'area_id' => $this->area_id,
                        ]);
                
                        $query->andFilterWhere(['like', 'consignee', $this->consignee])
                            ->andFilterWhere(['like', 'tel', $this->tel])
            
             ~~~
       
      基本可以看出text varchar型的字段gii生成的一般是like过滤（andFilterWhere(['like... ）
      而对于整形式（int float ..）的字段采用的是无like匹配------>等价的底层where字句部分是精确匹配 "="
      
      yii默认的查询是带搜索表单名称的: SearchModelX 但在api形式中，不会带这么冗长的东东的，
      变像语义为 $filter='attr1=v1&attr2=v2&..' 或者可以参考ES的语法形式。
   