JsTree widget
----------------

~~~

<?= year\widgets\JsTree::widget() ?>

<script>
    $(function() {
        $('#container').jstree(/* optional config object here */
            {
                "plugins" : [ "unique", "dnd" ,"contextmenu"]
            }
        );
    });
</script>
<div id="container">
    <ul>
        <li>Root node
            <ul>
                <li id="child_node">Child node</li>
                <li id="child_node">Child node2</li>
            </ul>
        </li>
    </ul>
</div>

~~~