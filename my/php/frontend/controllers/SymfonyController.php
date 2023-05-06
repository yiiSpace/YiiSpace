<?php

namespace my\php\frontend\controllers;

use my\php\common\symfony_components\FinderDomo;
use RecursiveDirectoryIterator;
use RecursiveIteratorIterator;
use year\helpers\ClassHelper;

class SymfonyController extends \yii\web\Controller
{

    public function actionIndex()
    {
        return $this->renderContent(
            'symfony components playground!'
        );
    }

    public function actionFinder()
    {
        return $this->renderContent(
            $this->preventHeadersAlreadySent(fn() => FinderDomo::run())
        );
    }

    public function actionClasses()
    {
        print_r(FinderDomo::findClassesInDir(__DIR__)) ;
//        $this->renderContent(
//            $this->preventHeadersAlreadySent(function () {
//
//                return    FinderDomo::findClassesInDir(__DIR__) ;
//
//            }
//            ));
    }

    public function actionControllers()
    {

        dump( ClassHelper::findRecursive(__NAMESPACE__))  ;
        exit(0);

        $classes = static::searchClasses($this->module->controllerNamespace, $this->module->getControllerPath());

        return $this->preventHeadersAlreadySent(function () use ($classes) {
            var_dump($classes);
        });
    }

    public function actionFinder2()
    {
        return $this->renderContent(
            $this->preventHeadersAlreadySent(function () {
                $finder = new \Symfony\Component\Finder\Finder;
                $iter = new \hanneskod\classtools\Iterator\ClassIterator($finder->in($this->module->getControllerPath()));

                // Print the file names of classes, interfaces and traits in 'src'
                foreach ($iter->getClassMap() as $classname => $splFileInfo) {
                    echo $classname . ': ' . $splFileInfo->getRealPath();
                }
            })
        );
    }

    /**
     * @param callable $userFunc
     * @return false|string
     *
     * Objects implementing __invoke can be used as callables
     */
    protected function preventHeadersAlreadySent(callable $userFunc)
    {
        /**
         * @see https://copyprogramming.com/howto/an-error-occurred-while-handling-another-error-yii-web-headersalreadysentexception-headers-already-sent
         *
         * Since 2.0.14 Yii does not allow to echo in the controller, you need to return response.
         * There are several similar issues on GitHub.
         *
         *  ob_start();
         * defined('STDIN') or define('STDIN', fopen('php://stdin', 'r'));
         * defined('STDOUT') or define('STDOUT', fopen('php://stdout', 'w'));
         * defined('STDERR') or define('STDERR', fopen('php://stderr', 'w'));
         * $migration = new \yii\console\controllers\MigrateController('migrate', Yii::$app);
         * $status = $migration->runAction('up', ['migrationPath' => '@app/migrations/', 'interactive' => false]);
         * fclose(\STDOUT);
         * fclose(\STDERR);
         * return ob_get_clean();
         */
        ob_start();

        $result = call_user_func($userFunc);
        if(!empty($result)) {
          return $result . ob_get_clean() ;
        }

        return  ob_get_clean();
    }


    /**
     * @see https://stackoverflow.com/questions/22761554/how-to-get-all-class-names-inside-a-particular-namespace
     *
     * @param string $namespace
     * @param string $namespacePath
     * @return array
     */
    static function searchClasses(string $namespace, string $namespacePath): array
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
