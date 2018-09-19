<?php
/**
 * Created by PhpStorm.
 * User: yiqing
 * Date: 2015/6/7
 * Time: 11:39
 */
 $asset = \year\widgets\ToMarkDownAsset::register($this);
$asset->jsOptions = [
     'position' => \yii\web\View::POS_HEAD,
];
?>

<script>
    alert(toMarkdown('<h1>Hello world!</h1>'));
</script>

<?= Yii::$app->request->baseUrl ?>
<?= Yii::getAlias('@web') ?>
