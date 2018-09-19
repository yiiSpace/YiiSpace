<?php
/**
 * Created by PhpStorm.
 * User: yiqing
 * Date: 2015/5/23
 * Time: 7:52
 */

namespace year\bootstrap;


use yii\bootstrap\Widget;

class BootstrapWizard extends Widget{

    /**
     * Registers a specific Bootstrap plugin and the related events
     * @param string $name the name of the Bootstrap plugin
     */
    protected function registerPlugin($name)
    {
        // ignore the $name param and specify our owner name
         $name = 'bootstrapWizard';

        $view = $this->getView();

        // bootstrapWizard is not the core bootstrap plugin
       // BootstrapPluginAsset::register($view);
        BootstrapWizardAsset::register($view) ;

        $id = $this->options['id'];

        if ($this->clientOptions !== false) {
            $options = empty($this->clientOptions) ? '' : Json::encode($this->clientOptions);
            $js = "jQuery('#$id').$name($options);";
            $view->registerJs($js);
        }

        $this->registerClientEvents();
    }
}