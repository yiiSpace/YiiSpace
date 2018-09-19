<?php
/**
 * Created by PhpStorm.
 * User: yiqing
 * Date: 2015/7/19
 * Time: 17:50
 */

namespace my\apidoc\helpers;

/**
 * Class PhpDoc
 * @package my\apidoc\helpers
 */
class PhpDoc {

    /**
     * FIXME 此方法应该是BaseDoc的职责 但他们没提供：namespace yii\apidoc\models\BaseDoc
     *
     * @param \phpDocumentor\Reflection\DocBlock\Tag[] $tags
     * @param string $name
     * @return null|\phpDocumentor\Reflection\DocBlock\Tag
     */
   public static  function getTag($tags,$name)
    {
        foreach ($tags as $tag) {
            if (strtolower($tag->getName()) == strtolower($name)) {
                return $tag;
            }
        }
        return null;
    }
}