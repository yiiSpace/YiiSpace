<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 14-9-13
 * Time: 下午2:13
 */

namespace year\widgets;

use yii\helpers\Json ;
use yii\jui\Widget ;

class FormDialog extends Widget {
    /**
     * @var string
     */
    public $link = '';
    /**
     * @var array
     */
    public $options = [];
    /**
     * @var array
     */
    public $dialogOptions = [];

    public function run()
    {
        if (empty($this->options['onSuccess'])){
            $this->options['onSuccess']='js:function(data, e){alert("Success")}';
        }
        /*
        Yii::app()->clientScript->registerScriptFile(Yii::app()->assetManager->publish(Yii::getPathOfAlias('application.extensions.formDialog.formDialog').'.js'));
        $options= CJavaScript::encode($this->options);
        Yii::app()->clientScript->registerScript('FormDialog'.$this->link, "$('{$this->link}').formDialog({$options})");
        */

        $view = $this->getView();
        FormDialogAsset::register($view);

        if(!empty($this->dialogOptions)){
            $this->options['dialogOptions'] = $this->dialogOptions ;
        }

        $options = Json::encode($this->options);

        $jsInit = <<<EOD
        $(function(){

              $(document).on("click",'{$this->link}', function(e){
               e.preventDefault();
                 try {
                         $(this).formDialog({$options});
                 } catch (e) {
                         alert(e.name + ": " + e.message);
                }

               return false ;

             });
        });
EOD;

        $view->registerJs($jsInit,\yii\web\View::POS_END,__CLASS__.$this->link);


    }


} 