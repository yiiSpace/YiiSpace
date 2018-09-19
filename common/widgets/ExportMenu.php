<?php
/**
 * Created by PhpStorm.
 * User: yiqing
 * Date: 2015/4/7
 * Time: 8:53
 */

namespace common\widgets;


use yii\helpers\ArrayHelper;
use yii\helpers\Html;


use \Yii;
use \PHPExcel_Style_Fill;

/**
 * TODO  many bugs !!!
 *
 * Class ExportMenu
 * @package common\widgets
 */
class ExportMenu extends \kartik\export\ExportMenu{

    /**
     * whether enabled the pagination functionality
     *
     * @var bool
     */
    public $enablePagination = false ;

    /**
     * should be protected !
     *
     * @var array the default style configuration
     */
    private $_defaultStyleOptions = [
        self::FORMAT_EXCEL => [
            'font' => [
                'bold' => true,
                'color' => [
                    'argb' => 'FFFFFFFF',
                ],
            ],
            'fill' => [
                'type' => PHPExcel_Style_Fill::FILL_SOLID,
                'color' => [
                    'argb' => '00000000',
                ],
            ],
        ],
        self::FORMAT_EXCEL_X => [
            'font' => [
                'bold' => true,
                'color' => [
                    'argb' => 'FFFFFFFF',
                ],
            ],
            'fill' => [
                'type' => PHPExcel_Style_Fill::FILL_GRADIENT_LINEAR,
                'startcolor' => [
                    'argb' => 'FFA0A0A0',
                ],
                'endcolor' => [
                    'argb' => 'FFFFFFFF',
                ],
            ],
        ],
    ];

    /**
     * @var array the default export configuration
     */

    private $_defaultExportConfig = [];

    /**
     * Initializes export settings
     */
    public function initExport()
    {
        $this->_provider = clone($this->dataProvider);

        if(! $this->enablePagination){
            $this->_provider->pagination = $this->enablePagination;
        }

        if ($this->initProvider) {
            $this->_provider->prepare(true);
        }
        $this->styleOptions = ArrayHelper::merge($this->_defaultStyleOptions, $this->styleOptions);
        $this->filterModel = null;
        $this->setDefaultExportConfig();
        $this->exportConfig = ArrayHelper::merge($this->_defaultExportConfig, $this->exportConfig);
        if (empty($this->filename)) {
            $this->filename = Yii::t('kvexport', 'grid-export');
        }
        $target = $this->target == self::TARGET_POPUP ? 'kvExportFullDialog' : $this->target;
        $id = ArrayHelper::getValue($this->exportFormOptions, 'id', $this->options['id'] . '-form');
        Html::addCssClass($this->exportFormOptions, 'kv-export-full-form');
        $this->exportFormOptions += [
            'id' => $id,
            'target' => $target
        ];
    }
}