<?php

namespace year\helpers;

use RecursiveDirectoryIterator;
use RecursiveIteratorIterator;

/**
 * @see https://stackoverflow.com/questions/22761554/how-to-get-all-class-names-inside-a-particular-namespace
 *
 * @see https://www.php.net/manual/en/function.get-class.php
 */
class ClassHelper
{
    public static function findRecursive(string $namespace): array
    {
        $namespacePath = self::translateNamespacePath($namespace);

        if ($namespacePath === '') {
            return [];
        }

        return self::searchClasses($namespace, $namespacePath);
    }

    protected static function translateNamespacePath(string $namespace): string
    {
        /*
        $rootPath = __DIR__ . DIRECTORY_SEPARATOR;

        $nsParts = explode('\\', $namespace);
        array_shift($nsParts);

        if (empty($nsParts)) {
            return '';
        }

        return realpath($rootPath. implode(DIRECTORY_SEPARATOR, $nsParts)) ?: '';
        */
       return \Yii::getAlias('@' . str_replace('\\', '/', $namespace));
    }

    private static function searchClasses(string $namespace, string $namespacePath): array
    {
        $classes = [];

        /**
         * @var \RecursiveDirectoryIterator $iterator
         * @var \SplFileInfo $item
         */
        foreach ($iterator = new RecursiveIteratorIterator(
            new RecursiveDirectoryIterator($namespacePath, RecursiveDirectoryIterator::SKIP_DOTS),
            RecursiveIteratorIterator::SELF_FIRST
        ) as $item) {
            if ($item->isDir()) {
                $nextPath = $iterator->current()->getPathname();
                $nextNamespace = $namespace . '\\' . $item->getFilename();
                $classes = array_merge($classes, self::searchClasses($nextNamespace, $nextPath));
                continue;
            }
            if ($item->isFile() && $item->getExtension() === 'php') {
                $class = $namespace . '\\' . $item->getBasename('.php');
                if (!class_exists($class)) {
                    continue;
                }
                $classes[] = $class;
            }
        }

        return $classes;
    }
}