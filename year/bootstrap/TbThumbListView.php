<?php
/**
 * User: yiqing
 * Date: 14-9-13
 * Time: 下午7:30
 */

namespace year\bootstrap;

use yii\widgets\ListView;

class TbThumbListView extends ListView
{

    /**
     * @var int
     */
    public $col = 4;

    /**
     * Renders all data models.
     * @return string the rendering result
     */
    public function renderItems()
    {
        $models = $this->dataProvider->getModels();
        $keys = $this->dataProvider->getKeys();
        $rows = [];

        $modelCount = count($models);
        $rowBegin = '<div class="row">';
        $rowEnd = '</div>';

        $rows[] = $rowBegin;
        $colStep = 12 / $this->col;
        foreach (array_values($models) as $index => $model) {

            $rows[] = sprintf('<div class="col-sm-%s col-md-%s">', $colStep + 2, $colStep);
            $rows[] = $this->renderItem($model, $keys[$index], $index);
            $rows[] = '</div>';

            if (($index + 1) % $this->col == 0) {
                $rows[] = $rowEnd;
                if ($index + 1 != $modelCount) {
                    $rows[] = $rowBegin;
                }
            }
        }

        return implode($this->separator, $rows);
    }

} 