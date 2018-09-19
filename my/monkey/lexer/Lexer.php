<?php
/**
 * Created by PhpStorm.
 * User: yiqing
 * Date: 2017/9/28
 * Time: 11:54
 */

namespace monkey\lexer;


use monkey\token\Token;
use monkey\token\TokenType;
use yii\base\Exception;

class Lexer
{

    /**
     * @var array
     */
    public static $oneCharTokens = [
        '=' => TokenType::ASSIGN,
        '+' => TokenType::PLUS,
        '-' => TokenType::MINUS,
        '!' => TokenType::BANG,
        '*' => TokenType::ASTERISK,
        '/' => TokenType::SLASH,
        '<' => TokenType::LT,
        '>' => TokenType::GT,
        //  Delimiters,
        ',' => TokenType::COMMA,
        '(' => TokenType::LPAREN,
        ')' => TokenType::RPAREN,
        '{' => TokenType::LBRACE,
        '}' => TokenType::RBRACE,
    ];

    /**
     *
     * @param string $input
     * @return Lexer
     */
    public static function NewLexer($input = '')
    {
        $lexer = new Lexer();
        $lexer->input = $input;

        $lexer->readChar();

        return $lexer;
    }

    /**
     * @var string
     */
    protected $input = '';
    /**
     * current position in input (points to current char)
     * @var int
     */
    protected $position = 0;

    /**
     * current reading position in input (after current char)
     * @var int
     */
    protected $readPosition = 0;
    /**
     * current char under examination
     *
     * @var int|byte  php没有byte
     *   - ord()  函数返回字符串第一个字符的 ASCII 值
     *   - chr()  函数从指定的 ASCII 值返回字符。 这个函数正好和ord相反
     */
    protected $ch = 0;

    /**
     * @TODO 目前只支持 ASCII 字符
     */
    protected function readChar()
    {
        // mb_substr()
        if ($this->readPosition >= strlen($this->input)) {
            // 0, which is the ASCII code for the "NUL"
            $this->ch = 0;

            // die('over：'.$this->ch);
        } else {
            $this->ch = $this->input[$this->readPosition]; // 需要做 ord() ???
        }

        $this->position = $this->readPosition;
        $this->readPosition += 1;
    }

    public function NextToken(): Token
    {
        /** @var Token $tok */
        $tok = null;

        $this->skipWitespace();
        /*
        var_dump(in_array(',',static::$oneCharTokens)) ;
        $tok = $this->newToken(static::$oneCharTokens[','],',');
        var_dump($tok);
        print_r(array_keys(static::$oneCharTokens)) ; die(__METHOD__) ;


        // print_r($this->ch ." -------------------") ;
        // switch case  有个致命的问题 比较使用的是 == :  if( 0 == 'anything'){  die("oh ! no!!!");  }
        /**
         * 改写结构：
         * $mixed = 0;
         * switch(TRUE){
         * case (NULL===$mixed): //blah break;
         * case (0   ===$mixed): //etc. break;
         * }
         */
        switch (true) {
            case '=' === $this->ch:
                if ($this->peekChar() == '=') {
                    $ch = $this->ch;
                    $this->readChar();
                    $tok = new Token();
                    $tok->Type = TokenType::EQ;
                    $tok->Literal = $ch . $this->ch;
                } else {
                    $tok = $this->newToken(TokenType::ASSIGN, $this->ch);
                }

                break;
            case '+' === $this->ch:
                $tok = $this->newToken(TokenType::PLUS, $this->ch);
                break;
            case '-' === $this->ch:
                $tok = $this->newToken(TokenType::MINUS, $this->ch);
                break;
            case '!' === $this->ch:
                if ($this->peekChar() == '=') {
                    $ch = $this->ch;
                    $this->readChar();
                    $tok = new Token();
                    $tok->Type = TokenType::NOT_EQ;
                    $tok->Literal = $ch . $this->ch;
                } else {
                    $tok = $this->newToken(TokenType::BANG, $this->ch);
                }

                break;
            case '/' === $this->ch:
                $tok = $this->newToken(TokenType::SLASH, $this->ch);
                break;
            case '*' === $this->ch:
                $tok = $this->newToken(TokenType::ASTERISK, $this->ch);
                break;
            case '<' === $this->ch:
                $tok = $this->newToken(TokenType::LT, $this->ch);
                break;
            case '>' === $this->ch:
                $tok = $this->newToken(TokenType::GT, $this->ch);
                break;

            case ';' === $this->ch:
                $tok = $this->newToken(TokenType::SEMICOLON, $this->ch);
                break;
            case ',' === $this->ch:
                $tok = $this->newToken(TokenType::COMMA, $this->ch);
                break;

            case '(' === $this->ch:
                $tok = $this->newToken(TokenType::LPAREN, $this->ch);
                break;

            case ')' === $this->ch:
                $tok = $this->newToken(TokenType::RPAREN, $this->ch);
                break;

            case '{' === $this->ch:
                $tok = $this->newToken(TokenType::LBRACE, $this->ch);
                break;

            case '}' === $this->ch:
                $tok = $this->newToken(TokenType::RBRACE, $this->ch);
                break;
            case '[' === $this->ch:
                $tok = $this->newToken(TokenType::LBRAKET, $this->ch);
                break;
            case ']' === $this->ch:
                $tok = $this->newToken(TokenType::RBRAKET, $this->ch);
                break;
            case ':' === $this->ch:
                $tok = $this->newToken(TokenType::COLON, $this->ch);
                break;

            case '"' === $this->ch:
                $tok = new Token();
                $tok->Type = TokenType::STRING;
                $tok->Literal = $this->readString();
                break;
            /*
       case in_array($this->ch, array_keys(static::$oneCharTokens),true) === true:

         $tok = $this->newToken(static::$oneCharTokens[$this->ch],$this->ch);
         // var_dump($tok) ; die('wy');
         break ; */

            case 0 === $this->ch :
                // default:
                $tok = $this->newToken(TokenType::EOF, "");
                break;

            default:
                if ($this->isLetter($this->ch)) {
                    // $tok->Literal = $this->readIdentifier();
                    $literal = $this->readIdentifier();
                    $tok = new Token(); // $this->newToken(TokenType::LookupIdent($literal),$literal) ;
                    $tok->Literal = $literal;
                    $tok->Type = TokenType::LookupIdent($literal);
                    return $tok; // 一定要return哦！
                } elseif ($this->isDigit($this->ch)) {
                    $tok = new Token();
                    $tok->Type = TokenType::INT;
                    $tok->Literal = $this->readNumber();
//                   die($tok->Literal) ;
                    return $tok; //  一定要return 哦！
                } else {
                    $tok = $this->newToken(TokenType::ILLEGAL, $this->ch);
                }
        }
        $this->readChar();
        return $tok;

    }

