<?php

namespace my\php\common\features;

/**
 * heredoc and newdoc
 */
class HereDocDemo
{
    /**
     * @return void
     */
   static public function run()
    {
        // Valid from PHP 7.3
        echo <<<EOT
    SELECT * FROM `contacts`
        WHERE `telephone` IS NOT NULL;
    EOT;

        // Valid as of PHP 7.3 通过改动composer中的版本号借助ide 就可以看出语法是否有效
        $strings = [
            'Looney Toons', <<<EOT
    Steven Spielberg Presents Tiny Toon Adventures
    EOT, 'Animaniacs',
        ];

        // newdoc
        $foo = 'bar';
        echo <<<'EOT'
Hello $foo
Goodbye!
EOT;

    }
}