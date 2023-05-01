
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