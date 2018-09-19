<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 15-1-12
 * Time: 下午1:04
 */

namespace year\map\amap;


use year\base\Widget;
use year\web\RunnableWidgetInterface;
use yii\helpers\Json;

class GeoCoordinatePicker extends Widget implements RunnableWidgetInterface
{
   public $trigger = '';

   public $callback = '';

    public function run()
    {
        // 此代码用来处理iframe加载情况
        $callback = \Yii::$app->request->get('callback','');

        $options = [
            'trigger'=>$this->trigger ,
            'callback'=> empty($callback)? $this->callback : $callback,
        ];
        $options = Json::encode($options);
        if(empty($this->trigger)){



            return $this->render('picker-iframe-content',
            [
                'options'=>$options,
            ]
            );
        }else{
            return $this->render('coordinate-picker',[
                'options'=>$options,
            ]);
        }

    }

} 