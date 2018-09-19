<?php
/**
 * User: yiqing
 * Date: 2015/1/3
 * Time: 15:23
 */

namespace year\widgets;


use yii\base\Widget;

class ArtDialog extends Widget{

      /**
     * @var bool
     */
    public $enablePlus = true ;

    public function init()
    {
        parent::init() ;
        // TODO 皮肤值的合法性检查
    }

    /**
     * @return string|void
     */
    public function run()
    {
        $asset = ArtDialogAsset::register($this->view) ;

        if($this->enablePlus){
            $asset->enableDialogPlus() ;
        }

    }
} 