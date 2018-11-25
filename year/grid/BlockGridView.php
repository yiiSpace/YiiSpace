<?php
/**
 * Created by PhpStorm.
 * User: yiqing
 * Date: 2018/9/20
 * Time: 16:34
 */

namespace year\grid;

/**
 * 可以在GridView 内渲染 view->block 的内容 在layout里面 冠以block_前缀 {pager}{block_blockID}{summary}...
 *
 * Class BlockGridView
 * @package year\grid
 */
class BlockGridView  extends \yii\grid\GridView
{
    /**
     * @var string
     */
    public $blockPrefix = 'block_' ;

    /**
     * @inheritdoc
     */
    public function renderSection($name)
    {
        // die($name) ;
        $matches = [];
        if (preg_match('/{block_(\\w+)}/i', $name, $matches)) {
            $blockId = $matches[1];
            $view = $this->getView() ;

            if(isset($view->blocks[$blockId])){
                return $this->getView()->blocks[$blockId];
            }else{
                return $matches[0] ;
            }

            //   return print_r($matches,true);
        } else {
            return parent::renderSection($name);
        }
    }
}