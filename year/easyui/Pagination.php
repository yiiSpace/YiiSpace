<?php
/**
 * Created by PhpStorm.
 * User: yiqing
 * Date: 2015/3/25
 * Time: 0:28
 */

namespace year\easyui;

/**
 * 主要是设置下分页参数 跟默认的yii系统中的有偏差
 *
 * Class Pagination
 * @package year\easyui
 */
class Pagination extends \yii\data\Pagination{

    /**
     * @var string
     */
    public $pageParam = 'page';

    /**
     * @var string
     */
    public $pageSizeParam = 'rows';

}