<?php
/**
 * Created by PhpStorm.
 * User: yiqing
 * Date: 2015/6/28
 * Time: 10:23
 */

namespace my\apidoc\models;


use yii\base\Object;

class ExtParamDoc extends Object {

    public $name;

    public $typeHint;

    public $isOptional;

    public $defaultValue;

    public $isPassedByReference;

    // will be set by creating class
    public $description;
    public $type;
    public $types;
    public $sourceFile;

    public function __construct($tagName = null, $content='', $config = [])
    {
        parent::__construct($config);
         /*
        $this->name = $reflector->getName();
        $this->typeHint = $reflector->getType();
        $this->isOptional = $reflector->getDefault() !== null;

        // bypass $reflector->getDefault() for short array syntax
        if ($reflector->getNode()->default) {
            $this->defaultValue = PrettyPrinter::getRepresentationOfValue($reflector->getNode()->default);
        }
        $this->isPassedByReference = $reflector->isByRef();
         */
    }

    /**
     * @param \phpDocumentor\Reflection\DocBlock\Tag[] $tags
     * @param string $tagName
     * @return array|ExtParamDoc[]
     */
    public static function extractParamDocs($tags,$tagName)
    {
        $uniTagName = strtolower($tagName) ;

        $paramDocs = [] ;

        foreach ($tags as $tag) {
            if (strtolower($tag->getName()) == $uniTagName) {
               $paramDocs[] = new static($tag->getName(),$tag->getContent());

            }
        }

        return $paramDocs ;
    }
}