<?php
/**
 * Created by PhpStorm.
 * User: yiqing
 * Date: 2015/4/2
 * Time: 10:32
 */

namespace year\widgets;


use yii\helpers\ArrayHelper;
use yii\helpers\Html;

class DetailView extends \yii\widgets\DetailView
{

    /**
     * @var string
     */
    public $template = "<th>{label}</th><td>{value}</td>";

    // public $colTemplate = "<th>{label}</th><td>{value}</td>";

    /**
     * 列属性配置 每个数组元素代表某列
     * [
     *         [
     *
     *          ],
     *          [
     *
     *          ], ...
     * ]
     *
     *
     * @var array
     */
    public $columnAttributes =  [];

    /**
     * 这里对属性列进行索引 记录其对应的索引位置
     *
     * @var array
     */
    protected $colIndexAttributes = [];


    /**
     * @throws \yii\base\InvalidConfigException
     */
    public function init()
    {
        // 这里做预处理！
        if(empty($this->attributes)){
            $this->attributes = [] ;
            if(!empty($this->columnAttributes)){
                $colIdx = 0 ;
                foreach($this->columnAttributes as $colAttributes){
                    $this->attributes = array_merge($this->attributes,$colAttributes);

                     $colAttributesCount = count($colAttributes);
                     $this->colIndexAttributes[] = range($colIdx,($colIdx + $colAttributesCount)-1);
                     $colIdx = $colIdx + $colAttributesCount ;
               }
            }
        }
        parent::init();
    }

    public function run()
    {

        $rows = [];
        $i = 0;

        $attributeContents = $attributeIndexContents = [];
        foreach ($this->attributes as $idx => $attribute) {
            if (isset($attribute['attribute'])) {
                $attrName = $attribute['attribute'];
                $attributeContents[$attrName] = $this->renderAttribute($attribute, $i++);
            }
            // 防止没有提供attribute属性 用索引做键
            $attributeIndexContents[$idx] = $this->renderAttribute($attribute, $i++);

        }

        if (empty($this->colIndexAttributes)) {
            // $rowCnt = count($attributeContents) ;
            foreach ($attributeContents as $attr => $content) {
                $rows[] = '<tr>' . $content . '</tr>';
            }

        } else {
            $rowCnt = max(array_map(function ($item) {
                return count($item);
            }, $this->colIndexAttributes));

            for ($rowIndex = 0; $rowIndex < $rowCnt; $rowIndex++) {
                $row = [];
                foreach ($this->colIndexAttributes as $colIndexAttributes) {
                    if (isset($colIndexAttributes[$rowIndex])) {

                        $attrNameOrIndex = $colIndexAttributes[$rowIndex];
                        $row[] = isset($attributeContents[$attrNameOrIndex])
                            ? $attributeContents[$attrNameOrIndex]
                            : $attributeIndexContents[$attrNameOrIndex];

                    } else {

                        // $row[] = '';  // 把位占住 如果用空串 位置就跑偏了！
                        // todo 当模板切换为<td></td><td></td> 时这里就需要换了 暴露到外面去！
                        $row[] =   '<th></th><td></td>';
                    }
                }
                $rows[] = '<tr>' . implode("\n", $row) . '</tr>';
            }
        }


        $tag = ArrayHelper::remove($this->options, 'tag', 'table');
        echo Html::tag($tag, implode("\n", $rows), $this->options);
    }

}