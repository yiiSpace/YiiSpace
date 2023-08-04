<?php

namespace year\gii\common\utils {

    use MyParser\Visitor;
    use TypeScript\Property_;

    use PhpParser;
    use PhpParser\Error;
    use PhpParser\NodeDumper;
    use PhpParser\ParserFactory;


    class TsParser
    {
        public static  function run($phpCode='')
        {
            $p = new Property_('some_prop', 'string');
            // $parser = new PhpParser\Parser(new PhpParser\Lexer\Emulative);
            $parser = (new ParserFactory)->create(ParserFactory::PREFER_PHP7);

            $traverser = new PhpParser\NodeTraverser;
            $visitor = new Visitor;
            $traverser->addVisitor($visitor);

            try {
                // @todo Get files from a folder recursively
                //$code = file_get_contents($fileName);

                $code = <<<'CODE'
    <?php
    /**
     * @TypeScriptMe
     */
    class Person
    {
        /**
         * @var string
         */
        public $name;
    
        /**
         * @var int
         */
        public $age;
    
        /**
         * @var \stdClass
         */
        public $mixed;
    
        /**
         * @var string
         */
        private $propertyIsPrivateItWontShow;
    }
    
    class IgnoreMe {
    
        public function test() {
    
        }
    }
    CODE;

                // parse
                // $stmts = $parser->parse($code);
                $stmts = $parser->parse($phpCode);

                // traverse
                $stmts = $traverser->traverse($stmts);

                // echo "<pre><code>" . $visitor->getOutput() . "</code></pre>";
                echo  $visitor->getOutput();
                
            } catch (PhpParser\Error $e) {
                echo 'Parse Error: ', $e->getMessage();
                // print_r($e) ;
            }
        }
    }
}

namespace TypeScript {


    class Property_
    {
        /** @var string */
        public $name;
        /** @var string */
        public $type;

        public function __construct($name, $type = "any")
        {
            $this->name = $name;
            $this->type = $type;
        }

        public function __toString()
        {
            return "{$this->name}: {$this->type}";
        }
    }

    class Interface_
    {
        /** @var string */
        public $name;
        /** @var Property_[] */
        public $properties = [];

        public function __construct($name)
        {
            $this->name = $name;
        }

        public function __toString()
        {
            $result = "interface {$this->name} {\n";
            $result .= implode(",\n", array_map(function ($p) {
                return "  " . (string)$p;
            }, $this->properties));
            $result .= "\n}";
            return $result;
        }
    }
}

namespace MyParser {

    ini_set('display_errors', 1);
    // require __DIR__ . "/vendor/autoload.php";

    use PhpParser;
    use PhpParser\Node;
    use TypeScript;

    class Visitor extends PhpParser\NodeVisitorAbstract
    {
        private $isActive = false;

        /** @var TypeScript/Interface_[] */
        private $output = [];

        /** @var TypeScript\Interface_ */
        private $currentInterface;

        public function enterNode(Node $node)
        {
            if ($node instanceof PhpParser\Node\Stmt\Class_) {

                /** @var PhpParser\Node\Stmt\Class_ $class */
                $class = $node;
                // If there is "@TypeScriptMe" in the class phpDoc, then ...
                if ($class->getDocComment() && strpos($class->getDocComment()->getText(), "@TypeScriptMe") !== false) {
                    $this->isActive = true;
                    $this->output[] = $this->currentInterface = new TypeScript\Interface_($class->name);
                }
            }

            if ($this->isActive) {
                if ($node instanceof PhpParser\Node\Stmt\Property) {
                    /** @var PhpParser\Node\Stmt\Property $property */
                    $property = $node;

                    if ($property->isPublic()) {
                        $type = $this->parsePhpDocForProperty($property->getDocComment());
                        $this->currentInterface->properties[] = new TypeScript\Property_($property->props[0]->name, $type);
                    }
                }
            }
        }

        public function leaveNode(Node $node)
        {
            if ($node instanceof PhpParser\Node\Stmt\Class_) {
                $this->isActive = false;
            }
        }

        /**
         * @param \PhpParser\Comment|null $phpDoc
         */
        private function parsePhpDocForProperty($phpDoc)
        {
            $result = "any";

            if ($phpDoc !== null) {
                if (preg_match('/@var[ \t]+([a-z0-9]+)/i', $phpDoc->getText(), $matches)) {
                    $t = trim(strtolower($matches[1]));

                    if ($t === "int") {
                        $result = "number";
                    } elseif ($t === "string") {
                        $result = "string";
                    }
                }
            }

            return $result;
        }

        public function getOutput()
        {
            return implode("\n\n", array_map(function ($i) {
                return (string)$i;
            }, $this->output));
        }
    }
}
