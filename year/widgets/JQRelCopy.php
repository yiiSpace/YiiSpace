<?php
/**
 * Created by PhpStorm.
 * User: yiqing
 * Date: 2015/1/23
 * Time: 7:01
 */

namespace year\widgets;


use yii\base\Widget;
use yii\helpers\Html;
use yii\helpers\Json;
use yii\helpers\Url;
use yii\web\View;

class JQRelCopy extends Widget{
    /**
     * The text for the remove link
     * Can be an image tag too.
     * Leave empty to disable removing.
     *
     * @var string $removeText
     */
    public $removeText;

    /**
     * The htmlOptions for the remove link
     *
     * @var array $removeHtmlOptions
     */
    public $removeHtmlOptions = array();

    /**
     * Available options
     *
     * string excludeSelector - A jQuery selector used to exclude an element and its children
     * integer limit - The number of allowed copies. Default: 0 is unlimited
     * string append - Additional HTML to attach at the end of each copy.
     * string copyClass - A class to attach to each copy
     * boolean clearInputs - Option to clear each copies text input fields or textarea
     *
     * @var array $options
     */
    public $options = array();

    /**
     * The javascript code jsBeforeClone,jsAfterClone ...
     * This allows to handle widgets on cloning.
     * Important: 'this' is the current handled jQuery object
     * For CJuiDatePicker and extension 'datetimepicker' see prepared js-code below: afterNewIdDatePicker,afterNewIdDateTimePicker
     *
     * Howto if you have a CJuiDatePicker to clone:
     * Save the config in an extra variable in the view
     *
     * $datePickerConfig =  array('name'=>'dayofbirth',
     *     'language'=>'de',
     *     'options'=>array(
     *        'showAnim'=>'fold',
     *     ));
     *
     * $this->widget('zii.widgets.jui.CJuiDatePicker',$datePickerConfig);
     *
     * //Assign the prepared javascript code to jsAfterNewId
     * $this->widget('ext.jqrelcopy.JQRelcopy',
     * array(
     *    'jsAfterNewId' => JQRelcopy::afterNewIdDateTimePicker($datepickerConfig),
     *  ...
     *
     */
    public $jsBeforeClone; // 'jsBeforeClone' => "alert(this.attr('class'));";
    public $jsAfterClone;  // 'jsAfterClone' => "alert(this.attr('class'));";
    public $jsBeforeNewId;  // 'jsBeforeNewId' => "alert(this.attr('id'));";
    public $jsAfterNewId;  // 'jsAfterNewId' => "alert(this.attr('id'));";
    public $jsPutClone;  // 'jsPutClone' => "function($clone,$parent,relSelector){}";


    /**
     * The assets url
     *
     * @var string $_assets
     */
    private $_assets;

    /**
     * Support for CJuiDatePicker
     * Set 'jsAfterNewId'=MultiModelForm::afterNewIdDateTimePicker($myFormConfig['elements']['mydate'])
     * if you use at least one datepicker.
     *
     * The options will be assigned from the config array of the element
     *
     * @param array $element
     * @return string
     */
    public static function afterNewIdDatePicker($config)
    {
        $options = isset($config['options']) ? $config['options'] : array();
        $jsOptions = Json::encode($options);

        $language = isset($config['language']) ? $config['language'] : '';
        if (!empty($language))
            $language = "jQuery.datepicker.regional['$language'],";

        return "if(this.hasClass('hasDatepicker')) {this.removeClass('hasDatepicker'); this.datepicker(jQuery.extend({showMonthAfterYear:false}, $language {$jsOptions}));};";
    }

    /**
     * Support for extension datetimepicker
     * @link http://www.yiiframework.com/extension/datetimepicker/
     *
     * @param array $element
     * @return string
     */
    public static function afterNewIdDateTimePicker($config)
    {
        $options = isset($config['options']) ? $config['options'] : array();
        $jsOptions = Json::encode($options);

        $language = isset($element['language']) ? $config['language'] : '';
        if (!empty($language))
            $language = "jQuery.datepicker.regional['$language'],";

        return "if(this.hasClass('hasDatepicker')) {this.removeClass('hasDatepicker').datetimepicker(jQuery.extend($language {$jsOptions}));};";
    }

    /**
     * Support for CJuiAutoComplete: not working - needs review
     *
     * @param array $element
     * @return
     */
    public static function afterNewIdAutoComplete($config)
    {
        $options = isset($config['options']) ? $config['options'] : array();
        if(isset($config['sourceUrl']))
            $options['source'] = Url::to($config['sourceUrl']);
        else
            $options['source'] = $config['source'];

        $jsOptions = Json::encode($options);

        return null;
        //return "this.autocomplete($jsOptions);"; //works for non-autocomplete elements
        //return "if(this.hasClass('ui-autocomplete-input')) this.autocomplete($jsOptions);";
        //return "if(this.hasClass('ui-autocomplete-input')) $('#'+this.attr('id')).autocomplete($jsOptions);";
        //return "if(this.hasClass('ui-autocomplete-input')) $('#'+this.attr('id')).autocomplete('destroy').autocomplete($jsOptions);";
        //return "if(this.hasClass('ui-autocomplete-input')) $('#'+this.attr('id')).unbind().removeClass('ui-autocomplete-input').removeAttr('autocomplete').removeAttr('role').removeAttr('aria-autocomplete').removeAttr('aria-haspopup').autocomplete($jsOptions);";
        //return "if(this.hasClass('ui-autocomplete-input')) this.unbind().removeClass('ui-autocomplete-input').removeAttr('autocomplete').removeAttr('role').removeAttr('aria-autocomplete').removeAttr('aria-haspopup').autocomplete($jsOptions);";
    }


    /**
     * Initialize the widget
     *
     * @return
     */
    public function init()
    {
        $this->_assets  = JQRelCopyAsset::register($this->view);

        if (!empty($this->removeText))
        {
            $onClick = '$(this).parent().remove(); return false;';
            $htmlOptions = array_merge($this->removeHtmlOptions,array('onclick'=>$onClick));
            $append =  Html::a($this->removeText,'#',$htmlOptions);

            $this->options['append'] = empty($this->options['append']) ? $append : $append .' '.$this->options['append'];
        }
        //-------------------------------------------------------------------------------------\\
        // callbacks
        if (!empty($this->jsBeforeClone)){
            $this->options['beforeClone'] = $this->jsBeforeClone;
        }
        if (!empty($this->jsAfterClone)){
            $this->options['afterClone'] = $this->jsAfterClone;
        }
        if (!empty($this->jsBeforeNewId)){
            $this->options['beforeNewId'] = $this->jsBeforeNewId;
        }
        if (!empty($this->jsAfterNewId)){
            $this->options['afterNewId'] = $this->jsAfterNewId;
        }
        if (!empty($this->jsPutClone)){
            $this->options['putClone'] = $this->jsPutClone;
        }
        //-------------------------------------------------------------------------------------//

        $options = Json::encode($this->options);
        $jsInit = <<<INIT
            jQuery('#{$this->id}').relCopy($options);
INIT;
        $this->view->registerJs($jsInit,View::POS_READY,__CLASS__.'#'.$this->id);

        parent::init();
    }
}