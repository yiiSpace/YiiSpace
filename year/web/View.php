<?php
/**
 * User: yiqing
 * Date: 2015/1/1
 * Time: 23:50
 */

namespace year\web;


class View extends \yii\web\View{


    const JS_BLOCK_POS_BEGIN = 20;

    const JS_BLOCK_POS_END = 30;

    /**
     * @var array
     */
    protected $jsBlocks = [] ;

    /**
     * @param $blockId
     * @param int $pos
     */
    public function registerJsBlock($blockId,$pos = self::JS_BLOCK_POS_END)
    {
        $this->jsBlocks[$pos][] = $blockId ;
    }
    /**
     * Renders the content to be inserted in the head section.
     * The content is rendered using the registered meta tags, link tags, CSS/JS code blocks and files.
     * @return string the rendered content
     */
    protected function renderHeadHtml()
    {
        $lines = [];
        if (!empty($this->metaTags)) {
            $lines[] = implode("\n", $this->metaTags);
        }

        if (!empty($this->linkTags)) {
            $lines[] = implode("\n", $this->linkTags);
        }
        if (!empty($this->cssFiles)) {
            $lines[] = implode("\n", $this->cssFiles);
        }
        if (!empty($this->css)) {
            $lines[] = implode("\n", $this->css);
        }
        if (!empty($this->jsFiles[self::POS_HEAD])) {
            $lines[] = implode("\n", $this->jsFiles[self::POS_HEAD]);
        }
        /**
         * 扩展下 添加额外的块在js首尾之处
         * @see https://github.com/olado/doT/blob/master/examples/browsersample.html
         */
        if (!empty($this->js[self::POS_HEAD])) {
            if(!empty($this->jsBlocks[self::JS_BLOCK_POS_BEGIN])){
                foreach($this->jsBlocks[self::JS_BLOCK_POS_BEGIN] as $blockId){
                    $lines[] = $this->blocks[$blockId];
                }
            }
            $lines[] = Html::script(implode("\n", $this->js[self::POS_HEAD]), ['type' => 'text/javascript']);

            if(!empty($this->jsBlocks[self::JS_BLOCK_POS_END])){
                foreach($this->jsBlocks[self::JS_BLOCK_POS_END] as $blockId){
                    $lines[] = $this->blocks[$blockId];
                }
            }

        }

        return empty($lines) ? '' : implode("\n", $lines);
    }
} 