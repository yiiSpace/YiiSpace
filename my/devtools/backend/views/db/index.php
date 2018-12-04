<?php
/* @var $this yii\web\View */
/* @var $dbSchema yii\db\Schema */
?>
<h1>api/index</h1>

<p>
    You may change the content of this page by modifying
    the file <code><?= __FILE__; ?></code>.
</p>
<?php
/**
 * 返回指定表的评论
 *
 * @see http://stackoverflow.com/questions/5664094/getting-list-of-table-comments-in-postgresql
 */
$getCommentOnTable = function ( $table ) {
    /**
     * @see http://stackoverflow.com/questions/11493978/how-to-retrieve-the-comment-of-a-postgresql-database
     */
    $sql = <<<SQL
    SELECT description
FROM   pg_description
WHERE  objoid = 'wito.{$table}'::regclass;
SQL;
    $sql = <<<SQL
    select description from pg_description
    join pg_class on pg_description.objoid = pg_class.oid
    where relname = '{$table}'
    -- and nspname='<schema name>
SQL;

    $info = Yii::$app->db->createCommand($sql)->queryScalar();

    return $info;
};
?>
<?php $tableIdx = 0 ; ?>
<?php foreach ($dbSchema->getTableSchemas('wito') as $tableSchema) : ?>

    <div class="panel panel-success">
        <!-- Default panel contents -->
        <div class="panel-heading">( <?= ++$tableIdx ?> ) 表 ： <?= $tableSchema->name ?> </div>
        <div class="panel-body">
            <p>
                表注释：
                <?= $getCommentOnTable($tableSchema->name); ?>
            </p>
        </div>

        <!-- Table -->
        <table class="table">
            <thead>
            <tr>
                <th>#</th>
                <th>表字段名</th>
                <th>类型</th>
                <th>注释</th>
            </tr>
            </thead>
            <tbody>
            <?php $columnIdx = 0; ?>
            <?php foreach ($tableSchema->columns as $columnSchema): ?>
                <tr>
                    <th scope="row"><?= ++$columnIdx; ?></th>
                    <td><?= $columnSchema->name ?></td>
                    <td><?= $columnSchema->dbType ?></td>
                    <td><?= $columnSchema->comment ?></td>
                </tr>
            <?php endforeach ?>
            </tbody>
        </table>
    </div>

<?php endforeach ?>


<?php \year\widgets\HighLightJsAsset::register($this); ?>

<?php \year\widgets\JsBeautifyAsset::register($this) ?>

<?php \year\widgets\JsBlock::begin() ?>
<script>
    $(function () {

        $('code').each(function () {
            // console.log(this);
            $(this).text(js_beautify($(this).text()));

        });
        $('code').wrap('<pre></pre>');

        /*
         // 代码高亮
         hljs.configure({useBR: true});
         $('code').each(function (i, block) {
         hljs.highlightBlock(block);
         });
         */
    });
</script>
<?php \year\widgets\JsBlock::end() ?>
