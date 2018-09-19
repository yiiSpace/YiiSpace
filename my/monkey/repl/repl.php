<?php
/**
 * Created by PhpStorm.
 * User: yiqing
 * Date: 2017/9/27
 * Time: 0:09
 */

namespace monkey\repl;

use monkey\evaluator\Evaluator;
use monkey\helpers\ObjectStats;
use monkey\object\Environment;
use monkey\parser\Parser;
use monkey\token\TokenType;
use yii\helpers\Console;


const PROMPT = ">> ";

// @see https://www.ascii-code.com/ascii-art/animals/monkeys.php
const MONKEY_FACE = <<<EOD
                    ',
           .-`-,\__
              ."`   `,
            .'_.  ._  `;.
        __ / `      `  `.\ .--.
       /--,| 0)   0)     )`_.-,)
      |    ;.-----.__ _-');   /
       '--./         `.`/  `"`
          :   '`      |.      
          | \     /  //         
           \ '---'  /'        
            `------' \  
             _/       `--...
EOD;

/**
 * @param $in
 * @param $out
 */
function Start($in /*io.Reader*/, $out /*io.Writer*/)
{
    $env = Environment::NewEnvironment() ;
    // print(__FUNCTION__) ;
    for (; true;) {
        Console::stdout(PROMPT);
        $line = trim(Console::stdin());

        // 穿插下额外逻辑
        if ($line == 'object::stats') {
            // Console::output('hiiiiiiiiiiiii');
            // 打印对象统计信息
            ObjectStats::printObjectStats() ;

            continue;
        }

        $line .= PHP_EOL;
        $l = \monkey\lexer\Lexer::NewLexer($line);
        /*
        for($tok = $l->NextToken(); $tok->Type != TokenType::EOF; $tok = $l->NextToken()){
            printf("{ Type:%s Literal:%s } \n",$tok->Type, $tok->Literal) ;
        }
        */
        $p = Parser::NewParser($l);
        $program = $p->ParseProgram();
        if (count($p->Errors()) != 0) {
            printParserErrors($p->Errors());
            continue;
        }
        // Console::stdout($program->String());

        $evaluated = Evaluator::DoEval($program ,$env);
        if ($evaluated != null) {
            Console::output($evaluated->Inspect());
        }

        Console::stdout("\n");
    }

    /*
    scanner := bufio.NewScanner(in)
	env := object.NewEnvironment()

	for {
        fmt.Printf(PROMPT)
		scanned := scanner.Scan()
		if !scanned {
            return
		}

		line := scanner.Text()
		l := lexer.New(line)
		p := parser.New(l)

		program := p.ParseProgram()
		if len(p.Errors()) != 0 {
            printParserErrors(out, p.Errors())
			continue
		}

		evaluated := evaluator.Eval(program, env)

		if evaluated != nil {
            io.WriteString(out, evaluated.Inspect())
			io.WriteString(out, "\n")
		}
	}
    */
}

/**
 * @param $out
 * @param $errors
 */
function printParserErrors(/*$out io.Writer,*/
    $errors  /*string[]*/)
{
    $out = '';
    $out .= MONKEY_FACE;
    $out .= "\n Woops! We ran into some monkye business here!\n";
    $out .= "  parser errors:\n";

    $errors = array_map(function ($error) {
        return "\t" . $error . "\n";
    }, $errors);
    $out .= join('', $errors);
    echo $out;
    /*
    io.WriteString(out, MONKEY_FACE)
	io.WriteString(out, "Woops! We ran into some monkye business here!\n")
	io.WriteString(out, "  parser errors:\n")

	for _, msg := range errors {
        io.WriteString(out, "\t"+msg+"\n")
	}
    */
}