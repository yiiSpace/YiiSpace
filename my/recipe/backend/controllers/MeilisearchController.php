<?php

namespace my\recipe\backend\controllers;

use Meilisearch\Client;

/**
 * - 环境变量是可选的，默认是 developer 模式，可以不设置 master key ，只有在指定为 product 模式才必须设置的
 */
class MeilisearchController extends \yii\web\Controller
{
    public function actionIndex()
    {
        $client = new Client('http://127.0.0.1:7700', 'eso2woB3HBxwdQQCgAoqHi1AanomWly7jVOYc70M0uA');

# An index is where the documents are stored.
        $index = $client->index('movies');

        $documents = [
            ['id' => 1,  'title' => 'Carol', 'genres' => ['Romance, Drama']],
            ['id' => 2,  'title' => 'Wonder Woman', 'genres' => ['Action, Adventure']],
            ['id' => 3,  'title' => 'Life of Pi', 'genres' => ['Adventure, Drama']],
            ['id' => 4,  'title' => 'Mad Max: Fury Road', 'genres' => ['Adventure, Science Fiction']],
            ['id' => 5,  'title' => 'Moana', 'genres' => ['Fantasy, Action']],
            ['id' => 6,  'title' => 'Philadelphia', 'genres' => ['Drama']],
        ];

# If the index 'movies' does not exist, Meilisearch creates it when you first add the documents.
        $index->addDocuments($documents); // => { "uid": 0 }
// Meilisearch is typo-tolerant:
        $hits = $index->search('wondre woman')->getHits();
        $result = print_r($hits , true);
        return $this->renderContent($result) ;

//        return $this->render('index');
    }

}
