<?php
/**
 * User: yiqing
 * Date: 2014/12/21
 * Time: 18:27
 */

namespace year\widgets;


use yii\base\InvalidConfigException;
use yii\grid\Column;
use yii\helpers\Html;
use yii\helpers\Json;
use yii\web\View;

/**
 * usage :
 * ~~~php
     [
         'class'=>\year\widgets\DetailColumn::className(),
             'urlExpression'=>function(){
                 return 'hi';
             },
    ],
 *
 * ~~~
 *
 * Class DetailLinkColumn
 * @package year\widgets
 */
class DetailLinkColumn extends Column
{

    public $label = 'details';

    public $labelExpression;

    public $imageUrl;

    public $url = 'javascript:void(0)';

    public $urlExpression;

    public $options = array('class' => 'link-column');

    public $headerOptions = array('class' => 'link-column');

    public $footerOptions = array('class' => 'link-column');

    public $linkOptions = array();


    //------------------------------------------------------------------------------------------------------------\\

    public $cssClass = 'tbrelational-column';

    /**
     * 一起提交给php端的数据
     * @var array
     */
    public $submitData = array();

    /**
     * @var bool
     */
    public $cacheData = true;


    public $afterAjaxUpdate = '$.noop';


    public $ajaxErrorMessage = 'Error';

    /**
     * 过滤下 给个机会来处理下php端返回的数据
     *
     * 比如传递过来的是json格式 你可以做下特殊处理
     * （比如 template+json）
     * @var string|JsExpression
     *
     * 'responseFilter'=>'function(resp){ return resp }',
     */
    public $responseFilter = 'function(resp){ return resp; }';

    /**
     * widget initialization
     */
    public function init()
    {
        parent::init();

        if (empty($this->urlExpression)) {
            throw new InvalidConfigException('must give a url for ajax load the content !');
        }
         $this->registerClientScript();
    }

    /**
     * Renders a data cell.
     * @param mixed $model the data model being rendered
     * @param mixed $key the key associated with the data model
     * @param integer $index the zero-based index of the data item among the item array returned by [[GridView::dataProvider]].
     * @return string the rendering result
     */
    protected function renderDataCellContent($model, $key, $index)
    {

        if ($this->urlExpression !== null)
            $url = call_user_func_array($this->urlExpression, [$model, $key, $index]);
        else
            $url = $this->url;
        if ($this->labelExpression !== null)
            $label = call_user_func_array($this->labelExpression, [$model, $key, $index]);
        else
            $label = $this->label;
        $options = $this->linkOptions;

        Html::addCssClass($options, $this->cssClass);

        if (is_string($this->imageUrl))
            return Html::a(Html::image($this->imageUrl, $label), $url, $options);
        else
            return Html::a($label, $url, $options);
    }


    /**
     * TODO 这段代码可重构为jquery 插件
     *
     * Register script that will handle its behavior
     */
    public function registerClientScript()
    {


        $view = $this->grid->getView();

        $data = Json::encode($this->submitData);
        $afterAjaxUpdate = $this->afterAjaxUpdate;
        $responseFilter = $this->responseFilter ;
        $cache = Json::encode($this->cacheData) ;

        /*
       $this->ajaxErrorMessage = CHtml::encode($this->ajaxErrorMessage);
       $afterAjaxUpdate = CJavaScript::encode($this->afterAjaxUpdate);
           */

        // 	$js[]="jQuery(document).on('click','#{$this->grid->id} a.{$class}',$function);";

        $js = <<<EOD
\$(document).on('click','#{$this->grid->id} a.{$this->cssClass}', function(){
               // alert("dodo");
                var that = this;
                var \$tr = $(that).closest("tr");
                if($(\$tr).next(".children").size()>0){
                    $(\$tr).next(".children").toggle();
                    return false;
                }

                var \$table = $(that).closest("table");
                var \$insertingTr ,\$insertingTd ;

                if( $("tbody", \$table).children("tr.children").size()==0){
                    \$insertingTr = $('<tr class="children"></tr>');
                     \$insertingTd = $('<td></td>').prop('colspan',\$tr.children().size());
                }else{
                    // 存在
                    \$insertingTr =  $(\$table).find(".children").first();
                    \$insertingTd =  \$insertingTr.find('td').first();
                }
                \$insertingTr.css("border","1px #DDDDDD dashed");


                var url = $(this).attr("href");
                // 传递额外值过去
                var data = $.extend({$data}, {});
                var afterAjaxUpdate = {$afterAjaxUpdate};
                var responseFilter = {$responseFilter};

                $.ajax({
                        url: url,
                        data: data,
                        cache: {$cache},
                        success: function(data){
                               if($.isFunction(responseFilter)){
			                          data = responseFilter(data);
		                     	}
                             \$insertingTd.empty().html(data);
                              \$insertingTr.empty().append(\$insertingTd);

                               // 显示下 防止上面的toggle 影响其不显示！
                               \$insertingTr.css("display","").css("background-color","#F1F1F1");

                              \$tr.after(\$insertingTr);

                               if ($.isFunction(afterAjaxUpdate)){
				                      afterAjaxUpdate(data,\$insertingTr);
			                   }
                        },
                        error: function()
                        {
                              \$insertingTd.empty().html('{$this->ajaxErrorMessage}');
                              \$insertingTr.empty().append(\$insertingTd);
                              \$tr.after(\$insertingTr);
                            \$that.data('status','off');
                        }
	             });
                 return false;
});
EOD;
        $view->registerJs($js, View::POS_READY, __CLASS__);
    }
    //------------------------------------------------------------------------------------------------------------//

} 