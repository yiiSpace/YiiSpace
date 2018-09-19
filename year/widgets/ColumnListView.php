<?php
/**
 * Created by PhpStorm.
 * User: yiqing
 * Date: 2015/1/28
 * Time: 9:24
 */

namespace year\widgets;


use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\widgets\ListView;

class ColumnListView extends ListView
{

    public $htmlTableOptions = [

    ];
    /**
     * @var string
     */
    public $itemsTagName = 'div';
    /**
     * @var string
     */
    public $itemsCssClass = 'items';
    /**
     *
     * @var mixed integer the number of columns
     */
    public $columns = 3;

    /**
     * Renders the item view.
     * This is the main entry of the whole view rendering.
     *
     * This is override function that supports multiple columns
     */
    public function renderItems()
    {
        $numColumns = (int)$this->columns; // Number of columns
        if ($numColumns < 2) {
            return parent::renderItems();

        }
        $out = [];
        $out[] = Html::beginTag($this->itemsTagName, ['class' => $this->itemsCssClass]);
        // $models = $this->dataProvider->getModels();
        $keys = $this->dataProvider->getKeys();
        $data = $this->dataProvider->getModels();

        if (($n = count($data)) > 0) {
// Compute column width
            $width = 100 / $numColumns;
// Initialize table
            $htmlTableOptions = ArrayHelper::merge(['class' => 'ui-table'],  $this->htmlTableOptions);
            $out[] = Html::beginTag('table', $htmlTableOptions) . Html::beginTag('tr');

//$j = 0;
            foreach (array_values($data) as $i => $item) {
// Open cell
                $out[] = Html::beginTag('td', ['style' => 'width:' . $width . '%; vertical-align:top;']);

                $out[] = $this->renderItem($item, $keys[$i], $i);
// Close cell
                $out[] = Html::endTag('td');
// Change row
                if (($i + 1) % $numColumns == 0) {
                    $out[] = Html::endTag('tr') . Html::beginTag('tr');
                }
            }
// Close table
            $out[] = Html::endTag('tr') . Html::endTag('table');
        } else {
            $this->renderEmpty();
        }
        $out[] = Html::endTag($this->itemsTagName);

        return implode($this->separator, $out);
    }
}