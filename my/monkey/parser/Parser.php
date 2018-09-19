<?php
/**
 * Created by PhpStorm.
 * User: yiqing
 * Date: 2017/9/29
 * Time: 15:12
 */

namespace monkey\parser;


use monkey\ast\BlockStatement;
use monkey\ast\Boolean;
use monkey\ast\CallExpression;
use monkey\ast\Expression;
use monkey\ast\ExpressionStatement;
use monkey\ast\FunctionLiteral;
use monkey\ast\Identifier;
use monkey\ast\IfExpression;
use monkey\ast\InfixExpression;
use monkey\ast\IntegerLiteral;
use monkey\ast\LetStatement;
use monkey\ast\PrefixExpression;
use monkey\ast\Program;
use monkey\ast\ReturnStatement;
use monkey\ast\Statement;
use monkey\lexer\Lexer;
use monkey\token\Token;
use monkey\token\TokenType;

class Parser
{

    const LOWEST = 1;
    const EQUALS = 2;  // ==
    const LESSGREATER = 3; // > or <
    const SUM = 4; // +
    const PRODUCT = 5; // *
    const PREFIX = 6; // -X or !X
    const CALL = 7; // myFunction(X)

    /**
     * 优先级表
     *
     * @var array
     */
    protected static $precedences = [
        TokenType::EQ => self::EQUALS,
        TokenType::NOT_EQ => self::EQUALS,
        TokenType::LT => self:: LESSGREATER,
        TokenType::GT => self::LESSGREATER,
        TokenType::PLUS => self::SUM,
        TokenType::MINUS => self::SUM,
        TokenType::SLASH => self::PRODUCT,
        TokenType::ASTERISK => self::PRODUCT,

        TokenType::LPAREN => self::CALL,
    ];

    /**
     * @return int
     */
    protected function peekPrecedence(): int
    {
        $p = self::$precedences[$this->peekToken->Type] ?? self::LOWEST;
        return $p;
    }

    /**
     * @return int
     */
    protected function curPrecedence(): int
    {
        return self::$precedences[$this->curToken->Type] ?? self::LOWEST;
    }

    /**
     * @var Lexer
     */
    public $L;

    /**
     * @var Token
     */
    protected $curToken;

    /**
     * @var Token
     */
    protected $peekToken;

    /**
     * @var array|string[]
     */
    protected $errors = [];

    /**
     * type (
     * prefixParseFn func() ast.Expression
     * infixParseFn func(ast.Expression) ast.Expression
     * )
     */
    /**
     * map[token.TokenType]prefixParseFn
     *
     * @var array
     */
    protected $prefixParseFns = [];
    /**
     * map[token.TokenType]infixParseFn
     *
     * @var array
     */
    protected $infixParseFns = [];

    /**
     * @param $tokenType
     * @param $fn
     */
    protected function registerPrefix($tokenType, $fn)
    {
        $this->prefixParseFns[$tokenType] = $fn;
    }

    protected function registerInfix($tokenType, $fn)
    {
        $this->infixParseFns[$tokenType] = $fn;
    }

    /**
     * @param string $tokenType
     */
    protected function noPrefixParseFnError($tokenType)
    {
        $msg = sprintf("no prefix parse function for %s found", $tokenType);
        $this->errors[] = $msg;
    }

