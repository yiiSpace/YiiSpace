
原生php学习

## 不错的第三方库：

-   `php-nlp-tools` :
@see https://www.yii666.com/learning/php/247.html
~~~php

use \NlpTools\Tokenizers\WhitespaceTokenizer;
use \NlpTools\Tokenizers\RegexTokenizer;
use \NlpTools\Stemmers\PorterStemmer;
use \NlpTools\Documents\Document;

// 设置需要分析的文章
$doc = new Document("This is an example article about PHP and natural language processing.");

// 使用 WhitespaceTokenizer 或 RegexTokenizer 进行分词
$tokenizer = new WhitespaceTokenizer();
$tokens = $tokenizer->tokenize($doc->getText());

// 对关键词进行词干提取
$stemmer = new PorterStemmer();
$stemmed_tokens = array_map([$stemmer, 'stem'], $tokens);

// 获取前 N 个出现频率最高的关键词
$top_n = 5;
$word_counts = array_count_values($stemmed_tokens);
arsort($word_counts);
$keywords = array_slice(array_keys($word_counts), 0, $top_n);

~~~

- [php-代码生成](https://github.com/nette/php-generator)
- [php 学习资源](http://www.hackingwithphp.com/)
- [A PHP library for representing and manipulating collections.](https://github.com/ramsey/collection)
    表示和操纵集合的库
- [facker](https://fakerphp.github.io/) 当下推荐的库 
  原来的 [另一个仓库](https://github.com/fzaninotto/Faker)下那个已经不推荐使用了 不过yii2还是依赖的那个老库
    新库功能更多点
    TODO: 可以为每个数据库中的表 在webui上生成一个facker的代码片段 数据库中的表可以方便的列出 然后把每个字段对应到facker的方法上即可！

- float、double 类型 一般各语言都会丢失精度， 可用大数计算方案，php里就是bcmath 每个语言基本都有对应的方案跟库可用
  电商db 价格字段类型有待考虑 decimal比较占用空间，但至少不会丢失精度，但计算时候得用bc decimal本质上是varchar
  也可以考虑直接存成整数 到分 精度更高可以bigint

### nette团队作品
它们家有一堆php库 
- [反射类库 对反射扩展库有额外的功能扩充](https://github.com/nette/reflection)
    现在已经被废弃 但有些地方仍可以使用 另外替代品是betterreflection
- [ease debugging PHP code for cool developers](https://github.com/nette/tracy)
    还是nette团队作品 
- [php 表单](https://github.com/nette/forms)
- [生成代码的库](https://github.com/nette/php-generator)
- [工具类库集合](https://github.com/nette/utils)
  无论如何 你当工人 👷‍♀️👷腰带上得拴点工具🔧吧！😄
- 其他[...](https://github.com/nette) 自己看吧

## 杂项

create_function 8以上就被移除了 
有个库 rector/rector 用来替换该方法为匿名方法 一比一替换： https://stackoverflow.com/questions/48161526/php-7-2-function-create-function-is-deprecated

https://github.com/elkaadka/Enuma 这个库跟nette创建类代码那个有点像

https://github.com/nikic/PHP-Parser 语法解析

## php值得注意的特性
- https://www.php.net/manual/en/function.class-alias.php