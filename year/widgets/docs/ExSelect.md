
使用涉及到服务方跟js配置：

js：
~~~

<?php
use yii\helpers\Url ;
use yii\web\JsExpression ;

year\widgets\ExSelect::widget(
    [
        'container' => '#area_placeholder',
        'url' => Url::to(['/sys/area-load-children']), // $this->createUrl('4areaSelect'),
        // 'maxLevel' => 4,
         'initNodeId' => 14176,
      //'loadAncestorsUrl' => \yii\helpers\Url::to(['/sys/area-load-ancestors', 'id' => 14176]),
        'loadAncestorsUrl' => \yii\helpers\Url::to(['/sys/area-load-ancestors']),
         // 'editable' => $model->isNewRecord,
        'selectHtmlOptions' => json_decode('{"style":"float:left;margin:0 10px 0 0;","name":"node[]","class":"w-ssmall font12"}'),
        'firstOptionCallBack'=>new JsExpression( 'function(level){
                // "this" represent the current jquery object !
               // var text = $(this).find("select").eq(level).find("option:selected").text();
               // var text = $(this).find("select").size();
               // alert("回调的"+text);
               return "随便啦";

        }'),
        'callback' => new \yii\web\JsExpression("function(selectedValues){
                        //alert('选择的地区地址是:'+selectedValues);
                                              var areaIds = selectedValues ;
                                              var lastAreaId = areaIds.slice(-1)[0];
                                              if( lastAreaId != 0){
                                                   $('#{$area_id}').val(lastAreaId);
                                                   $('#{$district_id}').val(areaIds.slice(2)[0]);
                                                   $('#{$city_id}').val(areaIds.slice(1)[0]);
                                                   $('#{$province_id}').val(areaIds.slice(0)[0]);
                                              }else{
                                                 // 非最后一个选择 那么清空前面的选择
                                                   $('#{$area_id}').val('');
                                                   $('#{$district_id}').val('');
                                                   $('#{$city_id}').val('');
                                                   $('#{$province_id}').val('');
                                              }
                 }"),
        'debug' => true,

    ]
);
?>
~~~
 php 端：
 ~~~

    public function actionAreaLoadChildren()
    {
        $request = \Yii::$app->request;
        $pid = $parentId = $request->get('parentId', 0);

        $cacheKey = __CLASS__ . $pid;

        $options = \Yii::$app->cache->get($cacheKey);
        if ($options === false) {
            $query = new Query();
            $query->select('area_id as id,area_name as name ,level,parent_id');
            // $query->select = explode(',','area_id as id,area_name as name ,level,parent_id');
            $query->from(Area::tableName());
            $query->where('parent_id=:pid AND status=1', [':pid' => $pid]);

            $areas = $query->all();
            $options = \yii\helpers\ArrayHelper::map($areas, 'id', 'name');


            $dependency = new \yii\caching\TagDependency(['tags' => ['area']]);
            \Yii::$app->cache->set($cacheKey, $options, 0, $dependency);
        }

        \Yii::$app->response->format = 'json';

        return  $options ;//\yii\helpers\Json::encode($options);

    }

    public function actionAreaLoadAncestors()
    {
        $request = \Yii::$app->request;
        $id = $request->get('id', 0);

        $cacheKey = __CLASS__ . $id;


        $ancestors = \Yii::$app->cache->get($cacheKey);
        if ($ancestors === false) {
            $ancestors = array();

            $this->loadAreaParent($id, $ancestors);

            // 去掉最后一位
            array_pop($ancestors);
            // $ancestors = array_reverse($ancestors);
            // regenerate $value because it is not found in cache
            // and save it in cache for later use:

            $dependency = new TagDependency(['tags'=>'area']);

            \Yii::$app->cache->set($cacheKey, $ancestors, 0, $dependency);
        }

        \Yii::$app->response->format = 'json';
        return  $ancestors ; //\yii\helpers\Json::encode($ancestors);

    }

    protected function loadAreaParent($id, &$ancestors)
    {
        $area = Area::findOne($id);
        $ancestors = explode('/', $area->path_ids);
        /*
         $eq = EasyQuery::instance('c_area');

         $pid = $eq->queryScalar('parent_id', array(
             'select' => 'parent_id',
             'where' => 'area_id=:id',
         ), array(':id' => $id));
         $ancestors[] = $pid;

         if($pid != 0){
             $this->loadParent($pid,$ancestors);
         }
        */
    }

 ~~~