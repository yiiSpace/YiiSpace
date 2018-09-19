<div class="test-default-index">
    <h1>浏览器端的 NOSql</h1>

    <a href="https://www.html5rocks.com/en/tutorials/webdatabase/websql-indexeddb/">参考这里</a>
    <a href="http://w3c.github.io/IndexedDB/">参考这里</a>
    <a href="https://nolanlawson.com/2015/09/29/indexeddb-websql-localstorage-what-blocks-the-dom/">参考这里</a>
    <a href="https://www.html5rocks.com/en/tutorials/webdatabase/websql-indexeddb/">参考这里</a>

    <p>
        You may customize this page by editing the following file:<br>
        <code><?= __FILE__ ?></code>

    </p>


    <form>
        Roll No <input type="text" name="rollno" id="rollno"/><br>
        Name <input type="text" name="name" id="name" /><br>
        <input type="button" name="addBtn" value="Add" id="addBtn"/>
        <input type="button" name="removeBtn" value="Remove" id="removeBtn"/>
        <input type="button" name="getBtn" value="Get" id="getBtn"/>
        <input type="button" name="updateBtn" value="Update" id="updateBtn"/>
    </form>
    <div id="result"></div>


    <?php \year\widgets\JsBlock::begin()?>
    <script>

        $(document).ready(function(){
            window.indexedDB = window.indexedDB || window.mozIndexedDB || window.webkitIndexedDB || window.msIndexedDB;
            var request, db;

            if(!window.indexedDB)
            {
                console.log("Your Browser does not support IndexedDB");
            }
            else
            {
                request = window.indexedDB.open("testDB", 2);
                request.onerror = function(event){
                    console.log("Error opening DB", event);
                }
                request.onupgradeneeded   = function(event){
                    console.log("Upgrading");
                    db = event.target.result;
                    var objectStore = db.createObjectStore("students", { keyPath : "rollNo" });
                };
                request.onsuccess  = function(event){
                    console.log("Success opening DB");
                    db = event.target.result;
                }
            }

            $("#addBtn").click(function(){
                var name = $("#name").val();
                var rollNo = $("#rollno").val();

                var transaction = db.transaction(["students"],"readwrite");
                transaction.oncomplete = function(event) {
                    console.log("Success :)");
                    $("#result").html("Add : Success");
                };

                transaction.onerror = function(event) {
                    console.log("Error :(");
                    $("#result").html("Add : Error");
                };
                var objectStore = transaction.objectStore("students");

                objectStore.add({rollNo: rollNo, name: name});
            });

            $("#removeBtn").click(function(){
                var rollNo = $("#rollno").val();
                db.transaction(["students"],"readwrite").objectStore("students").delete(rollNo);
            });
            $("#getBtn").click(function(){
                var rollNo = $("#rollno").val();
                var request = db.transaction(["students"],"readwrite").objectStore("students").get(rollNo);
                request.onsuccess = function(event){
                    $("#result").html("Name : "+request.result.name);
                };
            });

            $("#updateBtn").click(function(){
                var rollNo = $("#rollno").val();
                var name = $("#name").val();
                var transaction = db.transaction(["students"],"readwrite");
                var objectStore = transaction.objectStore("students");
                var request = objectStore.get(rollNo);
                request.onsuccess = function(event){
                    $("#result").html("Updating : "+request.result.name + " to " + name);
                    request.result.name = name;
                    objectStore.put(request.result);
                };
            });
        });


    </script>
    <?php \year\widgets\JsBlock::end()?>

</div>
