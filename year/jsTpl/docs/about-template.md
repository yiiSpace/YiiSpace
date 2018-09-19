模板
=====

js 跟php 共享模板
---------------

已经有一些模板在做这样的事情了 比如mustcha twig 都分别有多语言版的

看个例子 [sharing-templates-between-php-and-javascript/](http://www.sitepoint.com/sharing-templates-between-php-and-javascript/)：
php

~~~

    {
        "require": {
            "mustache/mustache": "2.0.*"
        }
    }

~~~

~~~

    <?php
    require 'vendor/autoload.php';
     
    $tpl = new Mustache_Engine();
    echo $tpl->render('Hello, {{planet}}!', array('planet' => 'World'));
~~~
more:
~~~

    <?php
    $mustache = new Mustache_Engine(array(
       'loader' => new Mustache_Loader_FilesystemLoader('../templates')
    ));
     
    $tpl = $mustache->loadTemplate('greeting');
     
    echo $tpl->render(array('planet' => 'World'));
~~~

Sharing Templates between PHP and JavaScript
----

book template:
```
    {{#products}}
    {{#book}}
    <div>
    <p>Book Title: {{title}}</p>
    <p>Book Author: {{author}}</p>
    <p>Book Price: {{price}}</p>
    </div>
    {{/book}}
    {{/products}}
```
php 做法：
~~~
    
    <?php
    $books = array();
    $result = $db->query('SELECT title, author, price FROM books');
    while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
        $row['book'] = true;
        $books[] = $row;    
    }
    $result->closeCursor();
     
    $movies = array();
    $result = $db->query('SELECT name, price, cast FROM movies');
    while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
       $row['movie'] = true;
       $movies[] = $row;    
    }
     
    $booksTmpl = $this->mustache->loadTemplate('books');
    $moviesTmpl = $this->mustache->loadTemplate('movies');
     
    $data = array(
        'products' => array_merge($books, $movies)
    );
    $html = $booksTmpl->render($data);
    $html .= $moviesTmpl->render($data);
     
    echo $html;
~~~

js 端模板：
~~~

    <script id="booksTmpl" type="text/mustache">
    <?php
    echo file_get_contents(dirname(__FILE__) . '/templates/books.mustache');
    ?>
    </script>
    <script id="moviesTmpl" type="text/mustache">
    <?php
    echo file_get_contents(dirname(__FILE__) . '/templates/movies.mustache');?>
    </script>
~~~
~~~
    
    <script type="text/javascript" src="mustache.js"></script>
    /** ajax load json-data */

    <script>
    $("#booksFilter").click(function () {
       $.ajax({
           type: "GET",
           url: "ajax.php?type=books"
       }).done(function (msg) {
           var template = $("#booksTmpl").html();
           var output = Mustache.render(template, msg);
           $("#products").html(output);
       });
    });
    </script>
~~~