    /**
     * @param string $tokenType
     * @param int $ch
     * @return Token
     */
    protected function newToken(string $tokenType, $ch): Token
    {
        $tok = new Token();
        $tok->Type = $tokenType;
        $tok->Literal = $ch;  // TODO 这里要做字节到字符的转换


        return $tok;
    }

    /**
     *
     */
    protected function skipWitespace()
    {
        // echo '<<< enter ',__METHOD__  ,PHP_EOL ;
        // $ch = $this->ch;
        $whitspacePattern = '~\R|\s~'; // '/^\s+$/'; // '// ^\s*$/'
        while (preg_match($whitspacePattern, $this->ch) == 1) {
            $this->readChar();
            // $ch = $this->ch ;
        }
        /*
        while (in_array($ch,[' ','\t', '\n','\r'])){
            $this->readChar() ;
        }
        */
        /*
        $ch = ord($this->ch);
        for (;
            $ch === ord(' ') || $ch === ord('\t') || $ch === ord('\n') || $ch === ord('\r')
        ;) {
            echo 'read', $ch ;
            $this->readChar();
        }
        */

    }

    /**
     * @return int|string
     */
    protected function peekChar()
    {
        if ($this->readPosition >= strlen($this->input)) {
            return 0;
        }
        return $this->input[$this->readPosition];
    }

    protected function readString()
    {
        $position = $this->position + 1;
        for (; true;) {
            $this->readChar();
            if ($this->ch == '"') {
                break;
            }
        }
        return substr($this->input, $position, $this->position - $position);
    }

    /**
     * @return string
     */
    protected function readNumber(): string
    {
        $position = $this->position;
        for (; $this->isDigit($this->ch);) {
            $this->readChar();
        }
        // die(__METHOD__) ;
        return /*mb_substr*/
            substr($this->input, $position, $this->position - $position);
    }

    /**
     * @TODO 未支持浮点数
     *
     * 判断字符是否是数字
     *
     * @param string|int $ch 注意ch为0时代表结束  不可做数字判断
     * @return bool
     */
    protected function isDigit($ch): bool
    {
        return is_numeric($ch) && $ch !== 0;
        // return preg_match('@^\d$@',$ch) === 1 ;
        /*
        $ch = ord($ch);
        return ord('0') <= $ch && $ch <= ord('9');
        */
    }

    /**
     * @return string
     */
    protected function readIdentifier(): string
    {
        $position = $this->position;
        for (; $this->isLetter($this->ch);) {
            $this->readChar();
        }
        return /*mb_substr*/
            substr($this->input, $position, $this->position - $position);
    }

    /**
     * @param string|int $ch
     * @return bool
     */
    protected function isLetter($ch): bool
    {
        // return preg_match('@[a-zA-Z_]@',$ch) == 1 ;
        $ch = ord($ch);
        return ord('a') <= $ch && $ch <= ord('z')
            || ord('A') <= $ch && $ch <= ord('Z')
            || $ch == ord('_');

        /**
         * function is_alnumspace($str){
         *       return preg_match('/^[a-z0-9 ]+$/i',$str);
         * }
         */

    }
}