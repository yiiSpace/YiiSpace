<div class="test-default-index">
    <h1>浏览器端的 NOSql</h1>

    <a href="http://www.webhek.com/post/indexeddb.html">参考这里</a>

    <p>
        You may customize this page by editing the following file:<br>
        <code><?= __FILE__ ?></code>

        不成功！ 示例代码
    </p>

 <?php \year\widgets\JsBlock::begin()?>
    <script>

        window.indexedDB = window.indexedDB || window.mozIndexedDB || window.webkitIndexedDB || window.msIndexedDB;

        if(!window.indexedDB)
        {
            console.log("你的浏览器不支持IndexedDB");
        }

        var request = window.indexedDB.open("testDB", 2);

        var db;
        request.onerror = function(event){
            console.log("打开DB失败", event);
        }
        request.onupgradeneeded   = function(event){
            console.log("Upgrading");
            db = event.target.result;
            var objectStore = db.createObjectStore("students", { keyPath : "rollNo" });
        };
        request.onsuccess  = function(event){
            console.log("成功打开DB");
            db = event.target.result;
        }
        // -------------------------------------------------------------------------------  + |
        // var request = window.indexedDB.open("CandyDB","My candy store database");
        var request = window.indexedDB.open("CandyDB",1);
        request.onsuccess = function(event) {
            console.log(event);
           // var db = event.result;
            var db = event.target.result;
            if (db.version == "1") {
                // User's first visit, initialize database.
                var createdObjectStoreCount = 0;
                var objectStores = [
                    { name: "kids", keyPath: "id", autoIncrement: true },
                    { name: "candy", keyPath: "id", autoIncrement: true },
                    { name: "candySales", keyPath: "", autoIncrement: true }
                ];

                function objectStoreCreated(event) {
                    if (++createdObjectStoreCount == objectStores.length) {
                        db.setVersion("1").onsuccess = function(event) {
                            loadData(db);
                        };
                    }
                }

                for (var index = 0; index < objectStores.length; index++) {
                    var params = objectStores[index];
//                    request = db.createObjectStore(params.name, params.keyPath,
//                        params.autoIncrement);
                    request = db.createObjectStore(params.name, params);

                    request.onsuccess = objectStoreCreated;
                }
            }
            else {
                // User has been here before, no initialization required.
                loadData(db);
            }
        };
        // -------------------------------------------------------------------------------  + |

        var transaction = db.transaction(["students"],"readwrite");
        transaction.oncomplete = function(event) {
            console.log("Success");
        };

        transaction.onerror = function(event) {
            console.log("Error");
        };
        var objectStore = transaction.objectStore("students");

        var rollNo = 1 ;
        var name = 'yiispace' ;
        objectStore.add({rollNo: rollNo, name: name});

       // db.transaction(["students"],"readwrite").objectStore("students").delete(rollNo);

        var request = db.transaction(["students"],"readwrite").objectStore("students").get(rollNo);
        request.onsuccess = function(event){
            console.log("Name : "+request.result.name);
        };

        var transaction = db.transaction(["students"],"readwrite");
        var objectStore = transaction.objectStore("students");
        var request = objectStore.get(rollNo);
        request.onsuccess = function(event){
            name = name+'!' ;
            console.log("Updating : "+request.result.name + " to " + name);
            request.result.name = name;
            objectStore.put(request.result);
        };

    </script>
 <?php \year\widgets\JsBlock::end()?>

</div>