    /**
     * @param Lexer $l
     * @return Parser
     */
    public static function NewParser(Lexer $l): Parser
    {
        $p = new static();
        $p->L = $l;

        $p->registerPrefix(TokenType::IDENT, [$p, 'parseIdentifier']);
        $p->registerPrefix(TokenType::INT, [$p, 'parseIntegerLiteral']);

        $p->registerPrefix(TokenType::BANG, [$p, 'parsePrefixExpression']);
        $p->registerPrefix(TokenType::MINUS, [$p, 'parsePrefixExpression']);


        $p->registerPrefix(TokenType::TRUE, [$p, 'parseBoolean']);
        $p->registerPrefix(TokenType::FALSE, [$p, 'parseBoolean']);

        $p->registerPrefix(TokenType::LPAREN, [$p, 'parseGroupedExpression']);
        $p->registerPrefix(TokenType::IF, [$p, 'parseIfExpression']);
        $p->registerPrefix(TokenType::FUNCTION, [$p, 'parseFunctionLiteral']);

        $p->registerInfix(TokenType::PLUS, [$p, 'parseInfixExpression']);
        $p->registerInfix(TokenType::MINUS, [$p, 'parseInfixExpression']);
        $p->registerInfix(TokenType::SLASH, [$p, 'parseInfixExpression']);
        $p->registerInfix(TokenType::ASTERISK, [$p, 'parseInfixExpression']);
        $p->registerInfix(TokenType::EQ, [$p, 'parseInfixExpression']);
        $p->registerInfix(TokenType::NOT_EQ, [$p, 'parseInfixExpression']);
        $p->registerInfix(TokenType::LT, [$p, 'parseInfixExpression']);
        $p->registerInfix(TokenType::GT, [$p, 'parseInfixExpression']);

        $p->registerInfix(TokenType::LPAREN, [$p, 'parseCallExpression']);


        $p->nextToken();
        $p->nextToken();
        return $p;
    }

    /**
     *
     */
    protected function nextToken()
    {
        $this->curToken = $this->peekToken;
        $this->peekToken = $this->L->NextToken();

    }

    /**
     * @return Program
     */
    public function ParseProgram(): Program
    {
        $program = new Program();
        $program->Statements = [];

        for (; $this->curToken->Type != TokenType::EOF;) {
            $stmt = $this->parseStatement();
            if ($stmt) {
                // array_push($program->Statements,$stmt) ;
                $program->Statements[] = $stmt;
            }
            $this->nextToken();
        }
        return $program;
    }

    /**
     * @return Statement|null
     */
    protected function parseStatement() /* :?Statement */
    {
        switch ($this->curToken->Type) {
            case TokenType::LET :
                return $this->parseLetStatement();
            case TokenType::RETURN :
                return $this->parseReturnStatement();
            default:
                return $this->parseExpressionStatement();
        }
    }

    /**
     * @return Expression
     */
    protected function parseIdentifier()
    {
        return Identifier::CreateWith([
            'Token' => $this->curToken,
            'Value' => $this->curToken->Literal,
        ]);
    }

    /**
     * @return Expression
     */
    protected function parseBoolean() // :Expression
    {
        return Boolean::CreateWith([
            'Token' => $this->curToken,
            'Value' => $this->curTokenIs(TokenType::TRUE),
        ]);
    }

    /**
     * @return Expression|null
     */
    protected function parseGroupedExpression() // :Expression
    {
        $this->nextToken();

        $exp = $this->parseExpression(self::LOWEST);

        if (!$this->expectPeek(TokenType::RPAREN)) {
            return null;
        }
        return $exp;
    }

    /**
     * @return Expression
     */
    protected function parseIfExpression() // :Expression
    {
        $expression = IfExpression::CreateWith([
            'Token' => $this->curToken,
        ]);

        if (!$this->expectPeek(TokenType::LPAREN)) {
            return null;
        }

        $this->nextToken();
        $expression->Condition = $this->parseExpression(self::LOWEST);

        if (!$this->expectPeek(TokenType::RPAREN)) {
            return null;
        }

        if (!$this->expectPeek(TokenType::LBRACE)) {
            return null;
        }

        $expression->Consequence = $this->parseBlockStatement();

        // 解析else 语句
        if ($this->peekTokenIs(TokenType::ELSE)) {
            $this->nextToken();

            if (!$this->expectPeek(TokenType::LBRACE)) {
                return null;
            }

            $expression->Alternative = $this->parseBlockStatement();
        }

        return $expression;
    }

