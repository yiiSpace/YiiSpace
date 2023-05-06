<?php

namespace my\php\common\symfony_components;

use Symfony\Component\Finder\Finder;

class FinderDomo
{
    static public function run()
    {
        $finder = new Finder();
// find all files in the current directory
        $finder->files()->in(__DIR__);

// check if there are any search results
        if ($finder->hasResults()) {
            // ...
        }

        foreach ($finder as $file) {
            $absoluteFilePath = $file->getRealPath();
            $fileNameWithExtension = $file->getRelativePathname();

            // ...
            print_r($absoluteFilePath . PHP_EOL);
        }

        $instance = new self();
        // FIXME 好像有bug 多名空间不能分析出来
        $nameSpaces = $instance->getAllNameSpaces(__DIR__);
        echo '> namespaces in file  ', __DIR__;
        dump($nameSpaces);
    }

    /**
     * @see https://stackoverflow.com/questions/22761554/how-to-get-all-class-names-inside-a-particular-namespace
     *
     * @param $path
     * @return array
     */

    public function getAllNameSpaces($path)
    {
        $filenames = $this->getFilenames($path);
        $namespaces = [];
        foreach ($filenames as $filename) {
            $namespaces[] = $this->getFullNamespace($filename) . '\\' . $this->getClassName($filename);
        }
        return $namespaces;
    }

    private function getClassName($filename)
    {
        $directoriesAndFilename = explode('/', $filename);
        $filename = array_pop($directoriesAndFilename);
        $nameAndExtension = explode('.', $filename);
        $className = array_shift($nameAndExtension);
        return $className;
    }

    private function getFullNamespace($filename)
    {
        $lines = file($filename);
        $array = preg_grep('/^namespace /', $lines);
        $namespaceLine = array_shift($array);
        $match = [];
        preg_match('/^namespace (.*);$/', $namespaceLine, $match);
        $fullNamespace = array_pop($match);

        return $fullNamespace;
    }

    private function getFilenames($path)
    {
        $finderFiles = Finder::create()->files()->in($path)->name('*.php');
        $filenames = [];
        foreach ($finderFiles as $finderFile) {
            $filenames[] = $finderFile->getRealpath();
        }
        return $filenames;
    }

    public static function findClassesInDir($path , array $excludes = [], ?string $needle = null)
    {

//        $path = "../" . __DIR__;
        $files = scandir($path);
        $c = count($files);
        $classes = [];
        for ($i = 0; $i < $c; $i++) {
            if ($files[$i] == "." || $files[$i] == ".." || in_array($files[$i], $excludes)) {
                continue;
            }
            $class = str_replace(".php", "", $files[$i]);
            /*
            if (ucfirst($needle) == $class) {
                return $class;
            }
            */
            $classes[] = $class;
        }
        return $classes;
    }
}

namespace __test;

class Foo
{
}