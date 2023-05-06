<?php

namespace my\php\common\reflections;


use Roave\BetterReflection\BetterReflection;
use Roave\BetterReflection\Reflector\DefaultReflector;
use Roave\BetterReflection\SourceLocator\Type\SingleFileSourceLocator;


/**
 * @see https://stackoverflow.com/questions/928928/determining-what-classes-are-defined-in-a-php-class-file
 *
 * @see https://github.com/nette/reflection
 *  Nette\Reflection is public archived!
 */
class BetterReflectionDemo
{
    /**
     * @param string|null $classFile
     * @return array
     */
    public static function run(?string $classFile = null)
    {
        if(empty($classFile)) $classFile = __FILE__ ;

        $astLocator = (new BetterReflection())->astLocator();
        $reflector = new DefaultReflector(new SingleFileSourceLocator($classFile, $astLocator));
        $classes = $reflector->reflectAllClasses();

        $classNames = [];
        foreach ($classes as $class) {
            $classNames[] = $class->getName();
        }

        return $classNames;
    }

    public static function classInfo($class = __CLASS__)
    {
        if(empty($class)) $class = static::class ;

        $classInfo = (new BetterReflection())
            ->reflector()
            ->reflectClass($class);

        dump($classInfo) ;
    }
}