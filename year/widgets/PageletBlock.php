<?php
/**
 * User: yiqing
 * Date: 2014/12/9
 * Time: 19:54
 */

namespace year\widgets;


use yii\base\Widget;

/**
 * 此区域中的内容会用来填充/替换指定的目标id区域
 * 此类最早思想来自 bigpipe 概念
 * 
 * 
 * vue3 中有个Teleport组件 感觉跟此很相似 
 * 
 *
 * Class PageletBlock
 * @package app\widgets
 */
class PageletBlock extends Widget{
    
    /**
     * 允许内容注入
     */
    public $content = '' ;

    /**
     * 要被替换的div id
     *
     * @var string
     */
    public $targetId = '';
    /**
     * TODO call parent::init
     *
     * Starts recording a block.
     */
    public function init()
    {
        ob_start();
        ob_implicit_flush(false);
    }

    /**
     * Ends recording a block.
     * This method stops output buffering and saves the rendering result as a named block in the view.
     */
    public function run()
    {
        $block = ob_get_clean() . $this->content;

        $id = $this->getId();
        $content = [];

        $content[] = <<<EOD
    <script id="{$id}" type="text/x-my-template">
       {$block}
    </script>
EOD;
      $content[] = <<<JS_REPLACE
    <script  type="text/javascript">
       document.getElementById("{$this->targetId}").innerHTML =
            document.getElementById("{$id}").innerHTML ;
    </script>
JS_REPLACE;
      return implode("\n",$content) ;

    }
} 