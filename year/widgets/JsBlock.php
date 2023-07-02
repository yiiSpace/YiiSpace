<?php
/**
 * User: yiqing
 * Date: 14-9-15
 * Time: 下午12:09
 */

namespace year\widgets;

use yii\web\View ;
use yii\widgets\Block ;

/**
 * Class JsBlock
 * @package year\widgets
 */
class JsBlock extends Block{

    /**
     * @var null
     */
    public $key = null;
    /**
     * @var int
     */
    public $pos = View::POS_END ;

    /**
     * @var string
     * @since 1.0.1
     */
    public $content  ;

    /**
     *
     */
    public function init()
    {
        /**
         *
         */
        if(empty($this->content)){
            parent::init() ;
        }
    }
    /**
     * Ends recording a block.
     * This method stops output buffering and saves the rendering result as a named block in the view.
     */
    public function run()
    {
        if(empty($this->content)){

            $block = ob_get_clean();
            if ($this->renderInPlace) {
                throw new \Exception("not implemented yet ! ");
                // echo $block;
            }


        }else{

            $block = $this->content ;
        }

        $block = trim($block) ;
        /*
        $jsBlockPattern  = '|^<script[^>]*>(.+?)</script>$|is';
        if(preg_match($jsBlockPattern,$block)){
            $block =  preg_replace ( $jsBlockPattern , '${1}'  , $block );
        }
        */
        $jsBlockPattern  = '|^<script[^>]*>(?P<block_content>.+?)</script>$|is';
        if(preg_match($jsBlockPattern,$block,$matches)){
            $block =  $matches['block_content'];
        }

        $this->view->registerJs($block, $this->pos,$this->key) ;
    }

    /**
     * strip
     */
    public static function stripScriptTag($block)
    {
        $block = trim($block) ;
        /*
        $jsBlockPattern  = '|^<script[^>]*>(.+?)</script>$|is';
        if(preg_match($jsBlockPattern,$block)){
            $block =  preg_replace ( $jsBlockPattern , '${1}'  , $block );
        }
        */
        $jsBlockPattern  = '|^<script[^>]*?>(?P<block_content>.+?)</script>$|is';
        if(preg_match($jsBlockPattern,$block,$matches)){
            $block =  $matches['block_content'];
        }
        return $block ;
    }
} 