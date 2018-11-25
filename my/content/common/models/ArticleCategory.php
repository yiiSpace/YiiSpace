<?php

namespace my\content\common\models;

use Yii;
use \my\content\common\models\base\ArticleCategory as BaseArticleCategory;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "content_article_category".
 */
class ArticleCategory extends BaseArticleCategory
{

    public function behaviors()
    {
        return ArrayHelper::merge(
            parent::behaviors(),
            [
                # custom behaviors

            ]
        );
    }

    public function rules()
    {
        return ArrayHelper::merge(
            parent::rules(),
            [
                # custom validation rules
                ['display_order','default','value'=>0],
                [['mbr_count','page_size'],'default','value'=>0],
                [['status' ,],'default','value'=>1],
            ]
        );
    }

    /**
     * 选择父级分类时 需要的  id  =>  cate_name
     *
     * @return array
     */
    public static function getCategoryTreeOptions()
    {
        /*
        // 先加载顶级节点
        $topLevelNodes = self::find()->where([
           'parent_id'=>0
        ])->indexBy('id')->all();
        $topLevelNodeIds = array_keys($topLevelNodes);
        // print_r($topLevelNodeIds);

        $childrenNodes = self::find()->where(
           [ 'parent_id'=>$parentIds ]
        )->indexBy('id')->all() ;
        */

        $allNodes = self::find()->asArray()->all();

        $new = array();
        foreach ($allNodes as $a) {
            $new[$a['parent_id']][] = $a;
        }
        $tree = self::createTree($new, $new[0]); // changed
        // print_r($tree);

        //$tree = self::treeze($allNodes,'parent_id','children');
        $cateIdNameMap = [];
        self::traverseTree($tree, $cateIdNameMap, 1);

        return (['0'=>'顶级分类']+$cateIdNameMap);
        // return $resultArr ;
    }


    /**
     * @param array $treeArray
     * @param array $resultArray
     * @param int $level
     */
    public static function traverseTree(&$treeArray = [], &$resultArray = [], $level = 1)
    {
        foreach ($treeArray as $node) {
            $resultArray[$node['id']] = '|-' . str_repeat('---', $level) . $node['name'];
            if (!empty($node['children'])) {
                $level += 1;
                self::traverseTree($node['children'], $resultArray, $level);
                $level -= 1;
            }
        }
    }

    /**
     * http://stackoverflow.com/questions/4196157/create-array-tree-from-array-list
     *
     * @param $list
     * @param $parent
     * @return array
     */
    public static function createTree(&$list, $parent)
    {
        $tree = array();
        if(!empty($parent))foreach ($parent as $k => $l) {
            if (isset($list[$l['id']])) {
                $l['children'] = self::createTree($list, $list[$l['id']]);
            }
            $tree[] = $l;
        }
        return $tree;
    }


    /**
     * @param $a
     * @param $parent_key
     * @param $children_key
     */
    public static function treeze(&$a, $parent_key, $children_key)
    {
        $orphans = true;
        //  $i;
        while ($orphans) {
            $orphans = false;
            foreach ($a as $k => $v) {
                // is there $a[$k] sons?
                $sons = false;
                foreach ($a as $x => $y) if ($y[$parent_key] != false and $y[$parent_key] == $k) {
                    $sons = true;
                    $orphans = true;
                    break;
                }
                // $a[$k] is a son, without children, so i can move it
                if (!$sons and $v[$parent_key] != false) {
                    $a[$v[$parent_key]][$children_key][$k] = $v;
                    unset($a[$k]);
                }
            }
        }
    }
}
