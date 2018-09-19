<?php
/**
 * Created by PhpStorm.
 * User: yiqing
 * Date: 2015/6/15
 * Time: 12:54
 */

namespace year\helpers;

/**
 * Class ArrayHelper
 * @package year\helpers
 */
class ArrayHelper extends \yii\helpers\ArrayHelper{

    /**
     * @see http://stackoverflow.com/questions/2699086/sort-multi-dimensional-array-by-value
     *
     * @param $arr
     * @param $col
     * @param int $dir
     */
    function array_sort_by_column(&$arr, $col, $dir = SORT_ASC) {
        $sort_col = array();
        foreach ($arr as $key=> $row) {
            $sort_col[$key] = $row[$col];
        }

        array_multisort($sort_col, $dir, $arr);
    }

    /**
     * @see http://stackoverflow.com/questions/96759/how-do-i-sort-a-multidimensional-array-in-php
     *
     * usort($data, make_comparer('name'));
     *
     * 多维数组中的两列进行排序 类表结果集进行排序
     * usort($data, make_comparer(['number', SORT_DESC], ['name', SORT_DESC]));
     *
     * @return callable
     */
    function make_comparer() {
        // Normalize criteria up front so that the comparer finds everything tidy
        $criteria = func_get_args();
        foreach ($criteria as $index => $criterion) {
            $criteria[$index] = is_array($criterion)
                ? array_pad($criterion, 3, null)
                : array($criterion, SORT_ASC, null);
        }

        return function($first, $second) use (&$criteria) {
            foreach ($criteria as $criterion) {
                // How will we compare this round?
                list($column, $sortOrder, $projection) = $criterion;
                $sortOrder = $sortOrder === SORT_DESC ? -1 : 1;

                // If a projection was defined project the values now
                if ($projection) {
                    $lhs = call_user_func($projection, $first[$column]);
                    $rhs = call_user_func($projection, $second[$column]);
                }
                else {
                    $lhs = $first[$column];
                    $rhs = $second[$column];
                }

                // Do the actual comparison; do not return if equal
                if ($lhs < $rhs) {
                    return -1 * $sortOrder;
                }
                else if ($lhs > $rhs) {
                    return 1 * $sortOrder;
                }
            }

            return 0; // tiebreakers exhausted, so $first == $second
        };
    }
}