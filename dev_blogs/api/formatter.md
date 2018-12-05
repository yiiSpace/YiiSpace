API 请求完成后 需要对对象进行格式化输出
====

基本调用流程：

frontend-controller ->  app-service  -> model --> dao 

所有的业务逻辑集中在 service层
~~~php

    class UserService 
    {
        /**
        * @RequestFill( searchModel )
        * @Transformer( some-transformer-implements )
        */
        public function query(UserSearch searchModel , int offset,  int limit, string sort )
        {
            ...
        }
    }
~~~
通过使用自定义注解 可以自己实现一些灵活处理 

### 格式化输出
参考这里的实现：

https://fractal.thephpleague.com/transformers/
League\Fractal\TransformerAbstract

~~~php

<?php namespace App\Transformer;

use Acme\Model\Book;
use League\Fractal\TransformerAbstract;

class BookTransformer extends TransformerAbstract
{
    /**
     * List of resources possible to include
     *
     * @var array
     */
    protected $availableIncludes = [
        'author'
    ];

    /**
     * Turn this item object into a generic array
     *
     * @return array
     */
    public function transform(Book $book)
    {
        return [
            'id'    => (int) $book->id,
            'title' => $book->title,
            'year'    => (int) $book->yr,
            'links'   => [
                [
                    'rel' => 'self',
                    'uri' => '/books/'.$book->id,
                ]
            ],
        ];
    }

    /**
     * Include Author
     *
     * @return \League\Fractal\Resource\Item
     */
    public function includeAuthor(Book $book)
    {
        $author = $book->author;

        return $this->item($author, new AuthorTransformer);
    }
}

~~~


### yii 中的serializer

use yii\rest\Serializer;


如果想结合这二者 为不同的模型 使用不同的stransformers
可以改写：
yii\rest\Serializer::serializeModel 方法

~~~php


    /**
     * Serializes a model object.
     * @param Arrayable $model
     * @return array the array representation of the model
     */
    protected function serializeModel($model)
    {
        if ($this->request->getIsHead()) {
            return null;
        }

        list($fields, $expand) = $this->getRequestedFields();
        // TODO 改写这里！
        return $model->toArray($fields, $expand);
    }
    ...
    
    // TODO  这里也需要改写
    /**
     * Serializes a set of models.
     * @param array $models
     * @return array the array representation of the models
     */
    protected function serializeModels(array $models)
    {
        list($fields, $expand) = $this->getRequestedFields();
        foreach ($models as $i => $model) {
            if ($model instanceof Arrayable) {
                $models[$i] = $model->toArray($fields, $expand);
            } elseif (is_array($model)) {
                $models[$i] = ArrayHelper::toArray($model);
            }
        }

        return $models;
    }
    
~~~