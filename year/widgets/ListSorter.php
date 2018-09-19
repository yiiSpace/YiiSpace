<?php
/**
 * Created by PhpStorm.
 * User: yiqing
 * Date: 2015/4/9
 * Time: 10:15
 */

namespace year\widgets;



use Yii;
use yii\base\InvalidConfigException;
use yii\base\Widget;
use yii\data\Sort;
use yii\helpers\Html;

/**
 * TODO not completed！
 *
 * usage :
 * - standalone
        <?php echo \year\widgets\ListSorter::widget([
            'sort' => $dataProvider->getSort(),
            'view' => $this,
        ])
        ?>
 * - same as LinkSorter
 *
 * Class ListSorter
 * @package year\widgets
 */
class ListSorter   extends Widget
{
    /**
     * @var string label of dropdown button
     */
    public $label;
    /**
     * @var Sort the sort definition
     */
    public $sort;
    /**
     * @var array list of the attributes that support sorting. If not set, it will be determined
     * using [[Sort::attributes]].
     */
    public $attributes;
    /**
     * @var array HTML attributes for the sorter container tag.
     * @see \yii\helpers\Html::ul() for special attributes.
     * @see \yii\helpers\Html::renderTagAttributes() for details on how attributes are being rendered.
     */
    public $options = ['class' => 'sorter'];


    /**
     * Initializes the sorter.
     */
    public function init()
{
    if ($this->sort === null) {
        throw new InvalidConfigException('The "sort" property must be set.');
    }
}

    /**
     * Executes the widget.
     * This method renders the sort links.
     */
    public function run()
{
    echo $this->renderSortLinks();
}

    /**
     * Renders the sort links.
     * @return string the rendering result
     */
    protected function renderSortLinks()
{
    $attributes = empty($this->attributes) ? array_keys($this->sort->attributes) : $this->attributes;
    $links = [];
    foreach ($attributes as $name) {
        $links[] = $this->sort->link($name);
    }

    if(empty($this->label)){
        $this->label = 'sort by ';
    }
    // TODO 现在两个选择 1. 用js监听change事件 触发页面跳转。2. 自己hack UI 让链接可以以下拉式显示 类似菜单实现
    // do not need encode the link
    // $this->options['encode'] = false ;
    return Html::dropDownList($this->label,null,$links,$this->options);
    // return Html::ul($links, array_merge($this->options, ['encode' => false]));
}
}