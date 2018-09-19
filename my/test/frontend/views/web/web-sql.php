<div class="test-default-index">
    <h1>浏览器端的 sql(sqlite)</h1>

    <a href="http://www.webhek.com/post/indexeddb.html">参考这里</a>

 <?php \year\widgets\JsBlock::begin()?>
    <script>
        var db = openDatabase('testDB', '1.0', 'Test DB', 2 * 1024 * 1024);

        db.transaction(function (context) {
            context.executeSql('CREATE TABLE IF NOT EXISTS testTable (id unique, name)');
            context.executeSql('INSERT INTO testTable (id, name) VALUES (0, "Byron")');
            context.executeSql('INSERT INTO testTable (id, name) VALUES (1, "Casper")');
            context.executeSql('INSERT INTO testTable (id, name) VALUES (2, "Frank")');
        });

        db.transaction(function (context) {
            context.executeSql('SELECT * FROM testTable', [], function (context, results) {
                var len = results.rows.length, i;
                console.log('Got '+len+' rows.');
                for (i = 0; i < len; i++){
                    console.log('id: '+results.rows.item(i).id);
                    console.log('name: '+results.rows.item(i).name);
                }
            });
        });
    </script>
 <?php \year\widgets\JsBlock::end()?>

<code>
 >

    up vote
    6
    down vote
    IE10 supports IndexedDB. You can also use localStorage in IE8+. For older versions, you can use proprietary userData behavior: http://www.javascriptkit.com/javatutors/domstorage2.shtml

    Please note that WebSQL database is deprecated and specification is no longer maintained.

</code>


</div>
