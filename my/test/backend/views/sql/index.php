<?php

use yii\helpers\Html;

``
/* @var $this yii\web\View */
?>

<div class="test-sql-index">
    <h1><?= $this->context->action->uniqueId ?></h1>
    <p>
        This is the view content for action "<?= $this->context->action->id ?>".
        The action belongs to the controller "<?= get_class($this->context) ?>"
        in the "<?= $this->context->module->id ?>" module.
    </p>
    <p>
        You may customize this page by editing the following file:<br>
        <code><?= __FILE__ ?></code>
    </p>


    <h3>
        Layout: <?= Yii::$app->controller->findLayoutFile($this) ?>
    </h3>

    <h4>
        测试下对sql order by 子句的正则验证！
    </h4>
    https://github.com/CollaboratingPlatypus/PetaPoco/blob/development/PetaPoco/Utilities/PagingHelper.cs
    微软的正则 跟开源的不兼容么？
    // $pattern1 = "\bORDER\s+BY\s+(?!.*?(?:\)|\s+)AS\s)(?:\((?>\((?
    <depth>)|\)(?<-depth>)|.?)*(?(depth)(?!))\)|[\[\]`""\w\(\)\.])+(?:\s+(?:ASC|DESC))?(?:\s*,\s*(?:\((?>\((?
        <depth>)|\)(?<-depth>)|.?)*(?(depth)(?!))\)|[\[\]`""\w\(\)\.])+(?:\s+(?:ASC|DESC))?)*";
            // "\w[\w\d]*(\s+(asc|desc))?(\s*,\s*\w[\w\d]*\s+(asc|desc))*";
            // https://www.cnblogs.com/JimmyZhang/archive/2008/09/27/1300939.html

            <?php
            $patten = "@\w[\w\d]*(\s+(asc|desc))?(\s*,\s*\w[\w\d]*\s+(asc|desc))*@i";
            $subject = "abc desc";
            if (preg_match($patten, $subject, $matches) == false) {
                echo "not match!";
            } else {
                // 匹配啦
                print_r($matches);
            }

            ?>

</div>
