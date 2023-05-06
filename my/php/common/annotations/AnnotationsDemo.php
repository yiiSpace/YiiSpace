<?php

namespace my\php\common\annotations;

use Doctrine\Common\Annotations\AnnotationReader;

/**
 * @SomeFlag
 */
class AnnotationsDemo
{
   static public function run()
    {

        $reflectionClass = new \ReflectionClass(Foo::class);
        $property = $reflectionClass->getProperty('bar');

        $reader = new AnnotationReader();
        $myAnnotation = $reader->getPropertyAnnotation(
            $property,
            MyAnnotation::class
        );

        echo $myAnnotation->myProperty; // result: "value"

        $reflectionClass = new \ReflectionClass(static::class) ;
        $annotations = $reader->getClassAnnotations($reflectionClass);

        dump($annotations) ;
        // 注意这里示范的是某个类是否有某个Annotation 代码来自：AnnotationReader::getClassAnnotation 方法参数就是一个注解类名
        foreach ($annotations as $annotation) {
            if ($annotation instanceof SomeFlag) {
               echo __CLASS__, ' has an annotation: ', SomeFlag::class ;
            }
        }

    }
}

class Foo
{
    /**
     * @MyAnnotation(myProperty="value")
     */
    private $bar;
}

/**
 * @Annotation
 */
final class MyAnnotation
{
    public $myProperty;
}
/**
 * @Annotation
 */
final class SomeFlag
{

}
/**
 * ================== namespace separator ===========================
 */
namespace  _mycompony\annotations ;


/** @Annotation */
class Bar
{
    // some code
}