    /**
     * @return Expression
     */
    protected function parseFunctionLiteral()// :Expression
    {
        $lit = FunctionLiteral::CreateWith([
            'Token' => $this->curToken,
        ]);

        if (!$this->expectPeek(TokenType::LPAREN)) {
            return null;
        }

        $lit->Parameters = $this->parseFunctionParameters();

        if (!$this->expectPeek(TokenType::LBRACE)) {
            return null;
        }

        $lit->Body = $this->parseBlockStatement();

        return $lit;
    }

    /**
     * @return array|Identifier[]
     */
    protected function parseFunctionParameters() //:Identifier[]
    {
        $identifiers = [];
        if ($this->peekTokenIs(TokenType::RPAREN)) {
            $this->nextToken();
            return $identifiers;
        }

        $this->nextToken();
        $ident = Identifier::CreateWith([
            'Token' => $this->curToken, 'Value' => $this->curToken->Literal,
        ]);
        $identifiers[] = $ident;
        while ($this->peekTokenIs(TokenType::COMMA)) {
            $this->nextToken();
            $this->nextToken();
            $ident = Identifier::CreateWith([
                'Token' => $this->curToken, 'Value' => $this->curToken->Literal,
            ]);
            $identifiers[] = $ident;
        }

        if (!$this->expectPeek(TokenType::RPAREN)) {
            return null;
        }
        return $identifiers;

    }

    /**
     * @param Expression $function
     * @return Expression
     */
    protected function parseCallExpression(Expression $function) //:Expression
    {
        $exp = CallExpression::CreateWith([
            'Token' => $this->curToken,
            'Function' => $function
        ]);
        $exp->Arguments = $this->parseCallArguments();
        return $exp;
    }

    /**
     * @return Expression[]|array
     */
    protected function parseCallArguments() //:Expression[]
    {
        $args = [] ;
        if($this->peekTokenIs(TokenType::RPAREN)){
            $this->nextToken() ;
            return $args ;
        }

        $this->nextToken() ;
        $args[] = $this->parseExpression(self::LOWEST ) ;

        while ($this->peekTokenIs(TokenType::COMMA)){
            $this->nextToken() ;
            $this->nextToken() ;

            $args[] = $this->parseExpression(self::LOWEST);
        }
        if(!$this->expectPeek(TokenType::RPAREN)){
            return null ;
        }
        return $args ;
    }

    /**
     * @return BlockStatement
     */
    protected function parseBlockStatement() // :BlockStatement
    {
        $block = BlockStatement::CreateWith([
            'Token' => $this->curToken,
        ]);
        $this->nextToken();

        while (!$this->curTokenIs(TokenType::RBRACE)) {
            $stmt = $this->parseStatement();
            if ($stmt) {
                $block->Statements[] = $stmt;
            }
            $this->nextToken();
        }
        return $block;
    }

    /**
     * @return Expression
     */
    public function parseIntegerLiteral()
    {
        // var_dump($this->curToken->Literal) ;
        $lit = IntegerLiteral::CreateWith([
            'Token' => $this->curToken,
        ]);
        try {
            $value = intval($this->curToken->Literal);
            // die("v: ".$value);
        } catch (\Exception $ex) {
            $msg = sprintf("could not parse %s as integer", $this->curToken->Literal);
            $this->errors[] = $msg;
            return null;
        }

        $lit->Value = $value;
        return $lit;
    }

    /**
     * @return LetStatement|null
     */
    protected function parseLetStatement()
    {
        $stmt = new LetStatement();
        $stmt->Token = $this->curToken;

        if (!$this->expectPeek(TokenType::IDENT)) {
            return null;
        }


        $stmt->Name = new Identifier();
        $stmt->Name->Token = $this->curToken;
        $stmt->Name->Value = $this->curToken->Literal;

        if (!$this->expectPeek(TokenType::ASSIGN)) {
            return null;
        }

        $this->nextToken() ;
        $stmt->Value = $this->parseExpression(self::LOWEST) ;

        for (; !$this->curTokenIs(TokenType::SEMICOLON);) {
            $this->nextToken();
        }
        // var_dump($stmt) ; die(__METHOD__) ;
        return $stmt;
    }

    /**
     * @return ReturnStatement
     */
    protected function parseReturnStatement() /*:?RetrunStatement */
    {
        $stmt = new ReturnStatement();
        $stmt->Token = $this->curToken;

        $this->nextToken();
        $stmt->ReturnValue = $this->parseExpression(self::LOWEST) ;

        for (; !$this->curTokenIs(TokenType::SEMICOLON);) {
            $this->nextToken();
        }
        return $stmt;
    }

    /**
     * @return ExpressionStatement
     */
    public function parseExpressionStatement() /* :ExpressionStatement */
    {
        $stmt = ExpressionStatement::CreateWith([
            'Token' => $this->curToken,
        ]);

        $stmt->Expression = $this->parseExpression(static::LOWEST);

        if ($this->peekTokenIs(TokenType::SEMICOLON)) {
            $this->nextToken();
        }
        return $stmt;
    }

    /**
     * @param int $precedence
     * @return Expression|null
     */
    protected function parseExpression($precedence) // :?Expression
    {
        /**
         * php7 新增三元运算符
         *  $prefix = ... ?? false  等价:
         * $prefix = isset($$this->prefixParseFns[$this->curToken->Type]) ? $this->prefixParseFns[$this->curToken->Type] : false;
         */
        $prefix = $this->prefixParseFns[$this->curToken->Type] ?? false;

        if (empty($prefix)) {
            $this->noPrefixParseFnError($this->curToken->Type);
            return null;
        }
        $leftExp = call_user_func($prefix); // $prefix() ;

        while (
            !$this->peekTokenIs(TokenType::SEMICOLON)
            && $precedence < $this->peekPrecedence()
        ) {
            $infix = $this->infixParseFns[$this->peekToken->Type] ?? null;
            if ($infix == null) {
                return $leftExp;
            }

            $this->nextToken();

            $leftExp = call_user_func($infix, $leftExp);
        }
        return $leftExp;
    }

    /**
     * @return Expression
     */
    public function parsePrefixExpression()/*:Expression*/
    {
        $expression = PrefixExpression::CreateWith([
            'Token' => $this->curToken,
            'Operator' => $this->curToken->Literal,
        ]);

        $this->nextToken();

        $expression->Right = $this->parseExpression(static::PREFIX);

        return $expression;
    }

    /**
     * @param Expression $left
     * @return Expression
     */
    protected function parseInfixExpression(Expression $left) //:Expression
    {
        $expression = InfixExpression::CreateWith([
            'Token' => $this->curToken,
            'Operator' => $this->curToken->Literal,
            'Left' => $left,
        ]);

        $precedence = $this->curPrecedence();
        $this->nextToken();
        $expression->Right = $this->parseExpression($precedence);

        return $expression;
    }

    /**
     * @param $tokenType
     * @return bool
     */
    protected function curTokenIs($tokenType): bool
    {
        return $this->curToken->Type == $tokenType;
    }

    /**
     * @param $tokenType
     * @return bool
     */
    protected function peekTokenIs($tokenType): bool
    {
        return $this->peekToken->Type == $tokenType;
    }

    /**
     * @param $tokenType
     * @return bool
     */
    protected function expectPeek($tokenType): bool
    {
        if ($this->peekTokenIs($tokenType)) {
            $this->nextToken();
            return true;
        }

        $this->peekError($tokenType);
        return false;
    }

    /**
     * @return array|string[]
     */
    public function Errors()
    {
        return $this->errors;
    }

    /**
     * @param $tokenType
     */
    protected function peekError($tokenType)
    {
        $msg = sprintf("expected next token to be %s, got %s instead",
            $tokenType, $this->peekToken->Type);
        $this->errors[] = $msg;
    }
}